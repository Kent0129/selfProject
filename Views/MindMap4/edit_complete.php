<?php
ini_set('display_errors', "On");

// 直リンクを禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: ../Job/index.php');
  exit;
}

session_start();

require_once('../../Controller/MindMap4Controller.php');
require_once('../../function/functions.php');//共通のファンクション

//ユーザーIDの取得
$user_id = $_SESSION['login_user']['id'];
//POSTを格納
$params['id'] = $_SESSION['id'];
$params['content'] = $_SESSION['content'];
//コントローラーを起動
$mind4 = new MindMap4Controller();
//更新
$mind4->Update($params);

$mind3_id = $_SESSION['mind3_id'];

unset($_SESSION['id']);
unset($_SESSION['mind3_id']);
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
  <title>編集完了</title>
</head>
<body>
<?php include('..//Common/_header.php');?>
  <main>
    <div class="contact_box border rounded mt-5 mx-auto text-center">
      <h3 class="py-3">編集が完了しました。</h3>
      <a class="btn btn-outline-info my-2 col-3" href="index.php?id=<?=h($mind3_id)?>">戻る</a>
    </div>
  </main>
<?php include('../Common/_footer.php');?>
</body>
</html>