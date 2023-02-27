<?php
$post_id = 1;

$url = 'http://localhost:8081/hs-comment-system/api/comments/' . $post_id;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
$comments = curl_exec($ch);
if (!$comments) {
    echo curl_error($ch);
} else {
    curl_close($ch);
    $json_result = json_decode($comments);

    echo arrange_comments($json_result->comments);
}

function arrange_comments($comments, $parent = 0)
{
    $result = '<ul>';
    foreach ($comments as $comment) {
        if ($comment->parent_id == $parent) {
            $result .= "<li>{$comment->comment}";

            if (has_children($comments, $comment->id)) {
                $result .= arrange_comments($comments, $comment->id);
            }
            $result .= '</li>';
        }
    }
    $result .= '</ul>';
    return $result;
}

function has_children($comments, $id)
{
    foreach ($comments as $comment) {
        if ($comment->parent_id == $id) {
            return true;
        }
    }
    return false;
}
