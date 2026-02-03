<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Api;

use App\Infrastructure\Contract\ResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

abstract class AbstractApiController extends AbstractController
{
    public function wrapResponse(mixed $data, int $code = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse([
            'response' => $data instanceof ResourceInterface ? $data->present() : $data,
        ], $code);
    }

    public function wrapError(Throwable $throw): JsonResponse
    {
        return new JsonResponse([
            'error' => $throw->getMessage()
        ], $throw->getCode());
    }
}
