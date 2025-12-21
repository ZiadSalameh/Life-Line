<?php

namespace App\DTOs\UserDto;

class LoginDto
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {}
}
