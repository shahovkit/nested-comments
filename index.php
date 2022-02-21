<?php

require_once "db.php";

$topicId = (int)($_GET['topic_id']??1);

function getNestedComments($topicId, $parentId = 0) {

    $sql = "
        select *
        from comments
        where topic_id = {$topicId}
            and parent_id = {$parentId}
        ;
    ";

    $comments = fetchAll($sql);

    if (count($comments) > 0 && is_array($comments)) {
        foreach ($comments as &$comment) {
            $childs = getNestedComments($topicId, $comment['id']);
            if (count($childs) > 0) {
                $comment['childs'] = $childs;
            }
        }
    }

    return $comments;
}

$comments = getNestedComments($topicId);

include "view_comment.php";
?>
