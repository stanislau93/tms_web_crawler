<?php

namespace MyApp\Controller;

use MyApp\Service\CrawlerServiceInterface;
use MyApp\Service\StorageServiceInterface;
use Throwable;

class CommentController
{
    private CrawlerServiceInterface $crawlerService;
    private StorageServiceInterface $fileStorage;

    public function __construct(CrawlerServiceInterface $crawlerService, StorageServiceInterface $fileStorage)
    {
        $this->crawlerService = $crawlerService;
        $this->fileStorage = $fileStorage;
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
