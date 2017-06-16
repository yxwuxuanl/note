<?php

include './db.php';

$id = $_GET['id'];

try
{
    $db->exec("DELETE FROM `main` WHERE `id` = {$id}");

    if($db->lastErrorCode()) throw new Exception();
    echo json_encode(['status' => 'success']);
}catch(Exception $e)
{
    echo json_encode(['status' => 'fail', 'error' => $db->lastErrorMsg()]);
}
