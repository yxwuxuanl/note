<?php
/**
 * Created by PhpStorm.
 * User: 2m
 * Date: 2017/6/15
 * Time: 下午8:11
 */

include __DIR__ . '/db.php';

$type = $_POST['type'];
$date = $type === '1' ? $_POST['date'] : date('Y-m-d');
$mood = $_POST['mood'];
$content = $_POST['content'];
$image = $_POST['image'];

$query = $db->query('SELECT `id` FROM `main` ORDER BY `id` DESC LIMIT 1');
$lastId = $query->fetchArray(SQLITE3_ASSOC)['id'];

if($lastId === null)
{
    $id = 0;
}else{
    $id = $lastId + 1;
}

$sql = "INSERT INTO `main` (`date`, `type`, `mood`, `content`, `image`, `id`) VALUES ('$date', '$type', '$mood', '$content', '$image', $id)";

try
{
    if(!$db->query($sql)) throw new Exception();

    echo json_encode(['status' => 'success', 'id' => $id]);
}catch(Exception $e)
{
    echo json_encode(['status' => 'fail']);
}

