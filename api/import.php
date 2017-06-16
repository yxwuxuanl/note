<?php

$db = new mysqli('127.0.0.1', 'root', '103002', 'note');
$db->set_charset('utf8');

$stmt = $db->prepare('INSERT INTO `main` (`date`, `type`, `mood`, `content`) VALUES (?,?,?,?)');

$stmt->bind_param('ssss', $date, $type, $mood, $content);
$moods = ['s', 'h', 'm', 'n'];

$content = 'Note Content';

for($i = 1 ; $i <= 100 ; $i++)
{
    $date = '2017-' . rand(1, 6) . '-' . rand(1, 30);
    $type = rand(0, 1);
    $mood = $moods[rand(0, 3)];
    $stmt->execute();
    // break;
}