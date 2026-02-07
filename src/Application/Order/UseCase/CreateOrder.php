<?php

declare(strict_types=1);

namespace App\Application\Order\UseCase;

use App\Domain\Order\Repository\OrderRepository;
use App\Domain\Order\ValueObject\PaymentMethod;
use App\Domain\User\Entity\User;

final readonly class CreateOrder
{
    public function __construct(
        private OrderRepository $repository,
    ) {
    }

    public function handle(User $user, PaymentMethod $paymentMethod): int
    {
        $newOrder = $this->repository->createNewOrder($user, $paymentMethod);

        return $newOrder->getId();
    }
}
