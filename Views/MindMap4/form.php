<?php
ini_set('display_errors', "On");

// 直リンクを禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: ../Job/index.php');
  exit;
}

session_start();

require_once('../../Controller/MindMap3Controller.php');
require_once('../../function/functions.php');
$id = $_GET['id'];

$mind3 = new MindMap3Controller();
$result = $mind3->findById($id);



if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $mind1_id = filter_input(INPUT_POST, 'mind1_id');
  $mind2_id = filter_input(INPUT_POST, 'mind2_id');
  $mind3_id = filter_input(INPUT_POST, 'mind3_id');
  $content = filter_input(INPUT_POST, 'content');

  if(empty($content)){
    $err = "入力がされていません";
  }

  if(empty($err)){
    $_SESSION['mind1_id'] = $mind1_id;
    $_SESSION['mind2_id'] = $mind2_id;
    $_SESSION['mind3_id'] = $mind3_id;
    $_SESSION['content'] = $content;
    header('location: complete.php');
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
  <h1 class="h3 mt-2 mb-3 pb-1 font-weight-normal text-center border-bottom">ブランチ作成</h1>

      <form class="w-100 mx-auto" action="" method="POST">
        <?php foreach($result as $value):?>
          <h3><?=h($value['m3content'])?></h3>
          <input type="hidden" name="mind1_id" value="<?=h($value['mind1_id'])?>">
          <input type="hidden" name="mind2_id" value="<?=h($value['mind2_id'])?>">
          <input type="hidden" name="mind3_id" value="<?=h($value['id'])?>">
          <input class="form-control  my-5" id="content" type="text" name="content"  placeholder="連想されるキーワードを入力してください" required autofocus/>
        <?php endforeach;?>
        <div class="text-center">
            <button class="btn btn-outline-info my-2 col-6" type="submit" >作　成</button>
        </div>
      </form>
  </div>
</body>
</html>
