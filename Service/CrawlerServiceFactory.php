<?php

namespace MyApp\Service;

use RuntimeException;

class CrawlerServiceFactory
{
    private const CRAWL_FORUM_TYPE = 'forum';
    private const CRAWL_REDDIT_TYPE = 'reddit';

    public function getInstance(string $type): CrawlerServiceInterface
    {
        switch ($type) {
            case self::CRAWL_FORUM_TYPE:
                return new ForumCrawlerService();
            case self::CRAWL_REDDIT_TYPE:
                return new RedditCrawlerService();
            default:
                throw new RuntimeException('unrecognized type');
        }
    }
}