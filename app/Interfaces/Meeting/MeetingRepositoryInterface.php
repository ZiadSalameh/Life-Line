<?php

namespace App\Interfaces\Meeting;

use App\DTOs\MeetingDTO\MeetingDto;
use App\Models\Meeting;
use Illuminate\Support\Collection;

interface MeetingRepositoryInterface
{
    public function create(MeetingDto $meetingDto): Meeting;
    public function update($id, MeetingDto $meetingDto): Meeting;
    public function delete($id): bool;
    public function getAll(): Collection;
    public function getOne(int $id): Meeting;
    public function attachUsers(int $meetingId, array $userIds): Meeting;
    public function detachUsers(int $meetingId, array $userIds): Meeting;
}
