<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\Command\Product;

use App\Application\Product\Service\Generator\ProductGenerator;
use App\Application\Product\Service\ValueObject\ProductGeneratorSource;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'product:create:debug', description: 'Ручной прогон парсера')]
final readonly class ParseDebugCommand
{
    public function __construct(
        protected ProductGenerator $entityGenerator,
    ) {
    }

    /**
     * Ручной запуск парсера App\Application\Product\Service\Parser\StoreParser.
     */
    public function __invoke(OutputInterface $output): int
    {
        $output->writeln('<info>Парсинг начался</info>');

        $this->entityGenerator->generate(ProductGeneratorSource::PARSER);

        $output->writeln('<info>Парсинг окончен</info>');

        return Command::SUCCESS;
    }
}
