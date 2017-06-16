<?php
/**
 * Created by PhpStorm.
 * User: 2m
 * Date: 2017/6/15
 * Time: 下午8:11
 */

include './db.php';

$type = $_POST['type'];
$date = $type === '1' ? $_POST['date'] : date('Y-m-d');
$mood = $_POST['mood'];
$content = $_POST['content'];
$image = $_POST['image'];

$sql = "INSERT INTO `main` (`date`, `type`, `mood`, `content`, `image`) VALUES ('$date', '$type', '$mood', '$content', '$image')";

try
{
    if(!$db->query($sql)) throw new Exception();

    echo json_encode(['status' => 'success']);
}catch(Exception $e)
{
    echo json_encode(['status' => 'fail']);
}

