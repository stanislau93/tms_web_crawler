<?php

namespace MyApp\Service;

interface StorageServiceInterface
{
    public function storeComments(array $comments): array;
}