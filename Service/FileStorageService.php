<?php

namespace MyApp\Service;

use RuntimeException;

class FileStorageService implements StorageServiceInterface
{
    private const FILENAME_BASE = 'COMMENTS_';

    private function getNewFileName(): string
    {
        return self::FILENAME_BASE.time().'.txt';
    }

    /**
     * @param Comment[] $comments
     */
    public function storeComments(array $comments): array
    {
        $file = $this->getNewFileName();
        $handle = fopen($file, 'w');

        if ($handle === false) {
            throw new RuntimeException('Неизвестная ошибка открытия файла');
        }
        
        foreach ($comments as $key => $value) {
            fwrite($handle, 'Пост № ' . ($key + 1) . PHP_EOL);
            fwrite($handle, 'Автор: ' . $value->getAuthor() . PHP_EOL);
            fwrite($handle, 'Сообшение: ' . $value->getText() . PHP_EOL);
        }

        fclose($handle);

        return [
            'file_name' => $file
        ];
    }
}
