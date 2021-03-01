<?php

namespace MyApp\Service;

use Error;
use Exception;

class FileStorageService implements StorageServiceInterface
{   
    public function storeComments(array $comments, string $file): void
    {  
        $handle = fopen($file, 'w');

        if ($handle === false) {
            throw new Exception('Ошибка открытия файла');
        }
        
        foreach ($comments as $key => $value) {            
            fwrite($handle, 'Пост № ' . $key + 1 . PHP_EOL); 
            fwrite($handle, 'Автор: ' . $value->getAuthor() . PHP_EOL); 
            fwrite($handle, 'Сообшение: ' . $value->getText() . PHP_EOL);
        }

        fclose($handle);        
    }
}
