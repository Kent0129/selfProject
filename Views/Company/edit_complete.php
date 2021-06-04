<?php
ini_set('display_errors', "On");

// 直リンクを禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: ../Job/index.php');
  exit;
}

session_start();

require_once('../../Controller/CompanyController.php');
require_once('../../function/functions.php');//共通のファンクション

if(!empty($_SESSION['login_user'])){
  $user_id = $_SESSION['login_user']['id'];
  $role = $_SESSION['login_user']['role'];
}else{
  $user_id = NULL;
  $role = 0;
}


//POSTを格納
$params = [];
$params['id'] =$_SESSION['id'];
$params['name'] =$_SESSION['name'];
$params['prefectures_id'] =$_SESSION['prefectures_id'];
$params['location'] =$_SESSION['location'];
$params['body'] =$_SESSION['body'];

//コントローラーの作成
$company = new CompanyController();
//編集
$company->Update($user_id,$params);


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
  <title>会社情報編集完了</title>
</head>
<body>
<?php include('..//Common/_header.php');?>
  <main>
    <div class="contact_box border rounded mt-5 mx-auto text-center">
      <h3 class="py-3">会社情報の編集が完了しました。</h3>
      <a class="btn btn-outline-info my-3" href="mypage.php">マイページで確認する</a>
    </div>
  </main>
<?php include('../Common/_footer.php');?>
</body>
</html>