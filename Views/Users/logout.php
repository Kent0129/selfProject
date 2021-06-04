<?php
// 直リンクを禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: ../Job/index.php');
  exit;
}

ini_set('display_errors', "On");
session_start();
require_once('../../Models/User.php');

if (!$logout = filter_input(INPUT_POST,'logout')){
  exit('不正なリクエストです。');
}

//ログインをしているか判定し、セッションが切れていたらログインしてくださいとメッセージを出す
$user = new User();
$result = $user->checkLogin();

if(!$result){
  exit('セッションが切れましたので、ログインし直してください。');
}

//ログアウトする
$user->logout();

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
  <title>ログアウト</title>
</head>
<body>
<?php include('..//Common/_header.php');?>
  <main>
    <div class="contact_box border rounded mt-5 mx-auto text-center">
      <h3 class="py-3">ログアウトしました。</h3>
      <a class="btn btn-outline-info my-3" href="login_form.php">ログイン画面へ</a>
    </div>
  </main>
<?php include('../Common/_footer.php');?>
</body>
</html>