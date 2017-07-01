<?php

include __DIR__ . '/db.php';

$moods = [
	[
		'happy note', 'h'
	],
	[
		'missing note', 'm'
	],
	[
		'sad note', 's'
	],
	[
		'normal note', 'n'
	]
];

for($i = 4; $i <= 100; $i++)
{
	$date = date('Y-m-d',strtotime('-' . rand(0, 100) . ' day'));
	$r = rand(0, 3);

	$content = $moods[$r][0];
	$type = rand(0, 1);
	$mood = $moods[$r][1];

	$sql = "INSERT INTO `main` (`date`, `content`, `type`, `mood`, `id`) VALUES ('$date', '$content', '$type', '$mood', $i)";
	$db->exec($sql);
}