<?php
require_once('Db.php');
//業種データが入ったテーブル
class Sector extends Db{
  function getAll(){
    $sql = "SELECT * FROM sector";
    $stmt = $this->dbh->query($sql);
    //SQLの結果を受け取る
    if(!$stmt){
      die('失敗');
    }else{
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
    }
      $dbh = null;
  }
}