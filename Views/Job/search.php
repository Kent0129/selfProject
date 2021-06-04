<?php
session_start();

// 直リンクを禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: ../Job/index.php');
  exit;
}

ini_set('display_errors', "On");

require_once('../../Controller/JobController.php');
require_once('../../function/functions.php');


if(!empty($_SESSION['login_user'])){
  $user_id = $_SESSION['login_user']['id'];
  $role = $_SESSION['login_user']['role'];
}else{
  $user_id = NULL;
  $role = 0;
}

$input = $_SESSION['search'];
//空白除去
$words = extractKeywords($input);
//検索ワードを配列から外す

$search['prefectures_id'] = $_SESSION['prefectures_id'];
$search['sector_id'] = $_SESSION['sector_id'];
$search['educational'] = $_SESSION['educational'];
$search['career'] = $_SESSION['career'];
$search['industry'] = $_SESSION['industry'];
$search['occupation'] = $_SESSION['occupation'];


$job = new JobController(); 
$result = $job->search($words,$search);

if(empty($result['job'])){
  $err = "条件にマッチするのものがありませんでした。";
  $result = $job->index();

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
  <title>Document</title>
</head>
<body>
<?php include('..//Common/_header.php');?>
  <main>
  <div class="err text-center text-danger">
  <?php if(!empty($err)):?>
    <h2><?=h($err)?></h2>
  <?php endif;?> 
</div>
<div class="col-11 mx-auto mt-4">
 

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
            <a href="show.php?id=<?php echo h($val['id'])?>" class="btn btn-outline-info col-6 stretched-link">詳  細</a>
          </div>
      </div>
    </div>
  <?php endforeach;?>

  
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

