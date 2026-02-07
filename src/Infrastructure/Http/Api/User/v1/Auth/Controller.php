<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Api\User\v1\Auth;

use App\Infrastructure\Http\Api\AbstractApiController;
use App\Infrastructure\Http\Api\User\v1\Auth\Input\AuthUserDto;
use App\Infrastructure\Resource\JWT\JwtResource;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[OA\Tag(name: 'User')]
#[Route(path: '/api/v1')]
class Controller extends AbstractApiController
{
    #[Route(path: '/auth', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] AuthUserDto $dto, Manager $manager): JsonResponse
    {
        return $this->wrapResponse(new JwtResource($manager->handle($dto)));
    }
}
