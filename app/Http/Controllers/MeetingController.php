<?php

namespace App\Http\Controllers;

use App\DTOs\MeetingDTO\MeetingDto;
use App\Http\Requests\StoreMeetingRequest;
use App\Http\Requests\UpdateMeetingRequest;
use App\Http\Resources\MeetingResource;
use App\Http\Service\MeetingService;
use Carbon\Carbon;
use Illuminate\Http\Request;


class MeetingController extends Controller
{
    public function __construct(private MeetingService $meetingService)
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
        $data = new MeetingDto(
            meeting_no: $validateDate['meeting_no'],
            description: $validateDate['description'],
            DateTime: isset($validateDate['DateTime']) ? Carbon::parse($validateDate['DateTime']) : null,
        );
        $meeting = $this->meetingService->AddMeeting($data);
        return response()->json([
            'meeting' => new MeetingResource($meeting['meeting']),
            'message' => $meeting['message']
        ], 201);
    }

    public function UpdateMeeting(UpdateMeetingRequest $request, $id)
    {
        $validateDate = $request->validated();
        $meeting = new MeetingDto(
            meeting_no: $validateDate['meeting_no'],
            description: $validateDate['description'],
            DateTime: isset($validateDate['DateTime']) ? Carbon::parse($validateDate['DateTime']) : null,
        );
        $result = $this->meetingService->UpdateMeeting($meeting, $id);
        return response()->json([
            'message' => $result['message'],
            'meeting' => $result['success']
                ? new MeetingResource($result['meeting'])
                : null
        ], $result['status']);
    }


    public function DeleteMeeting($id)
    {
        $this->meetingService->DeleteMeeting($id);
        return response()->json([
            'success' => true,
            'message' => 'Meeting deleted successfully'
        ], 200);
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
