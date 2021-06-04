<?php
ini_set('display_errors', "On");

// 直リンクを禁止
if (empty($_SERVER["HTTP_REFERER"])) {
  header('Location: ../Job/index.php');
  exit;
}

session_start();

require_once('../../Controller/CompanyController.php');
require_once('../../Controller/MessageRelationController.php');
require_once('../../Controller/MessageController.php');
require_once('../../function/functions.php');

//ユーザーIDを取得
$login_user = $_SESSION['login_user'];
$user_id = $login_user['id'];

//求職者IDを格納
$general_id = $_SESSION['general_id'];
//会社ののIDを取得
$company = new CompanyController();
$company_id = $company->getId($user_id);
//メッセージ内容
$text = $_SESSION['text'];

//メッセージ関係値保存のコントローラーの起動
$message_relation = new MessageRelationController();

//既存チェック
$check = $message_relation->ScoutCheck($user_id,$general_id);

if($check){
  echo "不正なアクセスです";
  exit();
}

//作成
$result = $message_relation->Scout($user_id,$general_id,$company_id);

//作成されたIDを取得
$message_relation_id = $result['id'];


//メッセージを作成
$message = new Message();
$message->contactMessage($message_relation_id,$user_id,$text);

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
  <title>応募完了</title>
</head>
<body>
<?php include('..//Common/_header.php');?>
  <main>
    <div class="contact_box border rounded mt-5 mx-auto text-center">
      <h3 class="py-3">メッセージの送信が完了しました。</h3>
      <a class="btn btn-info my-3" href="../Message/message.php?id=<?=h($message_relation_id)?>">追加でメッセージを送る</a>
    </div>
  </main>
<?php include('../Common/_footer.php');?>
</body>
</html>