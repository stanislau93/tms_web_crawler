<?php

namespace MyApp\Service;


class DataBaseStorageService implements StorageServiceInterface
{
    public function storeComments(array $comments): array
    {
        $mysqli = new \mysqli('localhost', 'root', '', 'crawler');

        # создай таблицу, если её ещё не существует
        $query = "CREATE TABLE IF NOT EXISTS `comment`(
            id INT PRIMARY KEY AUTO_INCREMENT,
            Author VARCHAR(100), 
            Comment VARCHAR(5000)
            )";

        $res = $mysqli->query($query);

        if (!$res) {
            throw new \RuntimeException('Ошибка создания таблицы');
            return [0];
        }

        # добавь запись в таблицу        
        foreach ($comments as $key => $comment) {
            $author = $mysqli->real_escape_string($comment->getAuthor());
            $text = $mysqli->real_escape_string($comment->getText());
            $query = "INSERT INTO `comment` (`Author`, `Comment`) VALUES('{$author}', '{$text}')";
            $res = $mysqli->query($query);
            if (!$res) {
                $log = date('Y-m-d H:i:s') . ' Comment number: ' . $key . '; Error number: ' . $mysqli->errno . '; Error text: ' . $mysqli->error;
                file_put_contents(__DIR__ . '/log.txt', $log . PHP_EOL, FILE_APPEND);
                throw new \RuntimeException('Ошибка записи в БД, смотри LOG-файл');
            }
        }

        $mysqli->close();
        return [1];
    }
}
