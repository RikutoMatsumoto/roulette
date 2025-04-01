# ルーレットWebアプリ

p5.js + PHP を使った、シンプルなルーレットアプリです。  
ユーザーを登録し、その中からランダムに抽選できます。

---

## ⚙️ セットアップ方法

1. XAMPPなどの環境で `htdocs/roulette/` に配置
2. `config/db.php` にデータベース情報を設定
3. ブラウザで `http://localhost/roulette/public/index.php` にアクセス

---

## 🧪 機能

- ユーザーの追加・削除
- 表示対象の選択（チェックボックス）
- ルーレット抽選
- 結果表示
- データ保存（MySQL）

---

## 🛠 使用技術

- PHP 8.4.3
- JavaScript / jQuery
- [p5.js](https://p5js.org/)
- MySQL（または SQLite）
- Apache（XAMPP）