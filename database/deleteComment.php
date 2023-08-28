<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ AJAX
    if (!empty($_POST["data"])) {
        $data = $_POST["data"];
        $dbh = new PDO('mysql:host=db;port=3306;dbname=btlBlog', 'root', 'root');

        $stmt = $dbh->prepare('SELECT post_id FROM comments WHERE comment_id = :comment_id');
        $stmt->bindParam(':comment_id', $data);
        $stmt->execute();
        $row = $stmt->fetch();

        $stmt = $dbh->prepare('UPDATE posts set comment_number = comment_number - 1 WHERE post_id = :post_id');
        $stmt->bindParam(':post_id', $row['post_id']);
        $stmt->execute();

        $stmt = $dbh->prepare('DELETE FROM comments WHERE comment_id = :comment_id');
        $stmt->bindParam(':comment_id', $data);
        $stmt->execute();
    }
}