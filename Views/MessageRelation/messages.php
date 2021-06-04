<?php
  ini_set('display_errors', "On");

  // 直リンクを禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: ../Job/index.php');
  exit;
}

  session_start();
  
  require_once('../../Controller/MessageRelationController.php');
  require_once('../../Controller/MessageController.php');
  require_once('../../function/functions.php');

  $login_user = $_SESSION['login_user'];
  $user_id = $login_user['id'];
  $role = $login_user['role'];

  $message_relation = new MessageRelationController();

  $message = new MessageController();
  //roleで
  if($role == 1){
    $result = $message_relation->getName($user_id);
  }else if($role == 2){
    $result = $message_relation->getMessageRelationCompany($user_id);
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
  <title>会社情報作成完了</title>
</head>
<body>
<?php include('..//Common/_header.php');?>
  <main>
<?php if(!empty($result)):?>
  <div class="messages mx-auto">
    <?php foreach($result as $value):
        $mr_id = $value['id'];
        $latest = $message->getLatestMessage($mr_id);?>

      <div class="message border rounded my-2 position-relative">
        <?php if($role == 1):?>
        <h5 class="m-2 px-2 pt-2"><?=$value['name']?></h5>
        <?php elseif($role == 2):?>
          <h5 class="m-2 px-2 pt-2"><?=$value['family_name']?>　<?=$value['first_name']?></h5>
        <?php endif;?>
        <?php foreach($latest as $text):?>
          <p class="border rounded mb-2 mx-2 p-2"><?=str100(h($text['text']))?></p>
          <a href="../Message/message.php?id=<?=$value['id']?>" class="stretched-link"></a>
        <?php endforeach;?>
      </div>
    <?php endforeach;?>
  </div>
  <?php else:?>
    <div class="contact_box border rounded mt-5 mx-auto text-center">
      <h3 class="py-3">メッセージがまだありません</h3>
      <?php if($role == 1):?>
        <a href="../Job/index.php" class="btn btn-outline-info col-6 mx-auto my-4">求人に応募してみましょう</a>
      <?php elseif($role == 2):?>
        <a href="../Company/index.php" class="btn btn-outline-info col-6 mx-auto my-4">スカウトしてみましょう</a>
    </div>
  <?php endif;?>
<?php endif;?>
</main>
<?php include('../Common/_footer.php');?>

</body>
</html>