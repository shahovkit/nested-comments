<?php

require_once "db.php";

$sql = "
    INSERT INTO comments
    values 
           (1, 0, 1, 'So cool!',now()),
           (2, 1, 1, 'Yeah!',now()),
           (3, 0, 1, 'Hey guys, how are you?',now()),
           (4, 3, 1, 'Im fine! 8)',now()),
           (5, 0, 1, 'I need your help, Luke. She needs your help. Im getting too old for this sort of thing',now()),
           (6, 5, 1, 'I dont know what youre talking about. I am a member of the Imperial Senate on a diplomatic mission to Alderaan',now());
";

$GLOBALS['connection']->exec($sql);