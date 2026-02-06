<?php

declare(strict_types=1);

namespace App\Tests\Functional\Cart;

use App\Domain\Cart\Repository\CartRepository;
use App\Domain\Product\Factory\ProductFactory;
use App\Domain\User\Entity\User;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class RemoveFromCartTest extends WebTestCase
{
    use ResetDatabase;

    #[Test]
    #[TestDox('Удаление товара из корзины')]
    public function test_remove_product_from_cart(): void
    {
        $client = static::createClient();

        /** @var User $user */
        $user = UserFactory::createOne([
            'phone' => '0123456666'
        ]);
        $token = $this->getContainer()->get(JWTTokenManagerInterface::class)->create($user);
        $product = ProductFactory::createOne();

        $cart = $user->getCart()->addProduct($product);

        $this->getContainer()->get(CartRepository::class)->create($cart);

        $client->request(
            'POST',
            '/api/v1/cart/remove',
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

        $this->assertEmpty($updatedUser->getCart()->getProducts());
    }


    #[Test]
    #[TestDox('Ошибка при попытке менять корзину без авторизации')]
    public function test_error_remove_from_cart_when_unauthorized(): void
    {
        $client = static::createClient();
        $product = ProductFactory::createOne();

        $client->request(
            'POST',
            '/api/v1/cart/remove',
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
