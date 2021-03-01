<?php

namespace MyApp\Service;

interface StorageServiceInterface
{
    public function storeComments(array $comments, string $fileName): void;
}