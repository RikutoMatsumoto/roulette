<?php
// add_user.php

// データベース接続
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "roulette";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("接続失敗: " . $conn->connect_error);
}

// POSTデータ取得
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = isset($_POST['new_name']) ? $_POST['new_name'] : '';

    // 名前が空でないか確認
    if (!empty($new_name)) {
        // ユーザーをデータベースに追加
        $stmt = $conn->prepare("INSERT INTO user (name) VALUES (?)");
        $stmt->bind_param("s", $new_name);
        $stmt->execute();
        $stmt->close();
    }

    // 追加後に一覧ページにリダイレクト
    header('Location: index.php');
    exit();
}
//データベース接続を閉じる
$conn->close();
?>
