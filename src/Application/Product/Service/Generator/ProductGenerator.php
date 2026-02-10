<?php

declare(strict_types=1);

namespace App\Application\Product\Service\Generator;

use App\Application\Product\Service\Parser\StoreParser;
use App\Application\Product\Service\ValueObject\ProductGeneratorSource;
use App\Application\Shared\Contract\EntityGenerator;
use App\Domain\Category\Entity\Category;
use App\Domain\Category\Repository\CategoryRepository;
use App\Domain\Product\Entity\Product;
use App\Domain\Product\Repository\ProductRepository;
use Psr\Log\LoggerInterface;

final readonly class ProductGenerator implements EntityGenerator
{
    public function __construct(
        private ProductRepository $productRepository,
        private CategoryRepository $categoryRepository,
        private LoggerInterface $logger,
        private StoreParser $parser,
    ) {
    }

    public function generate(ProductGeneratorSource $source, ?int $count = null): void
    {
        try {
            $data = match ($source) {
                ProductGeneratorSource::FILE => $this->generateFromFile(),
                ProductGeneratorSource::RANDOM => $this->generateRandom($count ?? 10),
                ProductGeneratorSource::PARSER => $this->generateFromParsing(),
            };

            $this->productRepository->createMany($data);

            $this->logger->info('Товары успешно добавлены');
        } catch (\Throwable $e) {
            $this->logger->error('Товары не добавлены: '.$e->getMessage());
        }
    }

    /**
     * Имитация парсинга файла.
     */
    private function generateFromFile(): \Generator
    {
        sleep(30);

        return new \Generator();
    }

    /**
     * Рандомные файлы.
     */
    private function generateRandom(int $count): \Generator
    {
        sleep(60);

        for ($i = 0; $i < $count; ++$i) {
            $product = new Product();

            $product->setName("Product_{$i}");
            $product->setPrice($i * rand(1, 100));

            if (0 === $i % 2) {
                $product->setDiscount($i * 2);
            }

            $product->setImages([
                'https://iphoriya.ru/wp-content/uploads/iphone-17-pro-deep-blue.webp',
                'https://iphoriya.ru/wp-content/uploads/iphone-15-black.jpg',
            ]);

            $product->setIsActive(true);

            yield $product;
        }
    }

    /**
     * Парсинг стороннего магазина.
     */
    private function generateFromParsing(): bool
    {
        sleep(30);

        $categories = $this->parser->parseOutsideShop();

        foreach ($categories as $data) {
            $category = $this->categoryRepository->findOneBy(['name' => $data['name']]);

            if (is_null($category)) {
                $category = new Category();

                $category->setName($data['name']);

                $newProducts = [];
                foreach ($data['products'] as $dataProduct) {
                    if (!is_null($dataProduct['name'])) {
                        $newProducts[] = new Product()
                            ->setName($dataProduct['name'])
                            ->setPrice($dataProduct['price'])
                            ->setIsActive(true)
                            ->setImages([$dataProduct['image']]);
                    }
                }

                $category->addProducts($newProducts);

                $this->categoryRepository->create($category);
            }
        }

        return true;
    }
}
