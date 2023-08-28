<?php

$dbh = new PDO('mysql:host=db;port=3306;dbname=btlBlog', 'root', 'root');
$st = $dbh->prepare('SELECT MAX(post_id) from posts');
$st->execute();
echo $st->fetch()['MAX(post_id)'];