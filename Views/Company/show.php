<?php
ini_set('display_errors', "On");
session_start();

require_once('../../Controller/CompanyController.php');
require_once('../../Controller/ReadController.php');
require_once('../../Controller/ReadController.php');
require_once('../../function/functions.php');//共通のファンクション

if(!empty($_SESSION['login_user'])){
  $user_id = $_SESSION['login_user']['id'];
  $role = $_SESSION['login_user']['role'];
}else{
  $user_id = NULL;
  $role = 0;
}

$id = $_GET['id'];
$company= new CompanyController();
//会社情報を取得
$result = $company->getUser($id);

//読み込み用コントローラを起動
$read =  new ReadController();
//都道府県を取得
$prefectures = $read->getPrefectures();
$i = 1;

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
  <title>会社情報</title>
</head>
<body>
<?php include('..//Common/_header.php');?>
<main>
   <?php foreach($result  as $val):?>
      <div class="col-lg-8 col-md-10 mx-auto">
        <div class="d-flex flex-row-reverse my-2">
          <a href="offer_show.php?id=<?=h($val['id'])?>" class="btn btn-outline-info col-sm-2">求人一覧</a>
        </div>
        <div class="card ">
          <div class="card-body">
            <h2 class="card-title border-bottom py-2"><?=h($val['name'])?></h2>
            <p class="border-bottom p-2">
            <?php foreach($prefectures as $prefecture):?>
              <?php if($val['prefectures_id'] == $prefecture['id']):?>
                <span><?=h($prefecture['prefecture'])?>
              <?php endif;?>
              <?php endforeach;?>
              <?=h($val['location'])?></span>
            <p class="card-text border round p-2"><?=n(h($val['body']));?></p>
          </div>
        </div>
      </div>
    <?php endforeach;?>

</main>
<?php include('../Common/_footer.php');?>
</body>
</html>