<?php
ini_set('display_errors', "On");

// 直リンクを禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: ../Job/index.php');
  exit;
}

session_start();

require_once('../../Controller/MindMap1Controller.php');
require_once('../../Controller/MindMap2Controller.php');
require_once('../../Controller/MindMap3Controller.php');
require_once('../../Controller/MindMap4Controller.php');
require_once('../../function/functions.php');

$login_user = $_SESSION['login_user'];
$user_id = $login_user['id'];

$mind1 = new MindMap1Controller();
$result = $mind1->getMatch($user_id);

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
  <title>Document</title>
</head>
<body>
<?php include('..//Common/_header.php');?>
<main>
<div class="container mx-auto col-lg-4 mt-3 text-center">
  <h1 class="text-center">あなたについて</h1>
  
  <?php foreach($result as $column):?>
  <div class="card my-1">
    <div class="card-body">
      <div class="dropdown d-flex flex-row-reverse">
        <a class="btn btn-outline-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"></a>
        <ul class="dropdown-menu text-right" aria-labelledby="dropdownMenuLink">
          <li><a class="dropdown-item" href="../MindMap2/form.php?id=<?=h($column['id']);?>"> 作成</a></li>
          <li><a class="dropdown-item" href="edit_form.php?id=<?=h($column['id'])?>">編集</a></li>
          <li><a class="dropdown-item" href="delete.php?id=<?=h($column['id'])?>" onclick="return confirm('繋がっているブランチも削除されます。削除しますか？')">削除</a></a></li>
        </ul>
      </div>
        <h2 class="card-title"><?=h($column['content'])?></h2>
        <a href="../MindMap2/index.php?id=<?=h($column['id'])?>" class="btn btn-outline-info">ブランチへ</a>
      </div>
    </div>
  <?php endforeach;?>
    <a class="btn btn-outline-info my-3 col-4" href="form.php">ルートを作成する</a>


  
</div>

</main>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<?php include('../Common/_footer.php');?>
</body>
</html>