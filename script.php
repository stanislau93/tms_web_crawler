<?php

require_once __DIR__ . '/vendor/autoload.php';

use MyApp\Controller\CommentController;
use MyApp\Service\CrawlerServiceFactory;
use MyApp\Service\FileStorageService;

if ($_POST['type'] == 'forum') {
    if ($_POST['comment_text_expression'][0] != '.') {
        $_POST['comment_text_expression'] = '.' . $_POST['comment_text_expression'];
    }

    if ($_POST['comment_author_expression'][0] != '.') {
        $_POST['comment_author_expression'] = '.' . $_POST['comment_author_expression'];
    }

    $request = [
        'url' => $_POST['url'],
        'comment_expression' => $_POST['comment_expression'],
        'comment_text_expression' => $_POST['comment_text_expression'],
        'comment_author_expression' => $_POST['comment_author_expression'],
        'type' => $_POST['type']
    ];
}

if ($_POST['type'] == 'reddit') {
    $request = [
        'url' => $_POST['url'],        
        'type' => $_POST['type']
    ];
}

// ТЕСТОВЫЕ ДАННЫЕ

// $request = [
//     'url' => "https://forum.onliner.by/viewtopic.php?t=19991115",
//     'comment_expression' => '//ul[@class="b-messages-thread"]/li[@id]',
//     'comment_text_expression' => './/div[@class="content"]',
//     'comment_author_expression' => './/big[starts-with(@class,"mtauthor-nickname userid")]//a[starts-with(@class,"_name")]',
// ];

$controller = new CommentController(new CrawlerServiceFactory, new FileStorageService());

if ($_POST['type'] === 'forum') {
    $result = $controller->crawlPage($request);
}

if ($_POST['type'] === 'reddit') {
    $result = $controller->crawlRedditPage($request);
}

