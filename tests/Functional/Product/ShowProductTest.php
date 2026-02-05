<?php

declare(strict_types=1);

namespace App\Tests\Functional\Product;

use App\Domain\Product\Factory\ProductFactory;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class ShowProductTest extends WebTestCase
{
    use ResetDatabase;

    #[Test]
    #[TestDox('Получение товара по ID')]
    public function test_get_product_successfully(): void
    {
        $client = static::createClient();

        $product = ProductFactory::createOne();

        $client->request('GET', "/api/v1/products/{$product->getId()}");

        $this->assertResponseIsSuccessful();

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertNotNull($response);
        $this->assertArrayHasKey('id', $response['response']);
        $this->assertEquals($response['response']['id'], $product->getId());
    }

    #[Test]
    #[TestDox('Товар не найден по ID')]
    public function test_not_found_product(): void
    {
        $client = static::createClient();

        $client->request('GET', "/api/v1/products/" . rand(50, 100));

        $this->assertResponseStatusCodeSame(404);
    }
}
