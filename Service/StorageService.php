<?php

namespace MyApp\Service;

class FileStorageService implements StorageServiceInterface
{
    public function storeComment(Comment $comment): void
    {
        echo "Dummy!";
    }
}
