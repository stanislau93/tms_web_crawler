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

        // $domDoc->loadHTMLFile($url);                     //сыпал предупреждения: Warning: DOMDocument::loadHTMLFile(): htmlParseEntityRef: expecting ';' 
        @$domDoc->loadHTMLFile($url);                       // подавил их
        
        $commentExpression = $config['xpath_comment_expression'];

        $commentTextExpression = $config['xpath_comment_text_expression'];
        $commentAuthorExpression = $config['xpath_comment_author_expression'];

        $xpath = new \DomXpath($domDoc);

        $elements = $xpath->query($commentExpression);

        if ($elements->length == 0) {
            echo "не нашел комментариев по заданному выражению!\n$commentExpression";
            return [];
        }
        
        echo "I found {$elements->length} element(s)\n";

        $comments = [];
        
        /** @var \DomNode $element */
        foreach ($elements as $key => $element) {
            $text = $xpath->query($commentTextExpression, $element)[$key];
            $author = $xpath->query($commentAuthorExpression, $element)[$key];
            
            $comment = new Comment();
            $comment->setText($text->textContent);
            $comment->setAuthor($author->textContent);
            
            $comments[] = $comment;
        }
        
        return $comments;
    }
}
