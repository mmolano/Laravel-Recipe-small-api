<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ErrorHandler
{
    private ?array $customError = null;
    private ?string $errorPath = null;
    private array $generalErrorCodes = [
        0 => [
            'message' => null,
            'status' => 400,
            'log' => null
        ],
        1 => [
            'message' => 'Empty Token',
            'status' => 400,
            'log' => 'No token provided'
        ],
        2 => [
            'message' => 'Bad Token',
            'status' => 401,
            'log' => 'The access token is incorrect'
        ],
        3 => [
            'message' => 'Unauthorized',
            'status' => 401,
            'log' => 'Access not granted'
        ],
    ];

    public function setValidationError(int $code, string $message): self
    {
        if ($this->generalErrorCodes[$code]) {
            $this->generalErrorCodes[$code]['message'] = json_decode($message);
        }
        return $this;
    }

    public function setCustom(array $tempError, array $errors): void
    {
        $this->errorPath = $tempError['path'];
        $this->customError = $errors;
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

        if ($generalError && $this->generalErrorCodes[$code]) {
            $error = $this->generalErrorCodes[$code];
        } elseif ($this->customError && $this->customError[$code]) {
            $error = $this->customError[$code];
        } elseif (isset($error) && $error['log']) {
            $this->log($code, $error['log']);
        } else {
            $this->log(9999, 'Unhandled error');

            return response()->json([
                'code' => 9999,
                'handlerCode' => 500,
                'message' => 'Undefined error',
                'is_general' => $generalError,
            ], 500);
        }

        return response()->json([
            'code' => $code,
            'handlerCode' => $error['status'],
            'message' => $error['message'],
            'is_general' => $generalError,
        ], $error['status']);
    }
}
