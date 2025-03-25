<?php
// delete_user.php

// データベース接続
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "roulette";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}

// GETでidを取得
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // ユーザーを削除するSQL文
    $stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// 削除後に一覧ページにリダイレクト
header('Location: index.php');
exit();

$conn->close();
?>
