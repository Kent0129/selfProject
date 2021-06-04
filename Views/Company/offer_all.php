<?php
session_start();

// 直リンクを禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: ../Job/index.php');
  exit;
}

ini_set('display_errors', "On");

require_once('../../Controller/JobController.php');
require_once('../../function/functions.php');//共通のファンクション


if(!empty($_SESSION['login_user'])){
  $user_id = $_SESSION['login_user']['id'];
  $role = $_SESSION['login_user']['role'];
}else{
  $user_id = NULL;
  $role = 0;
}

$job = new JobController();
$result = $job->getOffer($user_id);
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
<?php if(!empty($result)):?>
<div class="col-11 mx-auto mt-2">
<div class="row row-cols-1 row-cols-md-2 g-4">
  <?php foreach($result['job'] as $val):?>
    <div class="col">
      <div class="j-card card">
        
        <div class="card-body">
          <p class=""><?=h($val['sector_text'])?></p>
          <h2 class="card-title border-top border-bottom py-2"><?=$val['title']?></h2>
          <p class="border-bottom pb-2">勤務地：<?=$val['prefecture']?><?=h($val['location'])?></p>
          <p class="card-text"><?=jstr(($val['body']))?></p>
        
        </div>
        <div class="text-center  mb-3">
            <a href="../Job/show.php?id=<?php echo h($val['id'])?>" class="btn btn-outline-info col-6 stretched-link">詳  細</a>
          </div>
      </div>
    </div>
  <?php endforeach;?>
<?php else:?>
  <div class="contact_box border rounded mt-5 mx-auto text-center">
      <h3 class="py-3">まだ求人がありません</h3>
      <a class="btn btn-outline-info my-3" href="../Job/job_create.php">求人を作成する</a>
  </div>
<?php endif;?>
</div>
<div class='paging text-center text-decoration-none'>
<?php 
for($i=0;$i<=$result['pages'];$i++){
  if(isset($_GET['page']) && $_GET['page'] == $i){
    echo $i+1;
  }else{
    echo "<a href='?page=".$i."'>".($i+1)."</a>";
  }
}
?>
</div>
</div>
</main>
<?php include('../Common/_footer.php');?>
</body>
</html>