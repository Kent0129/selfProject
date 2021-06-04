<?php
ini_set('display_errors', "On");

// 直リンクを禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: ../Job/index.php');
  exit;
}

session_start();

require_once('../../Controller/GeneralUserController.php');
require_once('../../Controller/ReadController.php');
require_once('../../function/functions.php');
$g_user = new GeneralUserController();

if(!empty($_SESSION['login_user'])){
  $user_id = $_SESSION['login_user']['id'];
  $role = $_SESSION['login_user']['role'];
}else{
  $user_id = NULL;
  $role = 0;
}

$result = $g_user->findById($user_id);


$read =  new ReadController();
$prefectures = $read->getPrefectures();
$i = 1;

$submit = $_POST;
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  
  //CSRF対策
  $token = filter_input(INPUT_POST,'csrf_token');
  //トークンがないもしくは一致しない時、処理を中止
  if(!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){
    exit('不正なリクエスト');
  }
  unset($_SESSION['csrf_token']);

  $err =[];
  $prefectures_id = filter_input(INPUT_POST,'prefectures_id');
  $family_name = filter_input(INPUT_POST, 'family_name');
  $first_name = filter_input(INPUT_POST, 'first_name');
  $body = filter_input(INPUT_POST, 'body');
  $career = filter_input(INPUT_POST, 'career');


  if(empty($family_name)){
    $err['family_name'] = '苗字を入力してください。';
  }elseif(mb_strlen($family_name) > 30){
    $err['family_name'] = '苗字は30文字以内にしてください。';
  }
  if(empty($first_name)){
    $err['first_name'] = '名前を入力してください。';
  }elseif(mb_strlen($first_name) > 30){
    $err['first_name'] = '名前は30文字以内にしてください。';
  }
  if(empty($body)){
    $err['body'] = '自己紹介を入力してください。';
  }elseif(mb_strlen($body > 1000)){
    $err['body'] = '自己紹介は1000文字以内にしてください。';
  }
  
  if(empty($err)){
    $_SESSION['family_name'] = $family_name;
    $_SESSION['first_name'] = $first_name;
    $_SESSION['prefectures_id'] = $prefectures_id;
    $_SESSION['body'] = $body;
    $_SESSION['career'] = $career;
    header('location: complete.php');
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
<?php if(empty($result)):?>
<div class="col-lg-8 col-md-10 mt-5 mx-auto p-2 border rounded">
  <h1 class="h3 mt-2 mb-3 pb-1 font-weight-normal text-center border-bottom">プロフィール作成</h1>
      <form class="w-100 mx-auto" action="" method="POST">
        <div class="row">  
          
          <div class="col">
          <label for="family_name" class="h5 sr-only my-1">苗字*:</label>
            <input class="form-control" id="family_name" type="text" name="family_name" 
            value="<?php if(!empty($submit['family_name']))
                {echo h($submit['family_name']);}?>"placeholder="山田"required autofocus/>
          </div>
          <div class="col">
          <label for="first_name" class="h5 sr-only my-1">名前*:</label>
            <input class="form-control" id="first_name" type="text" name="first_name" 
            value="<?php if(!empty($submit['first_name']))
                {echo h($submit['first_name']);}?>" placeholder="太郎">
          </div>
          <div class="col">
            <label for="family_name" class="h5 sr-only my-1">居住地(任意):</label>
          <select class="form-select" name="prefectures_id" aria-label="Default select example">
              <option value="">--</option>
              <?php foreach($prefectures as $prefecture):?>
                <?php if(!empty($submit['prefectures_id']) && $submit['prefectures_id'] == $i ):?>
                      <option selected value="<?=$i?>"><?=h($prefecture['prefecture'])?></option>
                <?php endif;?>
                <option value="<?=$i?>"><?=$prefecture['prefecture']?></option>
              <?php $i++; endforeach;?>
            </select>
          </div>
        </div>
        <h5 class="text-danger"><?php if(!empty($err['family_name'])){echo "・".$err['family_name'];}?></h5>
        <h5 class="text-danger"><?php if(!empty($err['first_name'])){echo "・".$err['first_name'];}?></h5>

           <label for="body" class="h5 sr-only my-2">自己紹介*:</label>
           <h5 class="text-danger"><?php if(!empty($err['body'])){echo "・".$err['body'];}?></h5>
           <textarea class="body-form form-control" rows="3" name="body" id="body" value="" placeholder="1000文字まで入力できます。"><?php if(!empty($submit['body'])){echo h($submit['body']);}?></textarea>
           <label for="career" class="h5 sr-only my-2">経歴(任意):</label>
            <textarea class="career-form form-control" rows="3" name="career" id="career" value="" placeholder="2019年3月　〇〇大学〇〇学部　卒業"><?php if(!empty($submit['career'])){echo h($submit['career']);}?></textarea>
           <div class="text-center">
            <input type="hidden" name="csrf_token" value="<?= h(setToken())?>">
            <input class="btn btn-outline-primary my-3 col-6" type="submit" value="作　成">
           </div>
      </form>
  </div>
<?php else:?>

<?php foreach($result  as $val):?>
  <div class="col-lg-8 col-md-10 mx-auto">
    <div class="d-flex flex-row-reverse my-2">
      <a href="../MindMap/index.php?id=<?=h($user_id)?>" class="btn btn-outline-info col-sm-2">マインドマップ</a> 
    </div>
    <div class="card ">
      <div class="d-flex flex-row-reverse m-2">
        <a href="edit_profile.php?id=<?=h($user_id)?>" class="btn bg-info col-sm-2 text-light">編　集</a>
      </div>
      <div class="card-body">
        <div class="card-title d-flex justify-content-between border-bottom py-1">
        <h2><?=h($val['family_name'])?>  <?=h($val['first_name'])?></h2>
        <h4 class="d-flex align-items-end"><?=h($val['prefecture'])?></h4>
        </div>
        <p class="card-text border round p-2"><?=n(h($val['body']));?></p>
        <?php if($val['career']):?>
          <p class="card-text border round p-2"><?=n(h($val['career']))?></p>
        <?php endif;?>
      </div>
    </div>
  </div>
<?php endforeach;?>
<?php endif;?>
</main>
<?php include('../Common/_footer.php');?>
</body>
</html>