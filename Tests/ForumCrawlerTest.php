<?php

namespace App\Tests;

use DOMDocument;
use DOMXPath;
use MyApp\Domain\Comment;
use PHPUnit\Framework\TestCase;

final class ForumCrawlerTest extends TestCase 
{
    public function testForumCrawler()
    {
        $domDoc = new DOMDocument();

        @$domDoc->loadHTMLFile('https://forum.onliner.by/viewtopic.php?t=19991115');

        $this->assertNotFalse($domDoc);

        $commentExpression = '//ul[@class="b-messages-thread"]/li[@id]';
        $commentTextExpression = '//div[@class="content"]';
        $commentAuthorExpression = '//big[starts-with(@class,"mtauthor-nickname userid")]//a[starts-with(@class,"_name")]';

        $xpath = new DOMXPath($domDoc);

        $elements = $xpath->query($commentExpression);
        
        $this->assertCount(20, $elements);

        $comments = [];
        
        foreach ($elements as $key => $element) {
            $text = $xpath->query($commentTextExpression, $element)[$key];
            $author = $xpath->query($commentAuthorExpression, $element)[$key];
            
            $comment = new Comment();
            $comment->setText($text->textContent);
            $comment->setAuthor($author->textContent);           
            
            $comments[] = $comment;
        }

        $this->assertCount(20, $comments);

        $this->assertEquals('RET_FRAN', $comments[0]->getAuthor());
        $this->assertEquals('zinaida', $comments[1]->getAuthor());
        $this->assertEquals('86yzneR', $comments[5]->getAuthor());
        $this->assertEquals('Leo.mogilev', $comments[6]->getAuthor());
        $this->assertEquals('LittleOne', $comments[7]->getAuthor());
    }    
}