<?php

namespace App\Tests;

use MyApp\Domain\Comment;
use MyApp\Service\FileStorageService;
use PHPUnit\Framework\TestCase;

final class FileStorageTest extends TestCase 
{   
    private array $comments;
    private FileStorageService $file;

    public function setUp(): void
    {
        $this->comments[0] = new Comment();
        $this->comments[0]->setAuthor('Alex');
        $this->comments[0]->setText('Alex\'s comment');

        $this->comments[1] = new Comment();
        $this->comments[1]->setAuthor('Nikola');
        $this->comments[1]->setText('Nikola\'s comment');

        $this->file = new FileStorageService();
    }
    
    public function testStoreComments()
    {
        $file = 'comments.txt';
        $this->file->storeComments($this->comments, $file);

        $this->assertFileEquals($file, 'tests/testListCommentsForTest.txt');      
    }
}