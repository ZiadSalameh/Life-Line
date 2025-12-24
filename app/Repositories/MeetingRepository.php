<?php

namespace App\Repositories;

use App\DTOs\MeetingDTO\MeetingDto;
use App\Models\Meeting;
use App\Interfaces\Meeting\MeetingRepositoryInterface;
use Illuminate\Support\Collection;

class MeetingRepository implements MeetingRepositoryInterface
{
    public function create(meetingDto $meetingDto): Meeting
    {
        return Meeting::create([
            'meeting_no' => $meetingDto->meeting_no,
            'description' => $meetingDto->description ?? null,
            'DateTime' => $meetingDto->DateTime ?? null,
        ]);
    }

    public function update($id, MeetingDto $meetingDto): Meeting
    {
        $meeting = Meeting::findOrFail($id);
        $meeting->update([
            'meeting_no' => $meetingDto->meeting_no,
            'description' => $meetingDto->description  ?? null,
            'DateTime' => $meetingDto->DateTime ?? null,
        ]);
        return $meeting;
    }

    public function delete($id): bool
    {
        $meeting = Meeting::findOrFail($id);
        return $meeting->delete();
    }

    public function getAll(): Collection
    {
        return Meeting::all();
    }

    public function getOne(int $id): Meeting
    {
        return Meeting::findOrFail($id);
    }

    public function attachUsers(int $meetingId, array $userIds): Meeting
    {
        $meeting = Meeting::findOrFail($meetingId);

        $meeting->users()->attach($userIds);

        return $meeting->load('users');
    }

    public function detachUsers(int $meetingId, array $userIds): Meeting
    {
        $meeting = Meeting::findOrFail($meetingId);

        $meeting->users()->detach($userIds);

        return $meeting->load('users');
    }
}
