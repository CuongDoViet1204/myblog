<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ AJAX
    if (!empty($_POST["data"])) {
        $data = $_POST["data"];
        $dbh = new PDO('mysql:host=db;port=3306;dbname=btlBlog', 'root', 'root');
        $stmt = $dbh->prepare('SELECT * FROM users WHERE id_email = :id_email');
        $stmt->bindParam(':id_email', $data);
        $stmt->execute();
        $row = $stmt->fetch();
        echo json_encode($row);
    }
}