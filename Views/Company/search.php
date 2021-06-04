<?php
ini_set('display_errors', "On");

// 直リンクを禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: ../Job/index.php');
  exit;
}

session_start();

require_once('../../Controller/ReadController.php');
require_once('../../Controller/GeneralUserController.php');
require_once('../../function/functions.php');

if(!empty($_SESSION['login_user'])){
  $user_id = $_SESSION['login_user']['id'];
  $role = $_SESSION['login_user']['role'];
}else{
  $user_id = NULL;
  $role = 0;
}

$read =  new ReadController();
$prefectures = $read->getPrefectures();
$i = 1;

$input = $_SESSION['search'];
//空白除去
$words = extractKeywords($input);
$prefectures_id = $_SESSION['prefectures_id'];


//サーチページで検索が会った時
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  //以下バリデーション
  $search = filter_input(INPUT_POST,'search');
  $prefectures_id = filter_input(INPUT_POST,'prefectures_id');

  if(empty($search) && empty($prefectures_id)){
    $err ='検索したい内容を入力してください';
  }else{
    $input = $search;
  //空白除去
    $words = extractKeywords($input);
  }
} 

$g_user = new GeneralUserController(); 
$result = $g_user->search($words,$prefectures_id);


if(empty($result)){
  $err = "条件にマッチするのものがありませんでした。";
  $result = $g_user->getAll();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../../public/css/base.css">
    <link rel="stylesheet" type="text/css" href="../../public/css/style.css">
</head>
<body>
<?php include('..//Common/_header.php');?>
<main>
<div class="err text-center text-danger">
  <?php if(!empty($err)):?>
    <h2><?=h($err)?></h2>
  <?php endif;?> 
</div>
<div class="d-flex flex-row-reverse m-2">
<button type="button" class="btn btn-outline-info col-lg-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
  検索
</button>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ユーザー検索</h5>
        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="" method="POST">
          <label for="search" class="sr-only my-1"></label>
          <input class="form-control" id="search" type="text" name="search" placeholder="検索したいワードを入力してください" autofocus/>

        <label for="prefectures_id" class="sr-only my-1"></label>
       <select class="form-select" name="prefectures_id" aria-label="Default select example">
          <option selected value="">都道府県から探す</option>
          <?php foreach($prefectures as $prefecture):?>
            <option value="<?=$i?>"><?=$prefecture['prefecture']?></option>
          <?php $i++; endforeach;?>
        </select>
      </div>
      <div class="modal-footer d-flex justify-content-center ">
        <button type="submit" class="col-6 btn btn-outline-info ">検索</button>
      </form>
      </div>
    </div>
  </div>
</div>
<div class="col-11 mx-auto">
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
  <?php foreach($result['g_user'] as $val):?>
    <div class="">
      <div class="u-card card">
        <div class="card-body">
          <?php if(!empty($val['prefecture'])):?>
            <p class=""><?=$val['prefecture']?></p>
          <?php else:?>
            <p>　</p>
         <?php endif; ?>
          <h2 class="card-title border-top border-bottom py-2"><?=$val['family_name']?>  <?=$val['first_name']?></h2>
          <p class="introduction card-text"><?=str(n($val['body']))?></p>
          
        </div>
        <div class="text-center mb-3">
            <a href="../GeneralUser/show.php?id=<?php echo $val['id']?>" class="btn btn-outline-info col-6 stretched-link">詳細</a>
          </div>
      </div>
    </div>
  <?php endforeach;?>
</div>
  </div>
<?php 
for($i=0;$i<=$result['pages'];$i++){
  if(isset($_GET['page']) && $_GET['page'] == $i){
    echo $i+1;
  }else{
    echo "<a href='?page=".$i."'>".($i+1)."</a>";
  }
}
?>
</main>
<?php include('../Common/_footer.php');?>
</body>
</html>