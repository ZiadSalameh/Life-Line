<?php

namespace App\Http\Service;

use App\Models\Meeting;


class MeetingService
{
    public function  getAllMeetings()
    {
        $meetings =  Meeting::with('users')->get();
        return $meetings;
    }

    public function getMeetingById($id)
    {
        $meeting = Meeting::with('users')->find($id);

        if (!$meeting) {
            return [
                'success' => false,
                'message' => 'Meeting not found',
                'status' => 404,
                'meeting' => null
            ];
        }

        return [
            'success' => true,
            'message' => 'Meeting retrieved successfully',
            'status' => 200,
            'meeting' => $meeting
        ];
    }

    public function AddMeeting(array $data): array
    {
        $meeting = Meeting::create([
            'meeting_no' => $data['meeting_no'],
            'description' => $data['description'],
            'DateTime' => $data['DateTime'] ?? null,
        ]);
        return [
            'meeting' => $meeting,
            'message' => 'Meeting created successfully',
        ];
    }

    public function UpdateMeeting(array $data, $id)
    {
        $meeting = Meeting::find($id);
        if (!$meeting) {
            return [
                'success' => false,
                'message' => 'Meeting not found',
                'status' => 404,
                'meeting' => null
            ];
        }

        // $exists = Meeting::where('meeting_no', $data['meeting_no'])
        //     ->where('id', '!=', $id)
        //     ->exists();

        // if ($exists) {
        //     return [
        //         'success' => false,
        //         'message' => 'Meeting number already exists',
        //         'status' => 422,
        //         'meeting' => null
        //     ];
        // }

        $meeting->update($data);
        return [
            'success' => true,
            'message' => 'Meeting updated successfully',
            'status' => 200,
            'meeting' => $meeting
        ];
    }

    public function DeleteMeeting($id)
    {
        $meeting = Meeting::find($id);
        if (!$meeting) {
            return [
                'success' => false,
                'message' => 'Meeting not found',
                'status' => 404,
                'meeting' => null
            ];
        }

        $meeting->delete();
        return [
            'success' => true,
            'message' => 'Meeting deleted successfully',
            'status' => 200,
            'meeting' => $meeting
        ];
    }

    public function addUsers(int $meetingId, array $userIds): array
    {
        $meeting = Meeting::with('users')->find($meetingId);

        if (!$meeting) {
            return [
                'success' => false,
                'message' => 'Meeting not found',
                'status' => 404,
                'meeting' => null
            ];
        }

        $currentUserIds = $meeting->users->pluck('id')->toArray();
        $newUserIds = array_diff($userIds, $currentUserIds);

        if (empty($newUserIds)) {
            return [
                'success' => false,
                'message' => 'All users are already assigned to this meeting',
                'status' => 409,
                'meeting' => null
            ];
        }

        $meeting->users()->attach($newUserIds);

        return [
            'success' => true,
            'message' => 'Users assigned successfully',
            'status' => 200,
            'meeting' => $meeting->load('users')
        ];
    }

    public function removeUsers(int $meetingId, array $userIds): array
    {
        $meeting = Meeting::with('users')->find($meetingId);

        if (!$meeting) {
            return [
                'success' => false,
                'message' => 'Meeting not found',
                'status' => 404,
                'meeting' => null
            ];
        }

        $currentUserIds = $meeting->users->pluck('id')->toArray();
        $existingUserIds = array_intersect($userIds, $currentUserIds);

        if (empty($existingUserIds)) {
            return [
                'success' => false,
                'message' => 'None of the selected users are assigned to this meeting',
                'status' => 409,
                'meeting' => null
            ];
        }

        $meeting->users()->detach($existingUserIds);

        return [
            'success' => true,
            'message' => 'Users removed successfully',
            'status' => 200,
            'meeting' => $meeting->load('users')
        ];
    }
}
