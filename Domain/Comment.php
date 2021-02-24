<?php

namespace MyApp\Domain;

class Comment
{
    private string $text;

    private string $author;

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }
}
