<?php
ini_set('display_errors', "On");
session_start();

require_once('../../Controller/GeneralUserController.php');
require_once('../../Controller/MessageRelationController.php');
require_once('../../function/functions.php');

if(!empty($_SESSION['login_user'])){
  $user_id = $_SESSION['login_user']['id'];
  $role = $_SESSION['login_user']['role'];
}else{
  $user_id = NULL;
  $role = 0;
}

$general_id = $_GET['id'];
$g_user = new GeneralUserController();
$result = $g_user->getUser($general_id);

//既存チェック
$message_relation = new MessageRelationController();
$check = $message_relation->ScoutCheck($user_id,$general_id);


$submit = $_POST;
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  
  //CSRF対策
  $token = filter_input(INPUT_POST,'csrf_token');
  //トークンがないもしくは一致しない時、処理を中止
  if(!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){
    exit('不正なリクエスト');
  }
  unset($_SESSION['csrf_token']);
  $general_id = filter_input(INPUT_POST,'g_id');
  $text = filter_input(INPUT_POST, 'text');

  if(empty($text)|| mb_ereg_match("^(\s|　)+$",$text)){
    $err = 'メッセージを入力してください。';
  }
  
  if(empty($err)){
    $_SESSION['general_id'] = $general_id;
    $_SESSION['text'] = $text;
    header('location: ../MessageRelation/complete.php');
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
  <link rel="stylesheet" type="text/css" href="../../public/css/base.css">
  <link rel="stylesheet" type="text/css" href="../../public/css/style.css">
  <title></title>
</head>
<body>
<?php include('..//Common/_header.php');?>
<main>
<?php if(!empty($err)):?>
  <h5 class="mt-2 text-center text-danger"><?=h($err)?></h5>
<?php endif;?>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">メッセージを送る</h5>
        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="" method="POST">
          <label for="text" class="sr-only my-1"></label>
          <textarea class="message-box form-control " id="text" type="text" name="text" placeholder="メッセージを入力してください" autofocus></textarea>
      </div>
       
      <div class="modal-footer d-flex justify-content-center ">
        <input type="hidden" name="csrf_token" value="<?= h(setToken())?>">
        <input type="hidden" name="g_id" value="<?=h($_GET['id'])?>">
        <button type="submit" class="col-6 btn btn-outline-info ">送　信</button>
      </form>
      </div>
    </div>
  </div>
</div>
<?php foreach($result  as $val):?>
  <div class="col-lg-8 col-md-10 mx-auto my-5">
    <div class="card ">
      <div class="card-body">
        <div class="card-title d-flex justify-content-between border-bottom py-1">
        <h2><?=h($val['family_name'])?>  <?=h($val['first_name'])?></h2>
        <h4 class="d-flex align-items-end"><?=h($val['prefecture'])?></h4>
        </div>
        <p class="card-text border round p-2"><?=nl2br(h($val['body']));?></p>
        <?php if($val['career']):?>
          <p class="card-text border round p-2"><?=nl2br(h($val['career']))?></p>
        <?php endif;?>
      </div>
      <?php if($check):?>
        <a href="../MessageRelation/messages.php" class="btn btn-outline-info mx-auto mb-2 col-3">メッセージを確認してください</a>
      <?php else:?>
        <button type="button" class="btn btn-outline-info mx-auto mb-2 col-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
          スカウト
        </button>
      <?php endif;?>
    </div>
  </div>
<?php endforeach;?>
</main>
<?php include('../Common/_footer.php');?>
</body>
</html>