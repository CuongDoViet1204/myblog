<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ AJAX
    if (!empty($_POST["data"])) {
        $data = json_decode($_POST["data"]);
        $dbh = new PDO('mysql:host=db;port=3306;dbname=btlBlog', 'root', 'root');
        if ($data[4] != '') {
            $stmt = $dbh->prepare('INSERT INTO posts(id_email, subject, content, format_subject, format_content, img) VALUES (:id_email, :subject, :content, :format_subject, :format_content, :img)');
            $stmt->bindParam(':id_email', $_SESSION['user']['id_email']);
            $stmt->bindParam(':subject', $data[0]);
            $stmt->bindParam(':content', $data[1]);
            $stmt->bindParam(':format_subject', $data[2]);
            $stmt->bindParam(':format_content', $data[3]);
            $stmt->bindParam(':img', $data[4]);
            $stmt->execute();
        } else {
            $stmt = $dbh->prepare('INSERT INTO posts(id_email, subject, content, format_subject, format_content) VALUES (:id_email, :subject, :content, :format_subject, :format_content)');
            $stmt->bindParam(':id_email', $_SESSION['user']['id_email']);
            $stmt->bindParam(':subject', $data[0]);
            $stmt->bindParam(':content', $data[1]);
            $stmt->bindParam(':format_subject', $data[2]);
            $stmt->bindParam(':format_content', $data[3]);
            $stmt->execute();
        }
    }
}
?>
  