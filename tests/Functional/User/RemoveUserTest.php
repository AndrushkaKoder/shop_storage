<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use App\Application\User\Service\AuthService;
use App\Domain\User\Factory\UserFactory;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class RemoveUserTest extends WebTestCase
{
    use ResetDatabase;

    #[Test]
    #[TestDox('Удаление юзера')]
    public function testRemoveUserSuccessfully(): void
    {
        $client = static::createClient();

        $user = UserFactory::createOne(['phone' => '1234567890']);
        $token = $this->getContainer()->get(AuthService::class)->attempt($user, 'password');

        $client->request(
            'DELETE',
            "/api/v1/user/{$user->getId()}",
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => "Bearer {$token}",
            ]
        );

        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertIsArray($content);
        $this->assertArrayHasKey('success', $content['response']);
    }
}
