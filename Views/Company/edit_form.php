<?php
ini_set('display_errors', "On");

// 直リンクを禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: ../Job/index.php');
  exit;
}

session_start();

require_once('../../Controller/CompanyController.php');
require_once('../../Controller/ReadController.php');
require_once('../../function/functions.php');

if(!empty($_SESSION['login_user'])){
  $user_id = $_SESSION['login_user']['id'];
  $role = $_SESSION['login_user']['role'];
}else{
  $user_id = NULL;
  $role = 0;
}

$company = new CompanyController();
$result = $company->FindById($user_id);

$read =  new ReadController();
$prefectures = $read->getPrefectures();
$i = 1;


$submit = $_POST;
$err =[];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  
   //CSRF対策
   $token = filter_input(INPUT_POST,'csrf_token');
   //トークンがないもしくは一致しない時、処理を中止
   if(!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){
     exit('不正なリクエスト');
   }
   unset($_SESSION['csrf_token']);
 

  $id = filter_input(INPUT_POST, 'id');
  $name = filter_input(INPUT_POST, 'name');
  $prefectures_id = filter_input(INPUT_POST,'prefectures_id');
  $location = filter_input(INPUT_POST, 'location');
  $body = filter_input(INPUT_POST, 'body');

  if(empty($name)|| mb_ereg_match("^(\s|　)+$",$name)){
    $err['name'] = '会社名を入力してください。';
  }  elseif(mb_strlen($name) > 50){
    $err['body'] = '会社名は50文字以内にしてください。';
  }
  if(empty($prefectures_id) && !is_numeric($prefectures_id)){
    $err['prefectures_id'] = '都道府県を選択してください。';
  }
  if(empty($location) || mb_ereg_match("^(\s|　)+$",$location)){
    $err['location'] = '会社所在地を入力してください。';
  }
  if(empty($body) || mb_ereg_match("^(\s|　)+$",$body)){
    $err['body'] = '会社情報を入力してください。';
  }elseif(mb_strlen($body) > 2000){
    $err['body'] = '会社情報は2000文字以内にしてください。';
  }
  
  if(empty($err)){
    $_SESSION['id'] = $id;
    $_SESSION['name'] = $name;
    $_SESSION['prefectures_id'] = $prefectures_id;
    $_SESSION['location'] = $location;
    $_SESSION['body'] = $body;
    header('location:edit_complete.php');
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
  <title>作成完了</title>
</head>
<body>
<?php include('..//Common/_header.php');?>
<main>
<div class="col-lg-8 col-md-10  mt-5 mx-auto p-2 border rounded">
  <h1 class="h3 mt-2 mb-3 pb-1 font-weight-normal text-center border-bottom">会社情報編集</h1>
      <form class="w-100 mx-auto" action="" method="POST">
        <?php foreach ($result as $value):?>
          <label for="name" class="sr-only my-1"><h5>会社名:</h5></label>
          <h5 class="text-danger"><?php if(!empty($err['name'])){echo "・".$err['name'];}?></h5>
          <input class="form-control" id="name" type="text" name="name" 
          value="<?php if(!empty($submit['name'])){echo h($submit['name']);}else{echo h($value['name']);}?>" placeholder="株式会社〇〇" required autofocus/>
          <div class="row">
            <label for="prefectures" class="sr-only my-2"><h5>所在地:</h5></label>
              <h5 class="text-danger"><?php if(!empty($err['prefectures_id'])){echo "・".$err['prefectures_id'];}?></h5>
              <h5 class="text-danger"><?php if(!empty($err['location'])){echo "・".$err['location'];}?></h5>
            <div class="col-3">
              <select class="form-select" name="prefectures_id" aria-label="Default select example" required>
                <option value="">--</option>
                <?php foreach($prefectures as $prefecture):?>
                  <?php if(!empty($submit['prefectures_id']) && $submit['prefectures_id'] == $i ):?>
                      <option selected value="<?=$i?>"><?=h($prefecture['prefecture'])?></option>
                  <?php elseif($i == $value['prefectures_id']):?>
                    <option selected value="<?=$i?>"><?=$prefecture['prefecture']?></option>
                  <?php else:?>
                    <option value="<?=$i?>"><?=$prefecture['prefecture']?></option>
                    <?php endif;?>
                <?php $i++; endforeach;?>
              </select>
            </div>
            <div class="col">
              <input class="form-control"  type="text" name="location" id="location" 
              value="<?php if(!empty($submit['location'])){echo h($submit['location']);}else{echo h($value['location']);}?>"  placeholder="渋谷区渋谷○丁目○-○" value="" required autofocus/>
            </div>
          </div>
          <label for="body" class="sr-only my-2"><h5>会社情報:</h5></label>
          <h5 class="text-danger"><?php if(!empty($err['body'])){echo "・".$err['body'];}?></h5>
          <textarea class="body-form form-control" rows="3" name="body" id="body" value="" placeholder="2000文字まで入力できます。" required><?php if(!empty($submit['body'])){echo h($submit['body']);}else{echo h($value['body']);}?></textarea>
        <?php endforeach;?>
        <div class="text-center">
            <input type="hidden" name="id" value="<?=h($value['id'])?>">
            <input type="hidden" name="csrf_token" value="<?= h(setToken())?>">
            <input class="btn btn-outline-primary my-2 col-6" type="submit" value="更　新"/>
        </div>
      </form>
  </div>
</main>
<?php include('../Common/_footer.php');?>
</body>
</html>