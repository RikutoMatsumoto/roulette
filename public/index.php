<?php
// index.php

// UserModel.php を読み込み
// - DB接続やユーザー情報取得のメソッドが定義されている
// require_once 'UserModel.php';
require_once __DIR__ . '/../app/models/UserModel.php';

// UserModelクラスのインスタンスを生成
$userModel = new UserModel();

// ルーレットに表示する名前
$names = $userModel->getAnnouncerUsers();

// 全ユーザー一覧を取得
$allUsers = $userModel->getAllUsers();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>ルーレット</title>
    <link rel="stylesheet" href="/roulette/roulette/public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>WEBルーレット</h1>

        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous">
        </script>
            <script src="/roulette/roulette/public/js/p5.min.js"></script>
            <script src="/roulette/roulette/public/js/app.js"></script>
        <style>
        .p5Canvas{
            max-width: 800px;
            /* width: 100% !important; */
            width: auto !important;
            height: auto !important;
            display: block;       
            margin: 0 auto;
            margin-bottom: 20px;
        }
        </style>
        <div id="canvas"></div>
        <div class="button-row">

            <!-- リセットボタン（左に寄せたい） -->
            <button type="button" id="reset" onclick="reset()">リセット</button>

            <!-- 中央寄せしたいボタン群をまとめる -->
            <div class="center-buttons">
                <button type="button" id="start" onclick="start()">スタート！</button>
                <button type="button" id="stop" onclick="stop()" style="display:none;">ストップ！</button>
            </div>

        </div>
        <h2>結果</h2>
        <p id="result">????</p>

        <div>
            <h2>ルーレット設定</h2>
            <div>
                <h3>項目名と割合</h3>
                <table id="table">
                    <tr><th>色</th><th>項目名</th><th>割合</th><th>確率</th></tr>
                    <?php foreach ($names as $name): ?>
                    <tr class="item">
                        <!-- 色の目印 (デフォルトは黒) -->
                        <td><div class="color-indicator" style="background-color:#000000;"></div></td>
                        <!-- ユーザー名を表示（編集用の入力ボックスになっている） -->
                        <td><input type="text" class="name" value="<?= $name['name'] ?>"></td>
                        <!-- 割合を入力する欄（初期値1） -->
                        <td><input type="number" class="ratio" value="1"></td>
                        <!-- 計算後の確率を表示するセル -->
                        <td class="probability"></td>
                    </tr>
                <?php endforeach; ?>
                </table>
            </div>
        </div>
        <style>
        .color-indicator{
            width: 10px;
            height: 10px;
        }

        #result{
            font-size: 40px;
            font-weight: bold;
        }
        </style>

        <!-- チェックボックス一覧 -->
        <div>
            <h3>表示する名前を選択</h3>
            <table>
                <tr><th>名前</th><th>表示</th><th>削除</th></tr>
                <?php foreach ($allUsers as $user): ?>
                    <tr>
                        <td><?= $user['name'] ?></td>
                        <td>
                            <input type="checkbox" class="toggle-announcer" data-id="<?= $user['id'] ?>" <?= $user['announcer'] ? 'checked' : '' ?>>
                        </td>
                        <td>
                            <form action="/roulette/roulette/app/controllers/delete_user.php" method="POST" onsubmit="return confirm('本当に削除しますか？');" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                <button type="submit">削除</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>


        <div>
            <h3>新しい名前を追加</h3>
            <form action="/roulette/roulette/app/controllers/add_user.php" method="POST">
                <label for="new_name">名前：</label>
                <input type="text" id="new_name" name="new_name" required>
                <button type="submit">追加</button>
            </form>
        </div>

        <script>
            //確率を自動計算
            function recalculate(){
                var ratioSumJs = 0;
                $('.ratio').each(function(){
                    ratioSumJs += $(this).val()-0;
                });
                $(".item").each(function(){
                    var probability = ($(this).find(".ratio").first().val()-0) / ratioSumJs;
                    probability*=100;
                    probability = probability.toFixed(3);
                    $(this).children(".probability").first().html(probability+"%");
                });
            }

            //変更を検知 確率計算(再計算)
            $('#table').on('change', '.ratio', function(){
                recalculate();
                if(mode==Mode.waiting){
                    dataFetch();
                }
            });

            //riku追加
            $(document).ready(function() {
                $(".toggle-announcer").change(function() {
                    var userId = $(this).data("id");
                    var isChecked = $(this).is(":checked") ? 1 : 0;

                    $.ajax({
                        url: "/roulette/roulette/app/controllers/update_announcer.php",
                        type: "POST",
                        data: { id: userId, announcer: isChecked },
                        success: function(response) {
                            location.reload(); // 更新後にページをリロード
                        },
                        error: function() {
                            alert("更新に失敗しました");
                        }
                    });
                });
            });
        </script>
    </div>
</body>
</html>