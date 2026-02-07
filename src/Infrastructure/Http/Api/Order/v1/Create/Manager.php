<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Api\Order\v1\Create;

use App\Application\Order\UseCase\CreateOrder;
use App\Domain\Order\ValueObject\PaymentMethod;
use App\Domain\User\Entity\User;
use App\Infrastructure\Http\Api\Order\v1\Create\Input\CreateOrderDto;

final readonly class Manager
{
    public function __construct(private CreateOrder $useCase)
    {
    }

    public function handle(User $user, CreateOrderDto $dto): int
    {
        $method = PaymentMethod::tryFrom($dto->paymentMethod);

        return $this->useCase->handle($user,$method);
    }
}
