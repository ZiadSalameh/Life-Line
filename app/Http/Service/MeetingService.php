<?php

namespace App\Http\Service;

use App\Models\Meeting;


class MeetingService extends BaseService
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
            return $this->error('Meeting not found', 404, [
                'meeting' => null
            ]);
        }

        return $this->success([
            'meeting' => $meeting
        ], 'Meeting retrieved successfully', 200);
    }

    public function AddMeeting(array $data): array
    {
        $meeting = Meeting::create([
            'meeting_no' => $data['meeting_no'],
            'description' => $data['description'],
            'DateTime' => $data['DateTime'] ?? null,
        ]);
        return $this->success([
            'meeting' => $meeting
        ], 'Meeting retrieved successfully', 200);
    }

    public function UpdateMeeting(array $data, $id)
    {
        $meeting = Meeting::find($id);
        if (!$meeting) {
            return $this->error('Meeting not found', 404, [
                'meeting' => null
            ]);
        }
        $meeting->update($data);
        return $this->success([
            'meeting' => $meeting
        ], 'Meeting updated successfully', 200);
    }

    public function DeleteMeeting($id)
    {
        $meeting = Meeting::find($id);
        if (!$meeting) {
            return $this->error('Meeting not found', 404, [
                'meeting' => null
            ]);
        }

        $meeting->delete();
        return $this->success([
            'meeting' => $meeting
        ], 'Meeting deleted successfully', 200);
    }

    public function addUsers(int $meetingId, array $userIds): array
    {
        $meeting = Meeting::with('users')->find($meetingId);

        if (!$meeting) {
            return $this->error('Meeting not found', 404, [
                'meeting' => null
            ]);
        }

        $currentUserIds = $meeting->users->pluck('id')->toArray();
        $newUserIds = array_diff($userIds, $currentUserIds);

        if (empty($newUserIds)) {
            return $this->error('All users are already assigned to this meeting', 409, [
                'meeting' => null
            ]);
        }

        $meeting->users()->attach($newUserIds);

        return $this->success([
            'meeting' => $meeting->load('users')
        ], 'Users assigned successfully', 200);
    }

    public function removeUsers(int $meetingId, array $userIds): array
    {
        $meeting = Meeting::with('users')->find($meetingId);

        if (!$meeting) {
            return $this->error('Meeting not found', 404, [
                'meeting' => null
            ]);
        }

        $currentUserIds = $meeting->users->pluck('id')->toArray();
        $existingUserIds = array_intersect($userIds, $currentUserIds);

        if (empty($existingUserIds)) {
            return $this->error('None of the selected users are assigned to this meeting', 409, [
                'meeting' => null
            ]);
        }

        $meeting->users()->detach($existingUserIds);

        return $this->success([
            'meeting' => $meeting->load('users')
        ], 'Users removed successfully', 200);
    }
}
