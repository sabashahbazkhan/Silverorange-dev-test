<?php

namespace silverorange\DevTest\Controller;

use silverorange\DevTest\Context;
use silverorange\DevTest\Template;
use silverorange\DevTest\Model\Post;

class PostImport extends Controller
{
    private array $posts = [];

    public function getContext(): Context
    {
        $context = new Context();
        $context->title = 'Posts';
        $context->content = json_encode($this->posts);
        return $context;
    }

    public function getTemplate(): Template\Template
    {
        return new Template\PostImport();
    }

    protected function loadData(): void
    {
        $postObj = new Post($this->db);
        $index = 0;
        foreach (glob("data/*.json") as $file) {
            $jsonData = file_get_contents($file);
            $data = json_decode($jsonData, true);
            $this->posts[] = $postObj->importPosts($data);
        }
    }
}
