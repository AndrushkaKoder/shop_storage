<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Api\User\v1\Create;

use App\Application\User\Exception\UserAlreadyExistsException;
use App\Infrastructure\Http\Api\AbstractApiController;
use App\Infrastructure\Http\Api\User\v1\Create\Input\CreateUserDto;
use App\Infrastructure\Resource\User\v1\UserResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route(path: 'api/v1')]
class Controller extends AbstractApiController
{
    #[Route(path: '/user/create', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] CreateUserDto $dto, Manager $manager): JsonResponse
    {
        try {
            return $this->wrapResponse(
                new UserResource($manager->handle($dto)),
                Response::HTTP_CREATED
            );
        } catch (UserAlreadyExistsException $e) {
            return $this->wrapError($e);
        }
    }
}
