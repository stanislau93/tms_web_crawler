<?php

namespace MyApp\Service;


class FileStorageService implements StorageServiceInterface
{
    public function storeComments(array $comments): void
    {
        $file = 'listComments.txt';

        $handle = fopen($file, 'w');

        if ($handle === false) {
            echo "Не могу открыть файл $file";
            exit;
        }
        
        foreach ($comments as $key => $value) {            
            fwrite($handle, 'Пост № ' . $key + 1 . PHP_EOL); 
            fwrite($handle, 'Автор: ' . $value->getAuthor() . PHP_EOL); 
            fwrite($handle, 'Сообшение: ' . $value->getText() . PHP_EOL . PHP_EOL);
        }

        fclose($handle);
        
    }
}
