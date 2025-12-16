<?php

namespace App\Http\Service;

abstract class BaseService
{
    protected function success(array $data = [], string $message = '', int $status = 200): array
    {
        return array_merge([
            'success' => true,
            'message' => $message,
            'status' => $status,
        ], $data);
    }

    protected function error(string $message = '', int $status = 400, array $data = []): array
    {
        return array_merge([
            'success' => false,
            'message' => $message,
            'status' => $status,
        ], $data);
    }
}
