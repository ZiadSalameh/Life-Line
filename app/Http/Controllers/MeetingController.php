<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMeetingRequest;
use App\Http\Requests\UpdateMeetingRequest;
use App\Http\Resources\BoardDeeResource;
use App\Http\Resources\MeetingResource;
use App\Models\BoardDee;
use App\Models\Meeting;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function GetAllMettings()
    {
        $meetings = Meeting::with('users')->get();
        return MeetingResource::collection($meetings);
    }



    public function AddMeeting(StoreMeetingRequest $request)
    {
        $validateDate = $request->validated();
        $existdata = Meeting::where('meeting_no', $validateDate['meeting_no'])->exists();
        if ($existdata) {
            return response()->json([
                'message' => 'Meeting already exists'
            ], 422);
        }
        $meeting = Meeting::create($validateDate);

        return response()->json([
            'meeting' => new MeetingResource($meeting)
        ], 201);
    }

    public function GetMeeting($id)
    {
        try {
            $meeting = Meeting::with('users')->findOrFail($id);
            return new MeetingResource($meeting);
        } catch (Exception $e) {
            return response()->json(['message' => 'Not found'], 404);
        }
    }



    public function UpdateMeeting(UpdateMeetingRequest $request, $id)
    {
        try {
            $meeting = Meeting::findOrFail($id);
            $existdata = Meeting::where('meeting_no', $request->meeting_no)->exists();
            if ($existdata) {
                return response()->json([
                    'message' => 'Meeting already exists'
                ], 422);
            }
            $meeting->update($request->validated());
            return response()->json([
                'message' => 'Meeting updated successfully',
                'meeting' => new MeetingResource($meeting)
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Not found'], 404);
        }
    }


    public function DeleteMeeting($id)
    {
        try {
            $meeting = Meeting::findOrFail($id);
            $meeting->delete();
            return response()->json(['message' => 'Meeting deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Not found'], 404);
        }
    }



    public function addUser(Request $request, $meetingId)
    {
        $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id'
        ]);

        try {
            $meeting = Meeting::with('users')->findOrFail($meetingId);

            $newUserIds = array_diff($request->user_ids, $meeting->users->pluck('id')->toArray());

            if (empty($newUserIds)) {
                return response()->json([
                    'message' => 'All users are already assigned to this meeting'
                ], 409);
            }

            $meeting->users()->attach($newUserIds);

            return response()->json([
                'message' => 'Users assigned successfully',
                'meeting' => new MeetingResource($meeting->load('users'))
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Meeting not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while processing your request',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }


    public function removeUser(Request $request, $meetingId)
    {
        $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id'
        ]);

        try {
            $meeting = Meeting::with('users')->findOrFail($meetingId);

            $currentUserIds = $meeting->users->pluck('id')->toArray();

            $existingUserIds = array_intersect($request->user_ids, $currentUserIds);

            if (empty($existingUserIds)) {
                return response()->json([
                    'message' => 'None of the selected users are assigned to this meeting'
                ], 409);
            }

            $meeting->users()->detach($existingUserIds);

            return response()->json([
                'message' => 'Users removed successfully',
                'meeting' => new MeetingResource($meeting->load('users'))
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Meeting not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while processing your request',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }


    // public function GetAllboardDees($id)
    // {
    //     try {
    //         $meeting = Meeting::with('boardDees')->findOrFail($id);
    //         if ($meeting->boardDees->isEmpty()) {
    //             return response()->json([
    //                 'message' => 'No board dees found for this meeting'
    //             ], 404);
    //         }
    //         return response()->json([
    //             'message' => 'Board dees retrieved successfully',
    //             'boards' => BoardDeeResource::collection($meeting->boardDees)
    //         ], 200);
    //     } catch (ModelNotFoundException $e) {
    //         return response()->json([
    //             'message' => 'Meeting not found'
    //         ], 404); 
    //     } catch (Exception $e) {
    //         return response()->json([
    //             'message' => 'An error occurred while processing your request',
    //             'error' => config('app.debug') ? $e->getMessage() : null
    //         ], 500);
    //     }
    // }
}
