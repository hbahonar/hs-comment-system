<?php
include './classes/database.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$action = $uri[3];

$database = new Database();

if ($action === 'post') {
    $post_id = $uri[4];

    if ($post = $database->getPost($post_id)) {
        return_json(['post' => $post]);
    }
} elseif ($action === 'addcomment') {
    $rest_json = file_get_contents('php://input');
    $_POST = json_decode($rest_json, true);
    $post_id = $_POST['postId'];
    $comment = $_POST['comment'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $parentId = $_POST['parentId'];

    if (
        $database->insertComment([
            'comment' => $comment,
            'user_email' => $email,
            'user_name' => $name,
            'date' => date('Y-m-d H:i:s'),
            'parent_id' => $parentId,
            'status' => 0,
            'admin_id' => null,
            'post_id' => $post_id,
        ])
    ) {
        return_json(['comments' => $database->getComments($post_id)]);
    }
} 
elseif ($action === 'comments') {
    $post_id = $uri[4];
    return_json(['comments' => $database->getComments($post_id)]);
}
// elseif ($action === 'comments') {
//     $post_id = $uri[4];

//     if ($comments = $database->getComments($post_id)) {
//         return_json(['comments' => arrange_comments($comments)]);
//     }
// }

$_comments = [];
function arrange_comments($comments, $parent = 0)
{
    foreach ($comments as $comment) {
        if ($comment['parent_id'] == $parent) {
            $_comment = $comment;
            if (has_children($comments, $comment['id'])) {
                $_comment['subcomment'] = arrange_comments(
                    $comments,
                    $comment['id']
                );
            }

            $_comments[] = $_comment;
        }
    }

    return $_comments;
}

function has_children($comments, $id)
{
    foreach ($comments as $comment) {
        if ($comment['parent_id'] == $id) {
            return true;
        }
    }
    return false;
}

return_json(['status' => 0]);

function return_json($arr)
{
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: *');
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($arr);
    exit();
}
