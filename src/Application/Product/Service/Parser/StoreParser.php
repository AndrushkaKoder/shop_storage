<?php

declare(strict_types=1);

namespace App\Application\Product\Service\Parser;

use Symfony\Component\DomCrawler\Crawler;

final class StoreParser
{
    private string $baseUrl = 'https://appzone.store';

    public function parseOutsideShop(): \Generator
    {
        $html = file_get_contents($this->baseUrl);
        $crawler = new Crawler($html, $this->baseUrl);

        $categories = $crawler
            ->filter('.menuslider')
            ->filter('.page-catalog-subcat-head-item')
            ->each(function (Crawler $node) {
                $name = $node->text();
                $link = $node->attr('href');

                return ['name' => $name, 'link' => $link];
            });

        foreach ($categories as $category) {
            if (empty($category['link'])) {
                continue;
            }

            $categoryPage = $this->baseUrl.$category['link'];

            $categoryHtml = file_get_contents($categoryPage);
            $pageCrawler = new Crawler($categoryHtml, $categoryPage);

            $pageProducts = $pageCrawler
                ->filter('.page-catalog-list')
                ->filter('.product-card')
                ->each(function (Crawler $node) {
                    $titleNode = $node->filter('.product-card__title');
                    $priceNode = $node->filter('.product-card__price');
                    $imgNode = $node->filter('img');

                    return [
                        'name' => $titleNode?->text() ?? null,
                        'price' => $priceNode->count() > 0 ? (float) $priceNode->text() : 100000,
                        'image' => $imgNode->count() ? $imgNode->image()->getUri() : null,
                    ];
                });

            yield [
                'name' => $category['name'],
                'products' => $pageProducts,
            ];
        }
    }
}
