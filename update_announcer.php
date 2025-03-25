//riku追加
<?php
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
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$announcer = isset($_POST['announcer']) ? (int)$_POST['announcer'] : 0;

if ($id > 0) {
    $stmt = $conn->prepare("UPDATE user SET announcer = ? WHERE id = ?");
    $stmt->bind_param("ii", $announcer, $id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
?>
