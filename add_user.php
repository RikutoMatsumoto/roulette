<?php
// add_user.php
require_once 'UserModel.php';

$userModel = new UserModel();

// フォームからPOSTメソッドで送られてきた場合のみ実行
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = $_POST['new_name'] ?? '';

    // 名前が空でない場合のみ追加
    if (!empty($new_name)) {
        $userModel->addUser($new_name);
    }

    // 追加後に一覧ページにリダイレクト
    header('Location: index.php');
    exit();
}

header('Location: index.php');
exit();
