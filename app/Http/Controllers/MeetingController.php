<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMeetingRequest;
use App\Http\Requests\UpdateMeetingRequest;
use App\Http\Resources\BoardDeeResource;
use App\Http\Resources\MeetingResource;
use App\Http\Service\MeetingService;
use App\Models\BoardDee;
use App\Models\Meeting;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;


class MeetingController extends Controller
{
    private MeetingService $meetingService;
    public function __construct(MeetingService $meetingService)
    {
        $this->meetingService = $meetingService;
    }

    public function GetAllMettings()
    {
        $meetings = $this->meetingService->getAllMeetings();
        return MeetingResource::collection($meetings);
    }

    public function GetMeeting($id)
    {
        $result = $this->meetingService->getMeetingById($id);

        return response()->json([
            'message' => $result['message'],
            'meeting' => $result['success']
                ? new MeetingResource($result['meeting'])
                : null
        ], $result['status']);
    }

    public function AddMeeting(StoreMeetingRequest $request)
    {
        $validateDate = $request->validated();
        $meeting = $this->meetingService->AddMeeting($validateDate);
        return response()->json([
            'meeting' => new MeetingResource($meeting['meeting']),
            'message' => $meeting['message']
        ], 201);
    }

    public function UpdateMeeting(UpdateMeetingRequest $request, $id)
    {
        $result = $this->meetingService->UpdateMeeting(
            $request->validated(),
            $id
        );
        return response()->json([
            'message' => $result['message'],
            'meeting' => $result['success']
                ? new MeetingResource($result['meeting'])
                : null
        ], $result['status']);
    }


    public function DeleteMeeting($id)
    {
        $meeting = $this->meetingService->DeleteMeeting($id);
        return response()->json([
            'message' => $meeting['message'],
            'meeting' => $meeting['success']
                ? new MeetingResource($meeting['meeting'])
                : null
        ], $meeting['status']);
    }

    public function addUser(Request $request, $meetingId)
    {
        $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id'
        ]);

        $result = $this->meetingService->addUsers($meetingId, $request->user_ids);

        return response()->json([
            'message' => $result['message'],
            'meeting' => $result['success']
                ? new MeetingResource($result['meeting'])
                : null
        ], $result['status']);
    }

    public function removeUser(Request $request, $meetingId)
    {
        $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id'
        ]);

        $result = $this->meetingService->removeUsers($meetingId, $request->user_ids);

        return response()->json([
            'message' => $result['message'],
            'meeting' => $result['success']
                ? new MeetingResource($result['meeting'])
                : null
        ], $result['status']);
    }
}
