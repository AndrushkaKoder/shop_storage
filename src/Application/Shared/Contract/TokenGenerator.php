<?php

declare(strict_types=1);

namespace App\Application\Shared\Contract;

use App\Domain\User\Entity\User;

interface TokenGenerator
{
    public function generate(User $user): string;
}
