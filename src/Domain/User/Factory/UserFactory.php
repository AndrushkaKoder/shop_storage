<?php

declare(strict_types=1);

namespace App\Domain\User\Factory;

use App\Domain\User\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

class UserFactory extends PersistentObjectFactory
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();

        $this->passwordHasher = $passwordHasher;
    }

    protected function defaults(): array|callable
    {
        return [
            'password' => 'password',
            'phone' => self::faker()->numerify('9#########'),
            'first_name' => self::faker()->userName(),
            'last_name' => self::faker()->userName(),
            'roles' => ['ROLE_USER'],
            'is_active' => true,
            'createdAt' => self::faker()->dateTimeBetween('-1 year'),
        ];
    }

    public static function class(): string
    {
        return User::class;
    }

    protected function initialize(): static
    {
        return $this
            ->beforeInstantiate(function (array $attributes) {
                if (isset($attributes['password'])) {
                    $user = new User();
                    $hashedPassword = $this->passwordHasher->hashPassword(
                        $user,
                        $attributes['password']
                    );
                    $attributes['password'] = $hashedPassword;
                }

                return $attributes;
            });
    }
}
