<?php

namespace MyApp\Service;

interface StorageServiceInterface
{
    public function storeComment(Comment $comment): void;
}