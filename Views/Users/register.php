<?php
ini_set('display_errors', "On");
// 直リンクを禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: ../Player/index.php');
  exit;
}
var_dump($_POST);

session_start();

require_once('../../Models/User.php');
  //エラーメッセージ
  $err = [];

  $token = filter_input(INPUT_POST, 'csrf_token');
  //トークンがない、もしくは一致しない場合処理を中止
  if(!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){
    exit('不正なリクエスト');
  }

  unset($_SESSION['csrf_token']);
  
  //バリデーション
  if(!$email = filter_input(INPUT_POST,'email')){
    $err[] = 'メールアドレスを入力してください。';
  }
  $password = filter_input(INPUT_POST,'password');

  if(!preg_match("/\A[a-z\d]{8,32}+\z/i",$password)){
    $err[] = "パスワードは英数字で8文字以上32文字以内で入力してください。";
  }
  $password_conf = filter_input(INPUT_POST,'password_conf');
  if($password !== $password_conf){
    $err[] = "確認用パスワードと異なっています。";
  }
  $role = filter_input(INPUT_POST,'role');
  if(empty($role)){
    $err[] = "求職者か求人募集者のどちらかを選択して下さい";
  }

  if(count($err) === 0){
    //ユーザー登録処理
    $user = new User;
    $hasCreated = $user->createUser($email, $password,$role);

    if(!$hasCreated){
      $err[] = '登録に失敗しました';
    }
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
  <title>ユーザー登録完了画面</title>
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
      <?php if(count($err) > 0) : ?>
        <?php foreach($err as $e): ?>
            <p><?php echo $e ?></p>
        <?php endforeach ?>
      <?php else: ?>
          <h3 class="py-3">ユーザーの新規登録が</br>完了しました！</h3>
      <?php endif ?>
      <a class="btn btn-outline-info my-3" href="login_form.php">ログインページへ</a>
    </div>
  </main>
<?php include('../Common/_footer.php');?>
</body>
</html>