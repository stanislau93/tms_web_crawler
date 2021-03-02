<?php

namespace MyApp\Tests;

use MyApp\Service\ForumCrawlerService;
use PHPUnit\Framework\TestCase;

final class ForumCrawlerTest extends TestCase 
{   
    private ForumCrawlerService $crawl;

    public function setUp(): void
    {
        $this->crawl = new ForumCrawlerService();
    }

    public function testCrawl()
    {
        $url = 'Tests/test.html';

        $config = [
            'xpath_comment_expression' => '//ul[@class="b-messages-thread"]/li[@id]',
            'xpath_comment_text_expression' => './/div[@class="content"]',
            'xpath_comment_author_expression' => './/big[starts-with(@class,"mtauthor-nickname userid")]//a[starts-with(@class,"_name")]',
        ];

        $comments = $this->crawl->crawl($url, $config);

        $this->assertCount(20, $comments);

        $this->assertEquals('RET_FRAN', $comments[0]->getAuthor());
        $this->assertEquals('zinaida', $comments[1]->getAuthor());
        $this->assertEquals('86yzneR', $comments[5]->getAuthor());
        $this->assertEquals('Leo.mogilev', $comments[6]->getAuthor());
        $this->assertEquals('LittleOne', $comments[7]->getAuthor());
    }
}