<?php
require_once('Db.php');
//都道府県のデータが入ったテーブル
class Prefectures extends Db{
  function getAll(){
    $sql = "SELECT * FROM prefectures";
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