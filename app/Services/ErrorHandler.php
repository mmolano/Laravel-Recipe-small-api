<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ErrorHandler
{
    private ?array $customError = null;
    private ?string $errorPath = null;
    private array $generalErrorCodes = [
        1 => [
            'message' => 'Empty Token',
            'status' => 400,
            'log' => 'Request error #1'
        ],
        2 => [
            'message' => 'Bad Token',
            'status' => 401,
            'log' => 'Request error #2'
        ],
        3 => [
            'message' => 'Unauthorized',
            'status' => 401,
            'log' => 'Access not granted'
        ]
    ];


    public function setCustom(array $tempError): void
    {
        $this->errorPath = $tempError['path'];
        $this->customError = $tempError;
    }

    private function log(int $code, string $message): void
    {
        Log::error('ErrorHandler', [
            'code' => $code,
            'message' => $message,
            'errorPath' => $this->errorPath ?: ''
        ]);
    }

    public function write(int $code, bool $generalError = false): JsonResponse
    {
        if ($generalError && isset($this->generalErrorCodes[$code])) {
            $error = $this->generalErrorCodes['code'];
        } elseif ($this->customError && isset($this->customError['code'])) {
            $error = $this->customError['code'];
        } elseif (isset($error) && $error['log']) {
            $this->log($code, $error['log']);
        } else {
            $this->log(0, 'Unhandled error');

            return response()->json([
                'code' => 0,
                'handlerCode' => 500,
                'message' => 'Undefined error',
                'is_general' => $generalError,
            ], 500);
        }

        return response()->json([
            'code' => $code,
            'handlerCode' => 200,
            'message' => $error['message'],
            'is_general' => $generalError,
        ]);
    }
}