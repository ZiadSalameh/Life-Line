<?php

namespace App\DTOs\UserDto;

use App\Interfaces\User\UserRole;
use Carbon\Carbon;

class UserDto
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly string $password,
        public readonly ?Carbon $birthdate,
        public readonly ?string $ScinceGrade,
        public readonly UserRole $role,
        public readonly int $office_id,

    ) {}
}
