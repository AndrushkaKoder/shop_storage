<?php

declare(strict_types=1);

namespace App\Application\Shared\Messenger\Handler;

use App\Application\Product\Service\ValueObject\ProductGeneratorSource;
use App\Application\Shared\Contract\EntityGenerator;
use App\Application\Shared\Messenger\Message\Product\CreateProductAsync;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class ProductCreateHandler
{
    public function __construct(private EntityGenerator $entityGenerator)
    {
    }

    public function __invoke(CreateProductAsync $message): void
    {
        $this->entityGenerator->generate(ProductGeneratorSource::tryFrom($message->source));
    }
}
