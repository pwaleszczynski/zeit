<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseController
{
    protected function toJsonResponse(array $response, int $status = 200): JsonResponse
    {
        return (new JsonResponse($response, $status))->send();
    }

    protected function errorResponse(string $errorMessage, int $status = Response::HTTP_UNPROCESSABLE_ENTITY): JsonResponse
    {
        return (new JsonResponse(['error' => $errorMessage], $status))->send();
    }
}
