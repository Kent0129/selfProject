<?php
ini_set('display_errors', "On");

// 直リンクを禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: ../Job/index.php');
  exit;
}

session_start();

require_once('../../function/functions.php');


$submit = $_POST;
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $content = filter_input(INPUT_POST, 'content');
  
  if(empty($content)){
    $err = "入力がされていません";
  }

  if(empty($err)){
    $_SESSION['content'] = $content;
    header('location: complete.php');
    exit();
  }
}

?>
<?php?>
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
  <h1 class="h3 mt-2 mb-3 pb-1 font-weight-normal text-center border-bottom">ルート作成</h1>
      <form class="w-100 mx-auto" action="" method="POST">
          <h3 class="text">自己分析を始めてみましょう</h3>
          <?php if(!empty($err)):?>
            <h5 class="text-danger"><?=h($err)?></h5>
          <?php endif;?>
        <label for="name" class="sr-only my-1"></label>
        <input class="form-control" id="content" type="text" name="content" placeholder="スキル、趣味、生活、仕事、好きなこと、性格などを1つ入れて下さい" required autofocus/>
        <div class="text-center">
            <input class="btn btn-outline-info my-2 col-6" type="submit" value="作　成"/>
        </div>
      </form>
  </div>
</body>
</html>