<?php

namespace App\Http\Service;

use App\DTOs\BoardDtos\BoardDto;
use App\Http\Resources\BoardDeeResource;
use App\Interfaces\BoardDee\BoardRepositoryInterface;
use App\Models\BoardDee;
use App\Models\Meeting;
use Illuminate\Support\Arr;

class BoardDeeService extends BaseService
{
    public function __construct(private BoardRepositoryInterface $boardDeeRepository) {}
    public function getAllBoardDees()
    {
        $boardDee = $this->boardDeeRepository->getall();
        return $boardDee;
    }

    public function getBoardDeeById($id)
    {
        $boardDee = $this->boardDeeRepository->getone($id);
        return $this->success([
            'boardDee' => $boardDee
        ], 'BoardDee retrieved successfully', 200);
    }

    public function AddBoardDee(BoardDto $board): array
    {
        $boardDee = $this->boardDeeRepository->create($board);
        return $this->success([
            'boardDee' => $boardDee
        ], 'BoardDee retrieved successfully', 200);
    }

    public function UpdateBoardDee($id, BoardDto $board)
    {
        $boardDee = $this->boardDeeRepository->update($id, $board);
        return $this->success([
            'boardDee' => $boardDee
        ], 'BoardDee updated successfully', 200);
    }
    public function DeleteBoardDee($id)
    {
        $boardDee = $this->boardDeeRepository->delete($id);
        return $this->success([
            'boardDee' => $boardDee
        ], 'BoardDee deleted successfully', 200);
    }

    public function getBoardDeesByMeetingId($id)
    {
        $meeting = Meeting::with('boardDees')->find($id);
        if (!$meeting) {
            return $this->error('Meeting not found', 404, [
                'meeting' => $meeting
            ]);
        }
        if ($meeting->boardDees->isEmpty()) {
            return $this->error('No board dees found for this meeting', 404, [
                'boardDees' => []
            ]);
        }


        return $this->success([
            'boardDees' => $meeting->boardDees
        ], 'BoardDees retrieved successfully', 200);
    }
}
