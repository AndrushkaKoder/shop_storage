<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use App\Application\User\Service\AuthService;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Repository\UserRepository;
use App\Infrastructure\Http\Api\User\v1\Update\Controller;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Test\ResetDatabase;

#[CoversMethod(className: Controller::class, methodName: "__invoke")]
class UpdateTest extends WebTestCase
{
    use ResetDatabase;

    #[Test]
    #[TestDox('Обновление юзера')]
    public function test_update_user_successfully(): void
    {
        $client = static::createClient();

        $newName = 'NewUser';
        $newLastName = 'NewLastName';
        $newPassword = '1234567890Password+';

        $user = UserFactory::createOne();

        $token = $this->getContainer()->get(AuthService::class)->attempt($user, 'password');

        $client->request(
            'PUT',
            "/api/v1/user/{$user->getId()}",
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => "Bearer {$token}",
            ],
            json_encode([
                'firstName' => $newName,
                'lastName' => $newLastName,
                'password' => $newPassword
            ])
        );

      $this->assertResponseIsSuccessful();

        $json = json_decode($client->getResponse()->getContent(), true);

        $this->assertIsArray($json['response']);
        $this->assertEquals($json['response']['id'], $user->getId());

        /** @var UserPasswordHasherInterface $passwordHasher */
        $passwordHasher = $this->getContainer()->get(UserPasswordHasherInterface::class);

        $updatedUser = $this->getContainer()->get(UserRepository::class)->find($user->getId());

        $this->assertTrue($passwordHasher->isPasswordValid($updatedUser, $newPassword));
    }
}
