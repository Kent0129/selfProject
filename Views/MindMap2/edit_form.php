<?php
ini_set('display_errors', "On");

// 直リンクを禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: ../Job/index.php');
  exit;
}

session_start();

require_once('../../Controller/MindMap2Controller.php');
require_once('../../function/functions.php');
$id = $_GET['id'];
$mind2 = new MindMap2Controller();
$result = $mind2->findById($id);


$submit = $_POST;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $id = filter_input(INPUT_POST, 'id');
  $mind1_id = filter_input(INPUT_POST, 'mind1_id');
  $content = filter_input(INPUT_POST, 'content');

  if(empty($content)){
    $err = "入力がされていません";
  }

  if(empty($err)){
    $_SESSION['id'] = $id;
    $_SESSION['mind1_id'] = $mind1_id;
    $_SESSION['content'] = $content;
    header('location: edit_complete.php');
    exit();
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="../../public/css/style.css">
  <title>Document</title>
</head>
<body>
<div class="mind-map-form w-50 mx-auto p-2 border rounded">
  <h1 class="h3 mt-2 mb-3 pb-1 font-weight-normal text-center border-bottom">ブランチ編集</h1>
      <form class="w-100 mx-auto" action="" method="POST">
        <?php foreach($result as $value):?>
        <input type="hidden" name="id" value="<?=h($value['id'])?>">
        <input type="hidden" name="mind1_id" value="<?=h($value['mind1_id'])?>">
        <h3 class="text"><?=h($value['m1content'])?></h3>
        <input class="form-control  my-5" id="content" type="text" name="content" value="<?=h($value['m2content'])?>" placeholder="<?=h($value['m2content'])?>" required autofocus/>
        <?php endforeach;?>
        <div class="text-center">
            <input class="btn btn-outline-info my-2 col-6" type="submit" value="編 集 完 了">
        </div>
      </form>
  </div>
</body>
</html>