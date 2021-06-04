<?php
ini_set('display_errors', "On");

// 直リンクを禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: ../Job/index.php');
  exit;
}

session_start();

require_once('../../Controller/MessageController.php');
require_once('../../function/functions.php');//共通のファンクション

$login_user = $_SESSION['login_user'];
$user_id = $login_user['id'];
$role = $login_user['role'];
$message_relation_id = $_GET['id'];

//コントローラーの用意
$message = new MessageController();
//メッセージを全て取得
$result = $message->MessageAll($message_relation_id);


$submit = $_POST;
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $text = filter_input(INPUT_POST, 'text');
  $message_relation_id = filter_input(INPUT_POST, 'message_relation_id');
  
  if(empty($text)){
    $err = "メッセージが入力されていません";
  }

  if(empty($err)){
    $_SESSION['text'] = $text;
    $_SESSION['message_relation_id'] = $message_relation_id;
    header('location: complete.php');
    exit();
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
  <link rel="stylesheet" type="text/css" href="../../public/css/style.css">
  <link rel="stylesheet" type="text/css" href="../../public/css/base.css">
  <title>会社情報作成完了</title>
</head>
<body>
<?php include('..//Common/_header.php');?>
<main>
<div class="messages border mx-auto mt-3 rounded ">
  <?php foreach($result as $key=>$val):?>
    <?php if($user_id == $val['user_id']):?>
      <div class="d-flex flex-row-reverse m-2">
        <div class="p border rounded col-6 ">
          <?php if($role == 1):?>
            <h5 class="ps-3 pt-3"><a href="../GeneralUser/show.php?id=<?=h($val['general_id'])?>" class="text-secondary text-decoration-none"><?=h($val['family_name'])?><?=h($val['first_name'])?></a></h5>
            <p class="border rounded mb-2 me-2 ms-2 p-2"><?=n(h($val['text']))?></p>
          <?php elseif($role == 2):?>
              <h5 class="ps-3 pt-3"><a href="../Company/show.php?id=<?=h($val['company_id'])?>"class="text-secondary text-decoration-none"><?=h($val['name'])?></a></h5>
              <p class="border rounded mb-2 me-2 ms-2 p-2"><?=n(h($val['text']))?></p>
          <?php endif;?>
        </div>  
      </div>
    <?php elseif($user_id !== $val['user_id']):?>
      <div class="d-flex flex-row  m-2">
        <div class="p border col-6 m-2">
          <?php if($role == 1):?>
            <h5 class="ps-3 pt-3"><a href="../Company/show.php?id=<?=h($val['company_id'])?>"class="text-secondary text-decoration-none"><?=h($val['name'])?></a></h5>
            <p class="border rounded mb-2 me-2 ms-2 p-2"><?=n(h($val['text']))?></p>
          <?php elseif($role == 2):?>
            <h5 class="ps-3 pt-3"><a href="../GeneralUser/show.php?id=<?=h($val['general_id'])?>" class="text-secondary text-decoration-none"><?=h($val['family_name'])?><?=h($val['first_name'])?></a></h5>
            <p class="border rounded mb-2 me-2 ms-2 p-2"><?=n(h($val['text']))?></p>
          <?php endif;?>
        </div>
      </div>
    <?php endif;?>
  <?php endforeach;?>

  <div>
  <?php if(!empty($err)):?>
    <h5 class="text-center text-danger"><?=h($err)?></h5>
  <?php endif;?>
    <form  class="text-center m-3" action="" method="POST" >
      <input type="hidden" name="message_relation_id" value="<?=$message_relation_id?>">
      <div class="col-11 mx-auto mb-2">
        <textarea id="message-box" class="form-control" name="text"></textarea>
      </div>
      <input class="btn bg-info col-6" type="submit" value="送  信">
    </form>
  </div>
</div>
</main>
<?php include('../Common/_footer.php');?>
</body>
</html>