<?php
ini_set('display_errors', "On");

// 直リンクを禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: ../Job/index.php');
  exit;
}

session_start();

require_once('../../Controller/MindMap2Controller.php');
require_once('../../function/functions.php');//共通のファンクション


//ユーザーIDの取得
$user_id = $_SESSION['login_user']['id'];
//POSTを格納
$params['mind1_id'] = $_SESSION['mind1_id'];
$params['content'] = $_SESSION['content'];
//コントローラーを起動
$mind2 = new MindMap2Controller();
//作成
$mind2->Create($user_id,$params);
$mind1_id = $_SESSION['mind1_id'];

unset($_SESSION['mind1_id']);
unset($_SESSION['content']);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="../../public/css/base.css">
  <link rel="stylesheet" type="text/css" href="../../public/css/style.css">
  <title>作成完了</title>
</head>
<body>
<?php include('..//Common/_header.php');?>
  <main>
    <div class="contact_box border rounded mt-5 mx-auto text-center">
      <h3 class="py-3">ブランチを作成しました。</h3>
      <a class="btn btn-outline-info my-2 col-3" href="../MindMap2/index.php?id=<?=h($mind1_id)?>">戻って確認する</a>
    </div>
  </main>
<?php include('../Common/_footer.php');?>
</body>
</html>