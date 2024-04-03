<?php

namespace silverorange\DevTest\Template;

use silverorange\DevTest\Context;

class PostImport extends Layout
{
    protected function renderPage(Context $context): string
    {
        // @codingStandardsIgnoreStart
        $posts = json_decode($context->content,true);
        $content='';
        if (!empty($posts)) {
            $content = '<div class="frame"><h2 class="frame__title">Posts Import Status</h2>';
            foreach ($posts as $post) {

                $content.='<div class="frame__contents"> ';
                $content.= "<b>ID: </b>" . $post['id'] . "<br>";
                $content.= "<b>Success:</b> " . $post['success'] . "<br>";
                $content.= "<b>Message: </b>" . $post['message'] . "<hr></div>";
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
