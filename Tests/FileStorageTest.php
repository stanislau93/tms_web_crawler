<?php

namespace MyApp\Tests;

use MyApp\Domain\Comment;
use MyApp\Service\FileStorageService;
use PHPUnit\Framework\TestCase;

final class FileStorageTest extends TestCase 
{   
    /**
     * @var Comment[]
     */
    private array $comments;

    private FileStorageService $service;

    public function setUp(): void
    {
        $this->comments[0] = new Comment();
        $this->comments[0]->setAuthor('Alex');
        $this->comments[0]->setText('Alex\'s comment');

        $this->comments[1] = new Comment();
        $this->comments[1]->setAuthor('Nikola');
        $this->comments[1]->setText('Nikola\'s comment');

        $this->service = new FileStorageService();
    }
    
    public function testStoreComments()
    {
        $result = $this->service->storeComments($this->comments);

        $this->assertFileEquals($result['file_name'], 'Tests/testListCommentsForTest.txt');
        
        unlink($result['file_name']);
    }
}