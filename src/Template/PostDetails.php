<?php

namespace silverorange\DevTest\Template;

use silverorange\DevTest\Context;

class PostDetails extends Layout
{
    protected function renderPage(Context $context): string
    {
        $post = json_decode($context->content, true);
        $content = '';
        if (!empty($post)) {
            $content = '<div class="frame"><h2 class="frame__title"> ' . $post["title"] . '</h2>';
            $id = $post['id'];
            $content .= '<div class="frame__contents"> ';
            $content .= "<p><b>ID: </b> " . $post['id'] . "<br>" ;
            $content .= "<b>Created At: </b> " . $post['created_at'] . "<br>" ;
            $content .= "<b>Last Updated At: </b> " . $post['modified_at'] . "<br>" ;
            $content .= "<b>Author: </b>" . $post['full_name'] . "</p>";
            $content .= "<p><b>Post Body: </b><br>" . $post['body'] . "</p><hr></div>";
            $content .= '<div><input class="back-btn" type="button" value="Go Back!" onclick="history.back()"></div>';

            $content .= '</div>';
        } else {
            // Handle the case where fetching posts failed
            $content = "<p>Nothing to show.</p>";
        }
        return <<<HTML
{$content}
HTML;
        // @codingStandardsIgnoreEnd
    }
}
