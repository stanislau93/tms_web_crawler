<?php

namespace MyApp\Controller;

use MyApp\Service\CrawlerServiceFactory;
use MyApp\Service\StorageServiceInterface;
use Throwable;

class CommentController
{
    private CrawlerServiceFactory $crawlerServiceFactory;
    private StorageServiceInterface $fileStorage;
    private StorageServiceInterface $baseStorage;

    public function __construct(CrawlerServiceFactory $crawlerServiceFactory, StorageServiceInterface $fileStorage, StorageServiceInterface $baseStorage)
    {
        $this->crawlerServiceFactory = $crawlerServiceFactory;
        $this->fileStorage = $fileStorage;
        $this->baseStorage = $baseStorage;
    }

    public function crawlPage(): array
    {
        $crawlerService = $this->crawlerServiceFactory->getInstance($_POST['type']);
        
        /** @var Comment[] $comments */
        $comments = $crawlerService->crawl($_POST['url'], $_POST);

        echo "Автор третьего комментария:".$comments[2]->getAuthor();
        
        try {
            $result = $this->fileStorage->storeComments($comments);
            $result = $this->baseStorage->storeComments($comments);
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
