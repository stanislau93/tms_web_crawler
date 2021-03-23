<?php

const FILENAME = 'messages';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    file_put_contents(FILENAME, json_encode($_POST).PHP_EOL, FILE_APPEND);

    echo true;
} else {
    header('Content-Type: application/json');

    if (!file_exists(FILENAME)) {
        echo json_encode(null);
        die();
    }

    $file = file(FILENAME);
    $firstMessage = $file[0];
    
    if (empty($firstMessage)) {
        echo json_encode(null);
        die();
    } else {
        unset($file[0]);
        file_put_contents(FILENAME, $file);
        echo $firstMessage;
    }

}
