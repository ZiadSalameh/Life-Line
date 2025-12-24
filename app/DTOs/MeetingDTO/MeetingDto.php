<?php

namespace App\DTOs\MeetingDTO;

use Carbon\Carbon;

class MeetingDto
{
    public function __construct(
        public readonly ?string $description,
        public readonly ?Carbon $DateTime,
        public readonly string $meeting_no,
    ) {}
}
