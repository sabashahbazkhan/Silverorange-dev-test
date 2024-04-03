<?php

namespace silverorange\DevTest\Template;

use silverorange\DevTest\Context;

class PostIndex extends Layout
{
    protected function renderPage(Context $context): string
    {
        // @codingStandardsIgnoreStart
        $posts = json_decode($context->content,true);
        $content='';
        if (!empty($posts)) {
            $content = '<div class="frame"><h2 class="frame__title">All Posts</h2>';
            foreach ($posts as $post) {
                $id = $post['id'];
                $content.='<div class="frame__contents"> ';
                $content.= "<h2><a class='heading-link' href='/posts/". $id. "' >" . $post['title'] . "</a></h2>";
                $content.= "<b>Created At:</b> " . $post['created_at']."<br>" ;
                $content.= "<b>Author: </b>" . $post['full_name'] . "<hr></div>";
            }
            $content.='</div>';
        } else {
            // Handle the case where fetching posts failed
            $content= "<p>Nothing to show.</p>";
        }
        return <<<HTML
{$content}
HTML;
        // @codingStandardsIgnoreEnd
    }
}
