<?php

namespace MyApp\Controller;

use MyApp\Service\CrawlerServiceFactory;
use MyApp\Service\StorageServiceInterface;
use Throwable;

class CommentController
{
    private CrawlerServiceFactory $crawlerServiceFactory;
    private StorageServiceInterface $fileStorage;

    public function __construct(CrawlerServiceFactory $crawlerServiceFactory, StorageServiceInterface $fileStorage)
    {
        $this->crawlerServiceFactory = $crawlerServiceFactory;
        $this->fileStorage = $fileStorage;
    }

    public function crawlRedditPage(array $request)
    {
        $crawlerService = $this->crawlerServiceFactory->getInstance($request['type']);
        $comments = $crawlerService->crawl($request['url'], $request);

        $result = $this->fileStorage->storeComments($comments);
        echo 'Сделано!';
    }

    public function crawlPage(array $request): array
    {
        $config = [
            'xpath_comment_expression' => $request['comment_expression'],
            'xpath_comment_text_expression' => $request['comment_text_expression'],
            'xpath_comment_author_expression' => $request['comment_author_expression'],
        ];

        $crawlerService = $this->crawlerServiceFactory->getInstance($request['type']);
        
        /** @var Comment[] $comments */
        $comments = $crawlerService->crawl($request['url'], $config);

        echo "Автор третьего комментария:".$comments[2]->getAuthor();
        
        try {
            $result = $this->fileStorage->storeComments($comments);
        } catch (Throwable $e) {
            echo '<br>';
            echo 'Ошибка: ' . $e->getMessage();
            echo '<br>';
            echo 'Файл: ' . $e->getFile();
            echo '<br>';
            echo 'Строка: ' . $e->getLine();

            return 0;
        }

        return $result;
    }
}
