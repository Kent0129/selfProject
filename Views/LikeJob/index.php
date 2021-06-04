<?php
//お気に入り一覧
ini_set('display_errors', "On");

// 直リンクを禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: ../Job/index.php');
  exit;
}

session_start();

require_once('../../Controller/LikeJobController.php');
require_once('../../function/functions.php');//共通のファンクション

if(!empty($_SESSION['login_user'])){
  $user_id = $_SESSION['login_user']['id'];
  $role = $_SESSION['login_user']['role'];
}else{
  $user_id = NULL;
  $role = 0;
}

//コントローラーの用意
$like = new LikeJobController();
//お気に入りを全て取得
$result = $like->getAll($_GET['id']);

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
  <title>会社情報作成完了</title>
</head>
<body>
<?php include('..//Common/_header.php');?>
<main>
<?php if(!empty($result)):?>
    <div class="messages mx-auto">
        <?php foreach($result as $value):?>
          <div class="message border  rounded  my-2 position-relative">
              <h5 class="pt-3 ps-3"><?=h($value['title'])?></h5>
              <p class="border rounded mx-2 p-2"><?=str100(h($value['body']));?></p>
              <a href="../Job/show.php?id=<?=h($value['id'])?>" class="stretched-link"></a>
          </div>
        <?php endforeach;?>
      </div>
      <?php else:?>
    <div class="contact_box border rounded mt-5 mx-auto text-center">
      <h3 class="py-3">お気に入りがまだありません</h3>
        <a href="../Job/index.php" class="btn btn-outline-info col-6 mx-auto my-4">気になる求人をお気に入りに追加してみましょう</a>
    </div>
<?php endif;?>
  </main>
<?php include('../Common/_footer.php');?>
</body>
</html>