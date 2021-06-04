<?php
ini_set('display_errors', "On");
session_start();

require_once('../../Controller/JobController.php');
require_once('../../Controller/ReadController.php');
require_once('../../function/functions.php');//共通のファンクション

if(!empty($_SESSION['login_user'])){
  $user_id = $_SESSION['login_user']['id'];
  $role = $_SESSION['login_user']['role'];
}else{
  $user_id = NULL;
  $role = 0;
}

$job = new JobController(); 
$result = $job->index();


$read =  new ReadController();
$prefectures = $read->getPrefectures();
$i = 1;
$sector = $read ->getSector();
$j = 1;


if($_SERVER['REQUEST_METHOD'] === 'POST'){
  //以下バリデーション
  $search = filter_input(INPUT_POST,'search');
  $prefectures_id = filter_input(INPUT_POST,'prefectures_id');
  $sector_id = filter_input(INPUT_POST,'sector_id');
  $educational = filter_input(INPUT_POST,'educational');
  $career = filter_input(INPUT_POST,'career');
  $industry = filter_input(INPUT_POST,'industry');
  $occupation = filter_input(INPUT_POST,'occupation');

  if(empty($search) && empty($prefectures_id) && empty($sector_id) && empty($educational) && empty($career) && empty($industry) && empty($occupation)){
    $err ='検索したい内容を入力してください';
  }else{
    $_SESSION['search'] = $search;
    $_SESSION['prefectures_id'] = $prefectures_id;
    $_SESSION['sector_id'] = $sector_id;
    $_SESSION['educational'] = $educational;
    $_SESSION['career'] = $career;
    $_SESSION['industry'] = $industry;
    $_SESSION['occupation'] = $occupation;
    header('location: search.php');
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
<div class="col-11 mx-auto">
  <!-- Button trigger modal -->
  <div class="d-flex flex-row-reverse m-2">
    <button type="button" class="btn btn-info col-lg-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
      検　索
    </button>
  </div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">検索</h5>
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
        <label for="sector" class="sr-only my-1"></label>
          <select class="form-select" name="sector_id" aria-label="Default select example">
            <option selected value="">業種から探す</option>
            <?php foreach($sector as $val):?>
              <option value="<?=$j?>"><?=$val['sector_text']?></option>
            <?php $j++; endforeach;?>
            </select>

            <div class="form-group my-1">
              <div class="col-6">オプションを選んで探す:</div>
              <div class="form-check-inline form-check-inline">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="gridCheck1" name="educational" value="1">
                  <label class="form-check-label" for="gridCheck1">
                    学歴不問
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="gridCheck2" name="career" value="1">
                  <label class="form-check-label" for="gridCheck2">
                    職歴不問
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="gridCheck3" name="industry" value="1">
                  <label class="form-check-label" for="gridCheck3">
                    業界未経験者歓迎
                  </label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="gridCheck4" name="occupation" value="1">
                  <label class="form-check-label" for="gridCheck4">
                    職種未経験者歓迎
                  </label>
                </div>
              </div>
            </div>

      </div>
      <div class="modal-footer d-flex justify-content-center ">
        <button type="submit" class="col-6 btn btn-info">検索</button>
      </form>
      </div>
    </div>
  </div>
</div>

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