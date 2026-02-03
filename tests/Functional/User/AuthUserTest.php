<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use App\Domain\User\Factory\UserFactory;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\ResetDatabase;

class AuthUserTest extends WebTestCase
{
    use ResetDatabase;

    #[Test]
    #[TestDox('Авторизация пользователя по телефону и паролю и получение JWT')]
    public function test_auth_user_successfully(): void
    {
        $client = self::createClient();

        $phone = '9625752211';
        $password = '12345678Password+';

        UserFactory::createOne([
            'phone' => $phone,
            'password' => $password,
        ]);

        $client->request(
            'POST',
            '/api/v1/auth',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'phone' => $phone,
                'password' => $password,
            ])
        );

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertIsArray($data['response']);

        $this->assertArrayHasKey('token', $data['response']);
    }
}
