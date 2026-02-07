<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Api\Order\v1\Create;

use App\Infrastructure\Http\Api\AbstractApiController;
use App\Infrastructure\Http\Api\Order\v1\Create\Input\CreateOrderDto;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[AsController]
#[Route(path: '/api/v1')]
class Controller extends AbstractApiController
{
    #[Route(path: '/order/create', methods: ['POST'])]
    public function __invoke(
        #[CurrentUser] $user,
        #[MapRequestPayload] CreateOrderDto $dto,
        Manager $manager,
    ): JsonResponse {
        try {
            return $this->wrapResponse([
                'success' => true,
                'orderId' => $manager->handle($user, $dto),
            ]);
        } catch (\Throwable $e) {
            return $this->wrapError($e);
        }
    }
}
