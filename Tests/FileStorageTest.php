<?php

namespace App\Tests;

use MyApp\Domain\Comment;
use PHPUnit\Framework\TestCase;

final class FileStorageTest extends TestCase 
{   
    private array $comments;

    public function setUp(): void
    {
        $this->comments[0] = new Comment();
        $this->comments[0]->setAuthor('Alex');
        $this->comments[0]->setText('Alex\'s comment');

        $this->comments[1] = new Comment();
        $this->comments[1]->setAuthor('Nikola');
        $this->comments[1]->setText('Nikola\'s comment');
    }
    
    public function testStoreComments()
    {
        $file = 'tests/testListComments.txt';

        if (is_readable($file)) {           // если есть файл, удалим его
            unlink($file);
        }
        
        $this->assertFileDoesNotExist($file);       // проверим сами себя) что файл отсутствует (удалился в if) если он был 

        $handle = fopen($file, 'w');       
        
        $this->assertFileExists($file);              // тест на создание файла при его отсутствии
        $this->assertFileIsWritable($file);             // тест что $file является файлом и открыт для чтения

        foreach ($this->comments as $key => $value) {            
            fwrite($handle, 'Пост № ' . $key + 1 . PHP_EOL);      
            fwrite($handle, 'Автор: ' . $value->getAuthor() . PHP_EOL); 
            fwrite($handle, 'Сообшение: ' . $value->getText() . PHP_EOL);
        }

        fclose($handle);

        $this->assertFileEquals($file, 'tests/testListCommentsForTest.txt');      // сравним содержание полученного файла с образцом
    }
}