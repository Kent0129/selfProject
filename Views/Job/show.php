<?php
ini_set('display_errors', "On");
session_start();

require_once('../../Controller/JobController.php');
require_once('../../Controller/LikeJobController.php');
require_once('../../Models/MessageRelation.php');
require_once('../../function/functions.php');
require_once('../../Controller/GeneralUserController.php');
//コントローラーの起動
$job = new JobController(); //求人
$mr  = new MessageRelation(); //メッセージの関係テーブル
$like = new LikeJobController(); //お気に入り
$g_user = new GeneralUserController();

if(!empty($_GET['id'])){
  // 投稿IDのGETパラメータを取得
  $job_id = $_GET['id'];
  // DBから投稿データを取得
  $jobData = $job->findById($job_id);
  // DBからいいねの数を取得
  $jobLikeNum = count($like->getLike($job_id));
}/*else{
  //不性アクセスlocation();
}*/

//ログインユーザーの情報
if(!empty($_SESSION['login_user'])){//ログイン判定
  $login_user = $_SESSION['login_user'];
  $user_id = $login_user['id'];
  $role = $login_user['role'];
  if(!empty($user_id) && !empty($job_id)){
    //応募しているか確認
    $check = $mr->MessageRelationCheck($user_id,$job_id);
    //
    $isLike = $like->isLike($user_id,$job_id);
  }
  //自己紹介があるか確認
  $gu_check = $g_user->Check($user_id);
}else{
  $user_id = NULL;
  $role = 0;
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
  <script src="https://kit.fontawesome.com/cfc5b4a4e4.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="../../public/css/base.css">
  <link rel="stylesheet" type="text/css" href="../../public/css/style.css">

  <title>求人詳細</title>
</head>
<body>
<?php include('..//Common/_header.php');?>
  <main>
<div class="col-lg-9 col-md-10 mx-auto">
  <?php foreach($jobData as $val):?>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">どの程度興味がありますか？</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          <form action="join.php" method="POST">
            <input type="hidden" name="company_id" value="<?=$val['company_id']?>">
            <input type="hidden" name="job_id" value="<?=$job_id ?>">
            <p>
            <input type="radio" class="radio" name="text" value="今すぐ一緒に働きたい" checked="checked">
            今すぐ一緒に働きたい
            </p>
            <p>
            <input type="radio" class="radio" name="text" value="まずは話を聞いてみたい">
            まずは話を聞いてみたい
            </p>
            <p>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">応募する</button>
          </form>
          </div>
        </div>
      </div>
    </div> <!-- /Modal -->
    <?php if($user_id == $val['user_id'] and $role == 2):?>
        <div class="d-flex flex-row-reverse">
          <p class="pull-right"><a href="edit_jop.php?id=<?=$_GET['id']?>" class="btn btn-outline-info">編集</a>
          <a href="delete.php?id=<?=$_GET['id']?>" onclick="return confirm('求人を削除しますか？')" class="btn btn-outline-info ">削除</a></p>
      </div>
      <?php elseif($role == 1):?>
        <div class="d-flex flex-row-reverse my-2">
          <div class="border rounded p-3 col-lg-3 text-center btn-outline-info">
            <section class="post" data-jobid="<?=h($job_id);?>">
                <div class="btn-like">
                    <!-- ユーザーのお気に入り状況により表示するアイコンを変更 -->
                  <?php if($isLike):?>
                    <i class="fas fa-bookmark">お気に入り：</i>
                    <span><?php echo $jobLikeNum;?>件</span>
                   <?php else:?>
                      <i class="far fa-bookmark">お気に入り：</i>
                      <span><?php echo $jobLikeNum;?>件</span>
                    <?php endif;?>
                </div>
            </section>
          </div>
        </div>
    <?php endif;?>
    <div class="col">
      <div class="card ">
        <div class="card-body">
          <p class=""><?=$val['sector_text']?></p>
          <h4 class="card-title border-top py-2"><a class="text-info text-decoration-none" href="../Company/show.php?id=<?=h($val['company_id'])?>"><?=$val['name']?></a></h4>
          <h2 class="card-title border-top border-bottom py-2"><?=$val['title']?></h2>
          <p class="border-bottom pb-2">勤務地：<?=$val['prefecture']?><?=$val['location']?></p>
          <?php if($val['educational'] == 1 ||$val['industry'] == 1 || $val['career'] == 1 || $val['occupation'] == 1):?>
            <p class="border-bottom pb-2">
              <?php if($val['educational'] == 1):?>
              ・学歴不問
              <?php endif;?>
              <?php if($val['career'] == 1):?>
                ・職歴不問
              <?php endif;?>
              <?php if($val['industry'] == 1):?>
                ・業界未経験者歓迎
              <?php endif;?>
              <?php if($val['occupation'] == 1):?>
                  ・職種未経験者歓迎
              <?php endif;?>
            </p>
          <?php endif;?>
          <p class="card-text"><?=n(h($val['body']))?></p>
          <div class="text-center">
            <form action="join.php" method="POST">
              <input type="hidden" name="company_id" value="<?=$val['company_id']?>">
              <input type="hidden" name="job_id" value="<?=$val['id']?>">
              <!-- Button trigger modal -->
              <?php if($role == 1):?>
                <?php if($gu_check == true && empty($check)) :?>
                  <button type="button" class="btn btn-primary col-6" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    応募する
                  </button>
                <?php elseif($gu_check == true && !empty($check)):?>
                  <h4 class="col-6 mx-auto rounded bg-secondary text-white p-2">応募済みです</h4>
                <?php elseif($gu_check == false ):?>
                <h4 class="col-6 mx-auto rounded bg-secondary text-white p-2">応募するには自己紹介を書く必要があります</h4>
                <?php endif;?>
              <?php endif;?>
           </form>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach;?>
</div>

              </main>
<?php include('../Common/_footer.php');?>
<script type="text/javascript" src="../../public/js/like_job.js"></script>
</body>
</html>