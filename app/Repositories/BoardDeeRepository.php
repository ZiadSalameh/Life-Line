<?php

namespace App\Repositories;

use App\DTOs\BoardDtos\BoardDto;
use App\Interfaces\BoardDee\BoardRepositoryInterface;
use App\Models\BoardDee;
use Illuminate\Support\Collection;

class BoardDeeRepository implements BoardRepositoryInterface
{
    public function create(BoardDto $boardDto): BoardDee
    {
        return BoardDee::create([
            'board_no' => $boardDto->board_no,
            'description' => $boardDto->description ?? null,
            'voted' => $boardDto->voted ?? null,
            'boar_dee_date' => $boardDto->boar_dee_date ?? null,
            'meeting_id' => $boardDto->meeting_id,

        ]);
    }

    public function update($id, BoardDto $boardDto): BoardDee
    {
        $board = BoardDee::findOrFail($id);
        $board->update([
            'board_no' => $boardDto->board_no,
            'description' => $boardDto->description ?? null,
            'voted' => $boardDto->voted ?? null,
            'boar_dee_date' => $boardDto->boar_dee_date ?? null,
            'meeting_id' => $boardDto->meeting_id,
        ]);
        return $board;
    }

    public function delete($id): bool
    {
        $board = BoardDee::findOrFail($id);

        return $board->delete();
    }

    public function getall(): Collection
    {
        return BoardDee::all();
    }

    public function getone(int $id): BoardDee
    {

        return BoardDee::findOrFail($id);
    }
}
