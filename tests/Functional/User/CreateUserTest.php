<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use App\Infrastructure\Http\Api\User\v1\Create\Controller;
use Faker\Factory;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\ResetDatabase;

#[CoversMethod(className: Controller::class, methodName: '__invoke')]
class CreateUserTest extends WebTestCase
{
    use ResetDatabase;

    #[Test]
    #[TestDox('Создание пользователя')]
    public function test_create_user_successfully(): void
    {
        $client = static::createClient();
        $faker = Factory::create();

        $payload = [
            'firstName' => $faker->firstName(),
            'lastName' => $faker->lastName(),
            'phone' => '9991234567',
            'password' => 'secret123'
        ];

        $client->request(
            'POST',
            '/api/v1/user/create',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($payload)
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $responseContent = json_decode($client->getResponse()->getContent(), true);

        $this->assertNotEmpty($responseContent['response']);

        $result = $responseContent['response'];

        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('phone', $result);
        $this->assertArrayHasKey('isActive', $result);
        $this->assertArrayHasKey('roles', $result);
        $this->assertArrayHasKey('createdAt', $result);
    }
}
