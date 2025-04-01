<?php
// delete_user.php
require_once __DIR__ . '/../models/UserModel.php';
$userModel = new UserModel();

// POSTで受け取る
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id > 0) {
    $userModel->deleteUser($id);
}

// 削除後に一覧ページへ戻る
header('Location: /roulette/roulette/public/index.php');
exit;
?>