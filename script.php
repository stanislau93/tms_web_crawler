<?php

require_once __DIR__ . '/vendor/autoload.php';

use MyApp\Controller\CommentController;
use MyApp\Service\CrawlerServiceFactory;
use MyApp\Service\FileStorageService;

$controller = new CommentController(new CrawlerServiceFactory(), new FileStorageService());
$result = $controller->crawlPage();

// ТЕСТОВЫЕ ДАННЫЕ

// $request = [
//     'url' => "https://forum.onliner.by/viewtopic.php?t=19991115",
//     'comment_expression' => '//ul[@class="b-messages-thread"]/li[@id]',
//     'comment_text_expression' => './/div[@class="content"]',
//     'comment_author_expression' => './/big[starts-with(@class,"mtauthor-nickname userid")]//a[starts-with(@class,"_name")]',
// ];
