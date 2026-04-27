<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

trait FormattedResponse
{
    /**
     * Show a success response with model data.
     *
     * @param mixed $data
     * @param string $messageKey Translation key from messages.php
     * @param array $replace Placeholder replacements
     * @param int $status
     * @return JsonResponse
     */
    public function success(
        $data,
        string $messageKey = 'messages.success',
        array $replace = [],
        int $status = Response::HTTP_OK
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => __($messageKey, $replace),
            'data' => $data,
        ], $status);
    }

    /**
     * Show an error response with exception message.
     *
     * @param \Exception $exception
     * @param string $messageKey Translation key from messages.php
     * @param array $replace Placeholder replacements
     * @return JsonResponse
     */
    public function error(
        Throwable $exception,
        string $messageKey = 'messages.error',
        array $replace = [],
        ?int $status = null

    ): JsonResponse {
        Log::error('Error occurred: ' . $exception->getMessage());

        $statusCode = $status
            ?? ($exception instanceof HttpExceptionInterface
                ? $exception->getStatusCode()
                : Response::HTTP_INTERNAL_SERVER_ERROR);

        return response()->json([
            'success' => false,
            'message' => __($messageKey, $replace),
            'error' => $exception->getMessage(),
        ], $statusCode);
    }

    /**
     * Show a general message response.
     *
     * @param string $messageKey Translation key from messages.php
     * @param array $replace Placeholder replacements
     * @param int $status
     * @param bool $success
     * @return JsonResponse
     */
    public function message(
        string $messageKey,
        array $replace = [],
        int $status = Response::HTTP_OK,
        bool $success = true
    ): JsonResponse {
        return response()->json([
            'success' => $success,
            'message' => __($messageKey, $replace),
        ], $status);
    }
}