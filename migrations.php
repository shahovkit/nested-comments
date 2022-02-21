<?php

require_once "db.php";

$sql = '
    CREATE TABLE comments (
        id int AUTO_INCREMENT UNIQUE PRIMARY KEY, 
        parent_id int,
        topic_id int, 
        body TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
';

$GLOBALS['connection']->exec($sql);

