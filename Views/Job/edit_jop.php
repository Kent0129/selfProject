<?php
ini_set('display_errors', "On");

// 直リンクを禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: ../Job/index.php');
  exit;
}

session_start();

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
$company = $job->findById($_GET['id']);


require_once('../../Controller/ReadController.php');
$read =  new ReadController();
$prefectures = $read->getPrefectures();
$i = 1;
$sector = $read ->getSector();
$j = 1;


$submit = $_POST;
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  
  //CSRF対策
  $token = filter_input(INPUT_POST,'csrf_token');
  //トークンがないもしくは一致しない時、処理を中止
  if(!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){
    exit('不正なリクエスト');
  }
  unset($_SESSION['csrf_token']);
  $validateErrors =[];
  $id = filter_input(INPUT_POST, 'id');
  $company_id = filter_input(INPUT_POST, 'company_id');
  $sector_id = filter_input(INPUT_POST, 'sector_id');
  $prefectures_id = filter_input(INPUT_POST,'prefectures_id');
  $location = filter_input(INPUT_POST, 'location');
  $title = filter_input(INPUT_POST, 'title');
  $body = filter_input(INPUT_POST, 'body');
  $educational = filter_input(INPUT_POST, 'educational');
  $career = filter_input(INPUT_POST, 'career');
  $industry = filter_input(INPUT_POST, 'industry');
  $occupation = filter_input(INPUT_POST, 'occupation');

  if(empty($sector_id)){
    $validateErrors['sector_id'] = '業種を選択してください。';
  }
  if(empty($prefectures_id)){
    $validateErrors['prefectures_id'] = '都道府県を選択してください。';
  }
  if(empty($location)|| mb_ereg_match("^(\s|　)+$",$location)){
    $validateErrors['location'] = '勤務地を入力してください。';
  }elseif(mb_strlen($location) > 30){
    $validateErrors['location'] = '勤務地は30文字以内にしてください。';
  }
  if(empty($title)|| mb_ereg_match("^(\s|　)+$",$title)){
    $validateErrors['title'] = '見出しを入力してください。';
  }elseif(mb_strlen($title) > 50){
    $validateErrors['title'] = '見出しは50文字以内にしてください。';
  }
  if(empty($body)|| mb_ereg_match("^(\s|　)+$",$body)){
    $validateErrors['body'] = '求人内容を入力してください。';
  }elseif(mb_strlen($title) > 2000){
    $validateErrors['body'] = '求人内容は2000文字以内にしてください。';
  }
  if(empty($_POST['educational'])){
    $educational = 0;
  }
  if(empty($_POST['career'])){
    $career = 0;
  }

  if(empty($_POST['industry'])){
    $industry = 0;
  }
  if(empty($_POST['occupation'])){
    $occupation = 0;
  }
  if(empty($validateErrors)){
    $_SESSION['id'] = $id;
    $_SESSION['company_id'] = $company_id;
    $_SESSION['title'] = $title;
    $_SESSION['sector_id'] = $sector_id;
    $_SESSION['prefectures_id'] = $prefectures_id;
    $_SESSION['location'] = $location;
    $_SESSION['educational'] = $educational;
    $_SESSION['career'] = $career;
    $_SESSION['industry'] = $industry;
    $_SESSION['occupation'] = $occupation;
    $_SESSION['body'] = $body;
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
  <link rel="stylesheet" type="text/css" href="../../public/css/base.css">
    <title>Document</title>
</head>
<body>
<div class="col-lg-8 col-md-10 mt-5 mx-auto p-2 border rounded">
  <h1 class="h3 mt-2 mb-3 pb-1 font-weight-normal text-center border-bottom">求人編集</h1>
      <form class="w-100 mx-auto" action="" method="POST">
        <?php foreach($company as $value):?>
          <input type="hidden" name="id" value="<?=h($_GET['id'])?>">
          <input type="hidden" name="company_id" value="<?=h($value['id'])?>">
        <?php endforeach;?>  
          <label for="title" class="h5 sr-only my-1">見出し:</label>
          <h5 class="text-danger"><?php if(!empty($validateErrors['title'])){echo "・".$validateErrors['title'];}?></h5>
          <input class="form-control" id="title" type="text" name="title" value="<?php if(!empty($submit['title'])){ echo h($submit['title']);}else{echo h($value['title']);}?>"  required autofocus/>
          <div class="row">
            <label for="prefectures" class="h5 sr-only my-1">勤務地:</label>
            <h5 class="text-danger"><?php if(!empty($validateErrors['prefectures_id'])){echo "・".$validateErrors['prefectures_id'];}?></h5>
            <h5 class="text-danger"><?php if(!empty($validateErrors['location'])){echo "・".$validateErrors['location'];}?></h5>
              <div class="col-3">
                <select class="form-select" name="prefectures_id" aria-label="Default select example" required>
                  <option value="">--</option>
                  <?php foreach($prefectures as $prefecture):?>
                    <?php if(!empty($submit['prefectures_id']) && $submit['prefectures_id'] == $i ):?>
                      <option selected value="<?=$i?>"><?=$prefecture['prefecture']?></option>
                    <?php elseif($i == $value['prefectures_id']):?>
                      <option selected value="<?=$i?>"><?=$prefecture['prefecture']?></option>
                    <?php else:?>
                    <option value="<?=$i?>"><?=$prefecture['prefecture']?></option>
                    <?php endif;?>
                  <?php $i++; endforeach;?>
                </select>
              </div>
          <div class="col">
           
           <input class="form-control"  type="text" name="location" id="location" placeholder="渋谷区渋谷○丁目○-○" value="<?php if(!empty($submit['location'])){ echo $submit['location'];}else{echo h($value['location']);}?>"  required/>
          </div>
          </div>

          <label for="sector" class="h5 sr-only my-1">業種:</label>
          <h5 class="text-danger"><?php if(!empty($validateErrors['sector_id'])){echo "・".$validateErrors['sector_id'];}?></h5>
          <select class="form-select" name="sector_id" aria-label="Default select example" required>
            <option value="">--</option>
            <?php foreach($sector as $val):?>
              <?php if(!empty($submit['sector_id']) && $submit['sector_id'] == $j ):?>
                <option selected value="<?=$j?>"><?=$val['sector_text']?></option>
              <?php elseif($j == $value['sector_id']):?>
                <option selected value="<?=$j?>"><?=$val['sector_text']?></option>
              <?php else:?>
                <option value="<?=$j?>"><?=$val['sector_text']?></option>
              <?php endif;?>
            <?php $j++; endforeach;?>
          </select>
           
            <div class="form-group my-1">
              <div class="h5 col-sm-2">オプション:</div>
              <div class="form-check-inline form-check-inline">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="gridCheck1" name="educational" value="1"<?php if(!empty($submit['educational']) && $submit['educational'] == 1){ echo 'checked';}elseif($value['educational'] == 1){echo 'checked';}?>>
                  <label class="form-check-label" for="gridCheck1">
                    学歴不問
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="gridCheck2" name="career" value="1"<?php if(!empty($submit['career']) && $submit['career'] == 1){ echo 'checked';}elseif($value['career'] == 1){echo 'checked';}?>>
                  <label class="form-check-label" for="gridCheck2">
                    職歴不問
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="gridCheck3" name="industry" value="1"<?php if(!empty($submit['industry']) && $submit['industry'] == 1){ echo 'checked';}elseif($value['industry'] == 1){echo 'checked';}?>>
                  <label class="form-check-label" for="gridCheck3">
                    業界未経験者歓迎
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="gridCheck4" name="occupation" value="1"<?php if(!empty($submit['occupation']) && $submit['occupation'] == 1){ echo 'checked';}elseif($value['occupation'] == 1){echo 'checked';}?>>
                  <label class="form-check-label" for="gridCheck4">
                    職種未経験者歓迎
                  </label>
                </div>
              </div>
            </div>
          
           <label for="body" class="h5 sr-only my-1">募集内容:</label>
           <h5 class="text-danger"><?php if(!empty($validateErrors['body'])){echo "・".$validateErrors['body'];}?></h5>
           <textarea class="body-form form-control" rows="3" name="body" id="body"  placeholder="2000文字まで入力できます。" required>
           <?php if(!empty($submit['body']) && mb_ereg_match("^(\s|　)+$",$submit['body'])){echo h($submit['body']);}else{ echo h($value['body']);}?></textarea>
          <div class="text-center">
           <input type="hidden" name="csrf_token" value="<?= h(setToken())?>">
           <input class="btn btn-outline-primary my-2 col-6" type="submit" value="更　新"/>
          </div>
          </form>
    
  </div>
</body>
</html>

