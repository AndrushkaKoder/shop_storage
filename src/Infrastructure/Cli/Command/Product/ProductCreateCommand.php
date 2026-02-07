<?php

declare(strict_types=1);

namespace App\Infrastructure\Cli\Command\Product;

use App\Application\Shared\Contract\EntityGenerator;
use App\Domain\Product\Repository\ProductRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:product:create', description: 'Генерация товаров')]
readonly class ProductCreateCommand
{
    private int $defaultCount;

    public function __construct(private EntityGenerator $generator, private ProductRepository $repository)
    {
        $this->defaultCount = 100;
    }

    public function __invoke(OutputInterface $output): int
    {
        $products = $this->generator->generate($this->defaultCount);

        $output->writeln("Создано {$this->defaultCount} Товаров");

        $this->repository->createMany($products);

        return Command::SUCCESS;
    }
}
