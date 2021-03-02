<?php

namespace MyApp\Service;

use RuntimeException;

class FileStorageService implements StorageServiceInterface
{
    public function storeComments(array $comments, string $file): void
    {
        if (file_exists($file)) {
            if (!is_writable($file)) {
                throw new RuntimeException('Файл не доступен для записи');
            }
        }       

        $handle = fopen($file, 'w');

        if ($handle === false) {
            throw new RuntimeException('Неизвестная ошибка открытия файла');
        }
        
        foreach ($comments as $key => $value) {
            fwrite($handle, 'Пост № ' . $key + 1 . PHP_EOL);
            fwrite($handle, 'Автор: ' . $value->getAuthor() . PHP_EOL);
            fwrite($handle, 'Сообшение: ' . $value->getText() . PHP_EOL);
        }

        fclose($handle);
    }
}
