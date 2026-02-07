<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\Command\Product;

use App\Application\Product\Service\ValueObject\ProductGeneratorSource;
use App\Application\Shared\Messenger\Message\Product\CreateProductAsync;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(name: 'app:product:create', description: 'Генерация товаров')]
readonly class ProductCreateCommand
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
    }

    public function __invoke(OutputInterface $output): int
    {
        try {
            $this->messageBus->dispatch(new CreateProductAsync(ProductGeneratorSource::RANDOM->value));
            $output->writeln('Сообщение отправлено в шину');

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $output->writeln(
                'Ошибка отправки cooбщения '
                .CreateProductAsync::class
                .' в очередь :'.$e->getMessage()
            );

            return Command::FAILURE;
        }
    }
}
