<?php
/**
 * Created by PhpStorm.
 * User: 2m
 * Date: 2017/6/15
 * Time: 下午8:47
 */

include './db.php';

$query = $db->query('SELECT COUNT(*) AS `count`, `mood` FROM `main` GROUP BY `mood`');
$count = [];

$sum = 0;

while($row = $query->fetchArray(SQLITE3_ASSOC))
{
    $sum += $row['count'];
    $count[$row['mood']] = $row['count'];
}


$count['sum'] = $sum;

echo json_encode($count);