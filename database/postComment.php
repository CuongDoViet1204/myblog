<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ AJAX
    if (!empty($_POST["data"])) {
        $data = json_decode($_POST["data"]);
        $dbh = new PDO('mysql:host=db;port=3306;dbname=btlBlog', 'root', 'root');
        $stmt = $dbh->prepare('INSERT INTO comments(id_email, post_id, comment_content) VALUES (:id_email, :post_id, :comment_content)');
        $stmt->bindParam(':id_email', $data[0]);
        $stmt->bindParam(':post_id', $data[1]);
        $stmt->bindParam(':comment_content', $data[2]);
        $stmt->execute();

        $stmt = $dbh->prepare('UPDATE posts set comment_number = comment_number + 1 WHERE post_id = :post_id');
        $stmt->bindParam(':post_id', $data[1]);
        $stmt->execute();
    }
}