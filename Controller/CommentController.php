<?php

namespace MyApp\Controller;

use MyApp\Service\CrawlerServiceInterface;
use MyApp\Service\ForumCrawlerService;

class CommentController
{
    private CrawlerServiceInterface $crawlerService;

    public function __construct()
    {
        $this->crawlerService = new ForumCrawlerService();
    }

    public function crawlPage(array $request): int
    {
        $config = [
            'xpath_comment_expression' => $request['comment_expression'],
            'xpath_comment_text_expression' => $request['comment_text_expression'],
            'xpath_comment_author_expression' => $request['comment_author_expression'],
        ];

        /** @var Comment[] $comments */
        $comments = $this->crawlerService->crawl($request['url'], $config);

        echo "Автор третьего комментария:".$comments[2]->getAuthor();

        return 1;
    }
}
