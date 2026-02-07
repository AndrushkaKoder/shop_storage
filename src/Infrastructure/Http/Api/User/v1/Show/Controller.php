<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Api\User\v1\Show;

use App\Domain\User\Entity\User;
use App\Infrastructure\Http\Api\AbstractApiController;
use App\Infrastructure\Resource\User\v1\UserResource;
use OpenApi\Attributes as OA;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[OA\Tag(name: 'User')]
#[Route(path: '/api/v1')]
class Controller extends AbstractApiController
{
    #[Route(path: '/user/{user}', name: 'user.show', methods: ['GET'])]
    public function __invoke(#[MapEntity] User $user): JsonResponse
    {
        return $this->wrapResponse(new UserResource($user));
    }
}
