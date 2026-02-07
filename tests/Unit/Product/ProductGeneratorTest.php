<?php

declare(strict_types=1);

namespace App\Tests\Unit\Product;

use App\Application\Product\Service\Generator\ProductGenerator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

class ProductGeneratorTest extends TestCase
{
    #[Test]
    #[TestDox('Тест генерации товаров')]
    public function testGetGeneratorWithProducts(): void
    {
        $generator = new ProductGenerator();

        $countItems = 0;

        $res = $generator->generate(500);

        $this->assertIsIterable($res);

        foreach ($res as $item) {
            ++$countItems;
        }

        $this->assertEquals(500, $countItems);
    }
}
