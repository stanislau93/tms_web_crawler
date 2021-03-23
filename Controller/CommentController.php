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

    public function crawlPage($config): array
    {
        $crawlerService = $this->crawlerServiceFactory->getInstance($config['type']);
        
        /** @var Comment[] $comments */
        $comments = $crawlerService->crawl($config['url'], $config);

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
