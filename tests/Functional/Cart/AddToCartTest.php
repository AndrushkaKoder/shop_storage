<?php

declare(strict_types=1);

namespace App\Tests\Functional\Cart;

use App\Domain\Product\Factory\ProductFactory;
use App\Domain\User\Entity\User;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class AddToCartTest extends WebTestCase
{
    use ResetDatabase;

    #[Test]
    #[TestDox('Добавление товара в корзину авторизованному юзеру')]
    public function testAddToCartSuccessfully(): void
    {
        $client = static::createClient();

        /** @var User $user */
        $user = UserFactory::createOne([
            'phone' => '0123456655',
        ]);
        $token = $this->getContainer()->get(JWTTokenManagerInterface::class)->create($user);
        $product = ProductFactory::createOne();

        $client->request(
            'POST',
            '/api/v1/cart/add',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => "Bearer {$token}",
            ],
            json_encode([
                'productId' => $product->getId(),
            ])
        );

        $this->assertResponseIsSuccessful();

        $updatedUser = static::getContainer()->get(UserRepository::class)->find($user->getId());

        $this->assertNotEmpty($updatedUser->getCart()->getProducts());
    }

    #[Test]
    #[TestDox('Ошибка при попытке менять корзину без авторизации')]
    public function testErrorAddToCartWhenUnauthorized(): void
    {
        $client = static::createClient();
        $product = ProductFactory::createOne();

        $client->request(
            'POST',
            '/api/v1/cart/add',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode([
                'productId' => $product->getId(),
            ])
        );

        $this->assertResponseStatusCodeSame(401);
    }
}
