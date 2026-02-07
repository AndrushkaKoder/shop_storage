<?php

declare(strict_types=1);

namespace App\Domain\Order\Repository;

use App\Application\Order\Exception\OrderException;
use App\Domain\Order\Entity\Order;
use App\Domain\Order\ValueObject\PaymentMethod;
use App\Domain\Order\ValueObject\Status;
use App\Domain\Shared\Repository\AbstractRepository;
use App\Domain\User\Entity\User;

class OrderRepository extends AbstractRepository
{
    protected string $entityClass = Order::class;

    public function createNewOrder(User $user, PaymentMethod $paymentMethod): Order
    {
        return $this->manager->wrapInTransaction(function () use ($user, $paymentMethod) {
            $cart = $user->getCart();
            $products = $cart->getProducts();

            if ($products->isEmpty()) {
                throw new OrderException('Корзина пуста');
            }

            $order = new Order()
                ->setUser($user)
                ->setPaymentMethod($paymentMethod)
                ->setTotalSum($cart->getTotalSum())
                ->setStatus(Status::NEW);

            foreach ($products as $product) {
                $order->products->add($product);
            }

            $products->clear();
            $cart->setTotalSum(0);

            $this->getEntityManager()->persist($cart);
            $this->getEntityManager()->persist($order);

            return $order;
        });
    }
}
