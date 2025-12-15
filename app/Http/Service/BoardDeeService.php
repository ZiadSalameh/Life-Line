<?php

namespace App\Http\Service;

use App\Models\BoardDee;
use App\Models\Meeting;
use Illuminate\Support\Arr;

class BoardDeeService
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
            return [
                'success' => false,
                'message' => 'BoardDee not found',
                'status' => 404,
                'boardDee' => null
            ];
        }
        return [
            'success' => true,
            'message' => 'BoardDee retrieved successfully',
            'status' => 200,
            'boardDee' => $boardDee
        ];
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

        return $boardDee;
    }

    public function UpdateBoardDee(array $data, $id)
    {
        $boardDee = BoardDee::find($id);
        if (!$boardDee) {
            return [
                'success' => false,
                'message' => 'BoardDee not found',
                'status' => 404,
                'boardDee' => null
            ];
        }

        $boardDee->update($data);
        return [
            'success' => true,
            'message' => 'BoardDee updated successfully',
            'status'  => 200,
            'boardDee' => $boardDee
        ];
    }

    public function DeleteBoardDee($id)
    {
        $boardDee = BoardDee::find($id);
        if (!$boardDee) {
            return [
                'success' => false,
                'message' => 'BoardDee not found',
                'status' => 404,
                'boardDee' => null
            ];
        }
        $boardDee->delete();
        return [
            'success' => true,
            'message' => 'BoardDee deleted successfully',
            'status' => 200,
            'boardDee' => $boardDee
        ];
    }

    public function getBoardDeesByMeetingId($id)
    {
        $meeting = Meeting::with('boardDees')->find($id);
        if (!$meeting) {
            return [
                'success' => false,
                'message' => 'Meeting not found',
                'status' => 404,
                'boardDees' => null
            ];
        }
        if ($meeting->boardDees->isEmpty()) {
            return [
                'success' => false,
                'message' => 'No board dees found for this meeting',
                'status' => 404,
                'boardDees' => []
            ];
        }


        return [
            'success' => true,
            'message' => 'BoardDees retrieved successfully',
            'status' => 200,
            'boardDees' => $meeting->boardDees
        ];
    }
}
