<?php

namespace MyApp\Service;

use MyApp\Domain\Comment;

class ForumCrawlerService implements CrawlerServiceInterface
{
    /**
     * @return Comment[]
     */
    public function crawl(string $url, array $config): array
    {
        $domDoc = new \DomDocument();
        
        @$domDoc->loadHTMLFile($url);                     
        
        $commentExpression = $config['comment_expression'];
        
        $commentTextExpression = $config['comment_text_expression'];
        $commentAuthorExpression = $config['comment_author_expression'];

        if ($commentTextExpression[0] !== '.') {
            $commentTextExpression = '.' . $commentTextExpression;
        }

        if ($commentAuthorExpression[0] !== '.') {
            $commentAuthorExpression = '.' . $commentAuthorExpression;
        }

        $xpath = new \DomXpath($domDoc);

        $elements = $xpath->query($commentExpression);

        if ($elements->length == 0) {
            echo "не нашел комментариев по заданному выражению!\n$commentExpression";
            return [];
        }
        
        echo "I found {$elements->length} element(s)\n";

        $comments = [];
        
        /** @var \DomNode $element */
        foreach ($elements as $element) {
            $text = $xpath->query($commentTextExpression, $element)[0];
            $author = $xpath->query($commentAuthorExpression, $element)[0];
            
            $comment = new Comment();
            $comment->setText($text->textContent);
            $comment->setAuthor($author->textContent);
            
            $comments[] = $comment;
        }
        
        return $comments;
    }
}
