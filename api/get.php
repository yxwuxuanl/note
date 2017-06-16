<?php
/**
 * Created by PhpStorm.
 * User: 2m
 * Date: 2017/6/15
 * Time: 下午8:15
 */

include './db.php';

$page = $_GET['page'];
$start = ($page - 1) * 20;
$order = $_GET['order'];

$query = $db->query("SELECT * FROM `main` ORDER BY `date` {$order} LIMIT {$start}, 20");
// $query = $conn->query("SELECT * FROM `main` ORDER BY `date` DESC");

$nodes = [];

while($row = $query->fetchArray(SQLITE3_ASSOC))
{
    $nodes[] = $row;
}

echo json_encode($nodes);