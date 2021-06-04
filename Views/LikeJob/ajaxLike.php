<?php
ini_set('display_errors',1);

// 直リンクを禁止
if (empty($_SERVER["HTTP_REFERER"])) {
    header('Location: ../Job/index.php');
    exit;
  }

session_start();
//共通変数・関数ファイルを読込み
require('../../Controller/LikeJobController.php');

$like = new LikeJobController();
$dbh = $like->DbConnect();
// postがある場合
if(isset($_POST['jobId'])){
    $j_id = $_POST['jobId'];
    $u_id = $_SESSION['login_user']['id'];
    
    try{
        // like_jobテーブルから求人IDとユーザーIDが一致したレコードを取得するSQL文
        $sql = 'SELECT * FROM like_job WHERE job_id = :j_id AND user_id = :u_id';
        $data = array(':j_id' => $j_id, 'u_id' => $u_id);
        // クエリ実行
        
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        $resultCount = $stmt->rowCount();
        // レコードが1件でもある場合
        if(!empty($resultCount)){
            // レコードを削除する
            $sql = 'DELETE FROM like_job WHERE job_id = :j_id AND user_id = :u_id';
            $data = array(':j_id' => $j_id, ':u_id' => $u_id);
            // クエリ実行
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);
    
            echo count($like->getLike($j_id));
        }else{
            // レコードを挿入する
            $sql = 'INSERT INTO like_job (job_id, user_id) VALUES (:j_id, :u_id)';
            $data = array(':j_id' => $j_id, ':u_id' => $u_id);
            // クエリ実行
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);
            $count = $like->getLike($j_id);
            echo count($count);
        }
    }catch(Exception $e){
        error_log('エラー発生：'.$e->getMessage());
    }
}