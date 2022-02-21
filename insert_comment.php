<?php

require_once "db.php";

function insertComment($parent_id, $topic_id, $body) {
    $sql = "
        INSERT INTO comments (parent_id, topic_id, body)
        VALUES (?,?,?)
        ;
    ";
    try {
        $GLOBALS['connection']
            ->prepare($sql)
            ->execute([$parent_id, $topic_id, $body]);
    } catch (\Exception $e) {
        http_response_code( 500 );
    }
}

$comment = json_decode(file_get_contents('php://input'), true);

insertComment((int)$comment['parent_id'], (int)$comment['topic_id'], $comment['body']);