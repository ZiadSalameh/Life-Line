<?php

namespace App\Interfaces\BoardDee;

use App\DTOs\BoardDtos\BoardDto;
use App\Models\BoardDee;
use Illuminate\Support\Collection;

interface BoardRepositoryInterface
{

    public function create(BoardDto $boardDto): BoardDee;
    public function update($id, BoardDto $boardDto): BoardDee;
    public function delete($id): bool;
    public function getall(): Collection;
    public function getone(int $id): BoardDee;
}
