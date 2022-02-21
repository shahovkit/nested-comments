<?php
require_once "db.php";

$lastDate = file_get_contents('php://input');

date_default_timezone_set('Europe/Moscow');
$date = date('Y-m-d H:i:s', (int)$lastDate);

$sql = "
    select *
    from comments
    where created_at > '{$date}'
    ;
";

$comments = fetchAll($sql);


echo json_encode($comments);

