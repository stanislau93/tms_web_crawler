<?php

namespace MyApp\Service;

interface CrawlerServiceInterface
{
    /**
     * @return Comment[]
     */
    public function crawl(string $url, array $config): array;
}