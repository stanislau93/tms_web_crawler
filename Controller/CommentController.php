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

    public function crawlPage(array $request): int
    {
        $config = [
            'xpath_comment_expression' => $request['comment_expression'],
            'xpath_comment_text_expression' => $request['comment_text_expression'],
            'xpath_comment_author_expression' => $request['comment_author_expression'],
            'saveToFile' => $request['saveToFile'],
            'fileName' => $request['fileName'] . ".txt"
        ];

        /** @var Comment[] $comments */
        $comments = $this->crawlerService->crawl($request['url'], $config);

        echo "Автор третьего комментария:".$comments[2]->getAuthor();
        
        if ($config['saveToFile'] == 1) {
            $this->fileStorage->storeComments($comments, $config['fileName']);
        }

        return 1;
    }
    
}
