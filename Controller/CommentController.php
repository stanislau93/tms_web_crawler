<?php

namespace MyApp\Controller;

use MyApp\Service\CrawlerServiceInterface;
use MyApp\Service\ForumCrawlerService;
use MyApp\Service\FileStorageService;
use MyApp\Service\StorageServiceInterface;

class CommentController
{
    private CrawlerServiceInterface $crawlerService;
    private StorageServiceInterface $fileStorage;

    public function __construct()
    {
        $this->crawlerService = new ForumCrawlerService();
        $this->fileStorage = new FileStorageService();
    }

    public function crawlPage(array $request): array
    {
        $config = [
            'xpath_comment_expression' => $request['comment_expression'],
            'xpath_comment_text_expression' => $request['comment_text_expression'],
            'xpath_comment_author_expression' => $request['comment_author_expression'],
        ];

        /** @var Comment[] $comments */
        $comments = $this->crawlerService->crawl($request['url'], $config);

        echo "Автор третьего комментария:".$comments[2]->getAuthor();
        
        // $this->fileStorage->storeComments($comments);

        return $comments;
    }

    public function fileStorage(array $comments): void
    {
        $this->fileStorage->storeComments($comments);
    }
    
}
