<?php

declare(strict_types=1);

namespace App\Tests\Functional\Order;

use App\Domain\Cart\Factory\CartFactory;
use App\Domain\Order\ValueObject\PaymentMethod;
use App\Domain\User\Entity\User;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class CreateOrderTest extends WebTestCase
{
    use ResetDatabase;

    #[Test]
    #[TestDox('Успешное создание заказа')]
    public function testCreateOrderSuccessfully(): void
    {
        $client = static::createClient();

        $user = UserFactory::createOne([
            'phone' => '9533298091',
        ]);

        $jwt = $this->getContainer()
            ->get(JWTTokenManagerInterface::class)
            ->create($user);

        CartFactory::createOne([
            'user' => $user,
        ]);

        $client->request(
            'POST',
            '/api/v1/order/create',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => "Bearer {$jwt}",
            ],
            json_encode([
                'paymentMethod' => PaymentMethod::CASH->value,
            ])
        );

        $this->assertResponseIsSuccessful();

        /** @var User $updatedUser */
        $updatedUser = static::getContainer()->get(UserRepository::class)->find($user->getId());

        $this->assertTrue($updatedUser->getCart()->getProducts()->isEmpty());
        $this->assertCount(1, $updatedUser->getOrders());

        $order = $updatedUser->getOrders()->first();

        $this->assertCount(3, $order->getProducts());
    }

    #[Test]
    #[TestDox('Ошибка при попытке создать заказ без авторизации')]
    public function testErrorCreateOrderWhenUnauthorized(): void
    {
        static::createClient()->request(
            'POST',
            '/api/v1/order/create',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode([
                'paymentMethod' => PaymentMethod::CASH->value,
            ])
        );

        $this->assertResponseStatusCodeSame(401);
    }
}
