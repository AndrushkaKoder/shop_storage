<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Api\Cart\v1\Add;

use App\Domain\User\Entity\User;
use App\Infrastructure\Http\Api\AbstractApiController;
use App\Infrastructure\Http\Api\Cart\v1\Add\Input\AddToCartDto;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[AsController]
#[Route(path: '/api/v1')]
class Controller extends AbstractApiController
{
    #[Route(path: '/cart/add', methods: ['POST'])]
    public function __invoke(
        #[CurrentUser] User $user,
        #[MapRequestPayload] AddToCartDto $dto,
        Manager $manager,
    ): JsonResponse {
        return $this->wrapResponse([
            'success' => $manager->handle($user, $dto),
        ]);
    }
}
