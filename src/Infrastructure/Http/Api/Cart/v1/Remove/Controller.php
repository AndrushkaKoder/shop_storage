<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Api\Cart\v1\Remove;

use App\Domain\User\Entity\User;
use App\Infrastructure\Http\Api\AbstractApiController;
use App\Infrastructure\Http\Api\Cart\v1\Remove\Input\RemoveFromCartDto;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Throwable;

#[AsController]
#[Route(path: '/api/v1')]
class Controller extends AbstractApiController
{
    #[Route(path: '/cart/remove', methods: ['POST'])]
    public function __invoke(
        #[CurrentUser] User $user,
        #[MapRequestPayload] RemoveFromCartDto $dto,
        Manager $manager
    ): JsonResponse {
        return $this->wrapResponse([
            'success' => $manager->handle($user, $dto)
        ]);
    }
}
