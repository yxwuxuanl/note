<?php

$id = uniqid();

$file = $_FILES['image'];
move_uploaded_file($file['tmp_name'], __DIR__ . "/../static/images/{$id}.png");

echo $id;