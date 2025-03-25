<?php
// delete_user.php
require_once 'UserModel.php';
$userModel = new UserModel();

// POSTで受け取る
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id > 0) {
    $userModel->deleteUser($id);
}

// 削除後に一覧ページへ戻る
header('Location: index.php');
exit;
?>