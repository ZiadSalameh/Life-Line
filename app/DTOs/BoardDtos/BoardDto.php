<?php 
namespace App\DTOs\BoardDtos;

use Carbon\Carbon;

class BoardDto {
    public function __construct(
        public readonly int $board_no,
        public readonly ?string $description,
        public readonly ?string $voted,
        public readonly int $meeting_id,
        public readonly ?Carbon $boar_dee_date,
    ) {}
}