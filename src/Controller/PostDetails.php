<?php

namespace silverorange\DevTest\Controller;

use silverorange\DevTest\Context;
use silverorange\DevTest\Template;
use silverorange\DevTest\Model;
use silverorange\DevTest\Model\Post;

class PostDetails extends Controller
{
    private array $post = [];

    public function getContext(): Context
    {
        $context = new Context();

        if (empty($this->post)) {
            $context->title = 'Not Found';
            $context->content = "A post with id {$this->params[0]} was not found.";
        } else {
            $context->title = $this->post['title'];
            $context->content = json_encode($this->post);
        }

        return $context;
    }

    public function getTemplate(): Template\Template
    {
        if ($this->post === null) {
            return new Template\NotFound();
        }

        return new Template\PostDetails();
    }

    public function getStatus(): string
    {
        if ($this->post === null) {
            return $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found';
        }

        return $_SERVER['SERVER_PROTOCOL'] . ' 200 OK';
    }

    protected function loadData(): void
    {
        // TODO: Load post from database here. $this->params[0] is the post id.

        $postObj = new Post($this->db);
        $posts = $postObj->getPostByID($this->params[0]);
        // Display the fetched posts (or do whatever you want with them)
        if ($posts !== false) {
            $this->post =         $posts[0];
        } else {
            // Handle the case where fetching posts failed
            echo "Failed to fetch posts.";
        }
    }
}
