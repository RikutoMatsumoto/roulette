<?php
// UserModel.php
// require_once 'db.php'; //同ディレクトリ
require_once __DIR__ . '/../../config/db.php'; //１つ上のディレクトリ
// require_once __DIR__ . '/config/db.php';


/**
 * User関連の操作をまとめたクラス
 */
class UserModel
{
    /**
     * announcer=1 のユーザーを取得
     */
    public function getAnnouncerUsers() {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT id, name FROM user WHERE announcer = 1");
        $stmt->execute();
        $result = $stmt->get_result();

        $names = [];
        while ($row = $result->fetch_assoc()) {
            $names[] = [
                'id' => $row['id'],
                'name' => htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8')
            ];
        }

        $stmt->close();
        $conn->close();
        return $names;
    }

    /**
     * 全ユーザーを取得（チェックボックス一覧用）
     */
    public function getAllUsers() {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT id, name, announcer FROM user");
        $stmt->execute();
        $result = $stmt->get_result();

        $allUsers = [];
        while ($row = $result->fetch_assoc()) {
            $allUsers[] = [
                'id' => $row['id'],
                'name' => htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'),
                'announcer' => (int)$row['announcer']
            ];
        }

        $stmt->close();
        $conn->close();
        return $allUsers;
    }

    /**
     * announcer フラグを更新
     */
    public function updateAnnouncer($id, $announcer) {
        $conn = getConnection();
        $stmt = $conn->prepare("UPDATE user SET announcer = ? WHERE id = ?");
        $stmt->bind_param("ii", $announcer, $id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    /**
     * 指定ユーザーを削除
     */
    public function deleteUser($id) {
        $conn = getConnection();
        $stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    /**
     * ユーザーを追加
     */
    public function addUser($name) {
        if (empty($name)) {
            return false;
        }

        $conn = getConnection();
        $stmt = $conn->prepare("INSERT INTO user (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        return true;
    }
}
