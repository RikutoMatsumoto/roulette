<?php
// db.php

// データベース接続情報を定数化
define('DB_HOST', 'localhost');
define('DB_USER', 'username');
define('DB_PASS', 'password');
define('DB_NAME', 'roulette');

/**
 * データベース接続を行い、mysqliインスタンスを返す
 */
function getConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("データベース接続失敗: " . $conn->connect_error);
    }
    return $conn;
}
