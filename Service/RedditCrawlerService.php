<?php

namespace MyApp\Service;

use MyApp\Domain\Comment;

class RedditCrawlerService implements CrawlerServiceInterface
{
    public function crawl(string $url, array $config): array
    {
        if (substr($url, -5) !== '.json') {
            $url .= '.json';
        }

        $resource = curl_init();
        curl_setopt($resource, CURLOPT_URL, $url);
        curl_setopt($resource, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($resource);
        curl_close($resource);

        $result = json_decode($result, true);

        $comment = new Comment();
        $comment->setAuthor($result[0]['data']['children'][0]['data']['author']);
        $comment->setText($result[0]['data']['children'][0]['data']['selftext']);
        $comments[] = $comment;

        foreach ($result[1]['data']['children'] as $element) {
            if (!isset($element['data']['author'])) {
                continue;
            }

            $comment = new Comment();
            $comment->setAuthor($element['data']['author']);
            $comment->setText($element['data']['body']);
            $comments[] = $comment;
        }

        return $comments;
    }
}
