<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ AJAX
    if (!empty($_POST["data"])) {
        $data = $_POST["data"];
        $dbh = new PDO('mysql:host=db;port=3306;dbname=btlBlog', 'root', 'root');
        $stmt = $dbh->prepare('SELECT * FROM posts WHERE post_id = :post_id');
        $stmt->bindParam(':post_id', $data);
        $stmt->execute();
        $row = $stmt->fetch();
        echo json_encode($row);
    }
}