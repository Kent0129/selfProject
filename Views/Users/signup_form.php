<?php
ini_set('display_errors', "On");
session_start();
require_once('../../function/functions.php');
require_once('../../Models/User.php');
$user = new User();
$result = $user->checkLogin();

if($result){
  header('Location: ../Job/index.php');
  return;
}

$login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
unset($_SESSION['login_err']);
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
        <div class="collapse navbar-collapse flex-grow-0" id="navbarSupportedContent">
            <ul class="navbar-nav text-right mx-2">
              <li class="nav-item active">
                  <a class="nav-link" href="../Users/login_form.php">ログイン</a>
              </li>
            </ul>
        </div>
    </div>
</nav>
  <main>
<div class="sign-up-form mx-auto">
  <div class="text-center border rounded mt-5 p-3">
    <h1 class="h3 mt-2 mb-3 font-weight-normal">新規登録</h1>
    <?php if(isset($login_err)):?>
      <p><?php echo $login_err;?></p>
    <?php endif;?>
    <form class="w-100 mx-auto" action="register.php" method="POST">
          <label for="email" class="sr-only"></label>
          <input class="form-control" id="email" type="text" name="email" placeholder="email" required autofocus/>
          <label for="password" class="sr-only"></label>
          <input class="form-control" id="password" type="password" name="password" placeholder="パスワード" required/>
          <label for="password_conf" class="sr-only"></label>
          <input class="form-control" id="password_conf" type="password" name="password_conf" placeholder="パスワード確認" required/>
          <div class="from-radio mt-2">
            <input type="radio" name="role" value="1" checked="checked">求職者
            <input type="radio" name="role" value="2">求人者
          </div>
          <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
          <input class="btn btn-outline-primary my-2" type="submit" value="登録"/>
    </form>
    <p class="border-top mt-4 pt-2">登録済みの方はこちらから</p>
    <a href="login_form.php" class="btn btn-outline-primary">ログイン</a>
  </div>
</div>
</main>
<?php include('../Common/_footer.php');?>
</body>
</html>