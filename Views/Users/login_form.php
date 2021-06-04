<?php
ini_set('display_errors', "On");
session_start();
require_once('../../function/functions.php');//共通のファンクション
require_once('../../Models/User.php');
$user = new User();
$result = $user->checkLogin();

if($result){
  header('Location: ../Job/index.php');
  return;
}

$err = $_SESSION;

//セッションを消す
$_SESSION = array();
session_destroy();
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
  <title>ログイン画面</title>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-light navbar-light justify-content-end">
  <a class="navbar-brand mx-2" href="../Job/index.php">TOP PAGE</a>
  <div class="nav-right">
        <button class="navbar-toggler mx-2" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>
  <main>
<div class="login-form mx-auto">
  <div class="text-center mt-5 border rounded p-3">
    <h1 class="h3 mb-3 font-weight-normal">ログイン</h1>
    <?php if(isset($err['msg'])):?>
      <p><?php echo $err['msg'];?></p>
    <?php endif;?>
    <form class="w-100 mx-auto" action="login.php" method="POST">
      <label for="email" class="sr-only"></label>
      <input class="form-control" id="email" type="text" name="email" placeholder="email" required autofocus/>
      <?php if(isset($err['email'])):?>
        <p><?php echo $err['email'];?></p>
      <?php endif;?>
      <label for="password" class="sr-only"></label>
      <input class="form-control" id="password" type="password" name="password" placeholder="パスワード" required/>
      <?php if(isset($err['password'])):?>
        <p><?php echo $err['password'];?></p>
      <?php endif;?>
      <input type="hidden" name="csrf_token" value="<?= h(setToken())?>">
      <input class="btn btn-outline-primary my-2" type="submit" value="ログイン"/>
    </form>
    <p class="border-top mt-4 pt-2">新規登録はこちらから</p>
    <a href="signup_form.php" class="btn btn-outline-primary">新規登録</a>
  </div>
</div>
</main>
<?php include('../Common/_footer.php');?>
</body>
</html>