<?php

declare(strict_types=1);

namespace App\Tests\Functional\Product;

use App\Domain\Product\Factory\ProductFactory;
use App\Domain\Product\Repository\ProductRepository;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ListProductsTest extends WebTestCase
{
    use Factories;
    use ResetDatabase;

    #[Test]
    #[TestDox('Получение списка товаров')]
    public function get_list_successfully(): void
    {
        $client = static::createClient();
        ProductFactory::repository()->truncate();
        ProductFactory::createMany(10);

        $this->assertCount(
            10,
            $this->getContainer()->get(ProductRepository::class)->findAll()
        );

        $client->request(
            'GET',
            '/api/v1/products',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $this->assertResponseIsSuccessful();

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertCount(10, $response['response']);
    }
}
