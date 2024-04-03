<?php

namespace silverorange\DevTest\Controller;

use silverorange\DevTest\Context;
use silverorange\DevTest\Template;
use silverorange\DevTest\Model\Post;

class PostIndex extends Controller
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
        return new Template\PostIndex();
    }

    protected function loadData(): void
    {
        // TODO: Load posts from database here.
        $postObj = new Post($this->db);
        $posts = $postObj->getAllPosts();

        // Display the fetched posts (or do whatever you want with them)
        if ($posts !== false) {
            $this->posts =         $posts;
        } else {
            // Handle the case where fetching posts failed
            echo "Failed to fetch posts.";
        }
    }
}
