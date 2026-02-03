<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Api\User\v1\Update;

use App\Domain\User\Entity\User;
use App\Infrastructure\Http\Api\AbstractApiController;
use App\Infrastructure\Http\Api\User\v1\Update\Input\UpdateUserDto;
use Exception;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route(path: 'api/v1')]
class Controller extends AbstractApiController
{
    #[Route(path: '/user/{user}', methods: ['PUT', 'PATCH'])]
    public function __invoke(
        #[MapEntity] User $user,
        #[MapRequestPayload] UpdateUserDto $dto,
        Manager $manager
    ): JsonResponse {
        try {
            return $this->wrapResponse([
                'success' => true,
                'id' => $manager->handle($user, $dto)
            ]);
        } catch (Exception $e) {
            return $this->wrapError($e);
        }
    }
}
