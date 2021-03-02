<?php

namespace MyApp\Service;

use RuntimeException;

class FileStorageService implements StorageServiceInterface
{
    public function storeComments(array $comments, string $file): void
    {
        if (file_exists($file)) {
            try {
                if (!is_writable($file)) {
                    throw new RuntimeException('Файл не доступен для записи');
                }
            } catch (RuntimeException $e) {
                echo '<br>';
                echo 'Ошибка: ' . $e->getMessage();
                echo '<br>';
                echo 'Файл: ' . $e->getFile();
                echo '<br>';
                echo 'Строка: ' . $e->getLine();
                exit;
            }
        }       

        $handle = fopen($file, 'w');

        try {
            if ($handle === false) {
                throw new RuntimeException('Неизвестная ошибка открытия файла');
            }
        } catch (RuntimeException $e) {
            echo $e->getMessage();
            exit;
        }

        foreach ($comments as $key => $value) {
            fwrite($handle, 'Пост № ' . $key + 1 . PHP_EOL);
            fwrite($handle, 'Автор: ' . $value->getAuthor() . PHP_EOL);
            fwrite($handle, 'Сообшение: ' . $value->getText() . PHP_EOL);
        }

        fclose($handle);
    }
}
