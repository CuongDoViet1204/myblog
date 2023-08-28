<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ AJAX
    if (!empty($_POST["data"])) {
        $data = $_POST["data"];
        $dbh = new PDO('mysql:host=db;port=3306;dbname=btlBlog', 'root', 'root');
        $st = $dbh->prepare('SELECT comment_number from posts WHERE post_id = :post_id');
        $st->bindParam(':post_id', $data);
        $st->execute();
        echo $st->fetch()['comment_number'];
    }
}