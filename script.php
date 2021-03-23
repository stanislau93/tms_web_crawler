<?php

require_once __DIR__ . '/vendor/autoload.php';

use MyApp\Controller\CommentController;
use MyApp\Service\CrawlerServiceFactory;
use MyApp\Service\FileStorageService;

const QUEUE_URL = 'http://localhost:8888/';

$controller = new CommentController(new CrawlerServiceFactory(), new FileStorageService());

while (true) {
    $message = json_decode(file_get_contents(QUEUE_URL), true);

    if ($message){
        $controller->crawlPage($message);

        var_dump("crawled successfully!", $message['type']);
    } else {
        var_dump("waiting");
    }

    sleep(1);
}

// $result = $controller->crawlPage();

// ТЕСТОВЫЕ ДАННЫЕ

// $request = [
//     'url' => "https://forum.onliner.by/viewtopic.php?t=19991115",
//     'comment_expression' => '//ul[@class="b-messages-thread"]/li[@id]',
//     'comment_text_expression' => './/div[@class="content"]',
//     'comment_author_expression' => './/big[starts-with(@class,"mtauthor-nickname userid")]//a[starts-with(@class,"_name")]',
// ];
