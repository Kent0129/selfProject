<?php
require_once('Db.php');

class MindMap1 extends Db{
  function getAll(){
    $sql = "SELECT * FROM mindmap1";
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
  public function findById($id){
    $sql = "SELECT * FROM mindmap1 WHERE id = $id";
    $stmt = $this->dbh->query($sql);
    if(!$stmt){
      die('失敗');
    }else{
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
    }
      $dbh = null;
  }

  public function getMatch($user_id){
    $sql = "SELECT * FROM mindmap1 WHERE user_id =$user_id";
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

  function CreateMindMap($user_id,$contact){
    $sql = 'INSERT INTO mindmap1(user_id,content) VALUES(:user_id,:content)';

    $this->dbh->beginTransaction();

    try{
      $stmt = $this->dbh->prepare($sql);
      $stmt->bindValue(':user_id',$user_id,PDO::PARAM_INT);
      $stmt->bindValue(':content',$contact['content'],PDO::PARAM_STR);
      $stmt->execute();
      $this->dbh->commit();
    } catch(PDOException $e){
      $this->dbh->rollback();
      exit($e);  
      echo ('失敗しました');
    }
  }
  public function UpdateMindMap1($update){
    $sql = "UPDATE mindmap1 SET content = :content WHERE id =:id";
    $this->dbh->beginTransaction();
    try{
      $stmt = $this->dbh->prepare($sql);
      $stmt->bindValue(':id',$update['id'],PDO::PARAM_INT);
      $stmt->bindValue(':content',$update['content'],PDO::PARAM_STR);
      $stmt->execute();
      $this->dbh->commit();
    } catch(PDOException $e){
      $this->dbh->rollback();
      exit($e);  
      echo ('失敗しました');
    }
  }
  public function DeleteMindMap1($id){
    //idが空の場合
    if(empty($id)){
      exit('IDが不正です');
    }
    //SQL準備
    $sql = "DELETE FROM mindmap1 Where id = :id";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);

    //SQL実行
    $stmt->execute();
    echo "削除しました";
  }
}