<?php

namespace App\Http\Service;

use App\Models\BoardDee;
use App\Models\Meeting;

class BoardDeeService extends BaseService
{
    public function getAllBoardDees()
    {
        $boardDees = BoardDee::with('meeting')->get();
        return $boardDees;
    }

    public function getBoardDeeById($id)
    {
        $boardDee = BoardDee::with('meeting')->find($id);
        if (!$boardDee) {
            return $this->error('BoardDee not found', 404, [
                'boardDee' => $boardDee
            ]);
        }
        return $this->success([
            'boardDee' => $boardDee
        ], 'BoardDee retrieved successfully', 200);
    }

    public function AddBoardDee($data)
    {
        $boardDee = BoardDee::create([
            'board_no' => $data['board_no'],
            'boar_dee_date' => $data['boar_dee_date'] ?? null,
            'description' => $data['description'] ?? null,
            'voted' => $data['voted'] ?? null,
            'meeting_id' => $data['meeting_id']
        ]);

        return $this->success([
            'boardDee' => $boardDee
        ], 'BoardDee updated successfully', 201);
    }

    public function UpdateBoardDee(array $data, $id)
    {
        $boardDee = BoardDee::find($id);
        if (!$boardDee) {
            return $this->error('BoardDee not found', 404, [
                'boardDee' => $boardDee
            ]);
        }

        $boardDee->update($data);
        return $this->success([
            'boardDee' => $boardDee
        ], 'BoardDee updated successfully', 200);
    }

    public function DeleteBoardDee($id)
    {
        $boardDee = BoardDee::find($id);
        if (!$boardDee) {
            return $this->error('BoardDee not found', 404, [
                'boardDee' => $boardDee
            ]);
        }
        $boardDee->delete();
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
