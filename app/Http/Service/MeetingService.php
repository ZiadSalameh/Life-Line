<?php

namespace App\Http\Service;

use App\DTOs\MeetingDTO\MeetingDto;
use App\Interfaces\Meeting\MeetingRepositoryInterface;
use App\Models\Meeting;
use Exception;

class MeetingService extends BaseService
{
    public function __construct(
        private MeetingRepositoryInterface $meetingRepository
    ) {}
    public function  getAllMeetings()
    {
        $meeting = $this->meetingRepository->getAll();
        return $meeting;
    }

    public function getMeetingById($id)
    {
        $meeting = $this->meetingRepository->getOne($id);
        return $this->success([
            'meeting' => $meeting
        ], 'Meeting retrieved successfully', 200);
    }

    public function AddMeeting(MeetingDto $meetingDto): array
    {
        $meeting = $this->meetingRepository->create($meetingDto);
        return $this->success([
            'meeting' => $meeting
        ], 'Meeting retrieved successfully', 200);
    }

    public function UpdateMeeting(MeetingDto $meetingDto, $id): array
    {
        $meeting = $this->meetingRepository->update($id, $meetingDto);
        return $this->success([
            'meeting' => $meeting
        ], 'Meeting updated successfully', 200);
    }

    public function DeleteMeeting($id)
    {
        return $this->meetingRepository->delete($id);
    }

    public function addUsers(int $meetingId, array $userIds): array
    {
        $meeting = $this->meetingRepository->getOne($meetingId);

        $currentUserIds = $meeting->users->pluck('id')->toArray();
        $newUserIds = array_diff($userIds, $currentUserIds);

        if (empty($newUserIds)) {
            return $this->error(
                'All users are already assigned to this meeting',
                409,
                ['meeting' => null]
            );
        }

        $meeting = $this->meetingRepository->attachUsers(
            $meetingId,
            $newUserIds
        );

        $currentUserIds = $meeting->users->pluck('id')->toArray();
        $newUserIds = array_diff($userIds, $currentUserIds);

        if (empty($newUserIds)) {
            return $this->error(
                'All users are already assigned to this meeting',
                409,
                ['meeting' => null]
            );
        }
        return $this->success([
            'meeting' => $meeting
        ], 'Users assigned successfully', 200);
    }


    public function removeUsers(int $meetingId, array $userIds): array
    {
        $meeting = $this->meetingRepository->detachUsers($meetingId, $userIds);
        return $this->success([
            'meeting' => $meeting
        ], 'Users removed successfully', 200);


        $currentUserIds = $meeting->users->pluck('id')->toArray();
        $existingUserIds = array_intersect($userIds, $currentUserIds);


        $meeting = Meeting::with('users')->find($meetingId);

        if (!$meeting) {
            return $this->error('Meeting not found', 404, [
                'meeting' => null
            ]);
        }
    }
}
