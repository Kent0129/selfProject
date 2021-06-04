<?php
ini_set('display_errors', "On");
// 直リンクを禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: ../Job/index.php');
  exit;
}

session_start();
require_once('../../Models/User.php');

  //エラーメッセージ
  $err = [];

  //バリデーション
  if(!$email = filter_input(INPUT_POST,'email')){
    $err['email'] = 'メールアドレスを入力してください。';
  }
  if(!$password = filter_input(INPUT_POST,'password')){
    $err['password'] = 'パスワードを入力してください。';
  }
  if(count($err) > 0){
    //エラーがあった場合は戻す
    $_SESSION = $err;
    header('Location: login_form.php');
    return;
  }
  //ログイン成功時の処理
  $user = new User();
  $result = $user->login($email,$password);
  
  //ログイン失敗時の処理
  if(!$result){
    header('Location: login_form.php');
    return;
  }
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
  <title>ログイン完了</title>
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
    <div class="contact_box border rounded mt-5 mx-auto text-center">
      <h3 class="py-3">ログインが完了しました。</h3>
        <a class="btn btn-info my-3" href="../Job/index.php">トップページへ</a>
    </div>
  </main>
<?php include('../Common/_footer.php');?>
</body>
</html>