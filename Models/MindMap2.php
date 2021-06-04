<?php
require_once('Db.php');

class MindMap2 extends Db{
  public function getMatch($user_id,$mind1_id){
    $sql = "SELECT * FROM mindmap2 WHERE user_id = $user_id AND mind1_id = $mind1_id";
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
    $sql = "SELECT m2.id, m1.id as mind1_id ,m1.content as m1content,m2.id as mind2_id,m2.content as m2content 
            FROM mindmap2 m2
            JOIN mindmap1 m1
            ON m1.id = m2.mind1_id
            WHERE m2.id = $id";
    $stmt = $this->dbh->query($sql);
    if(!$stmt){
      die('失敗');
    }else{
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
    }
      $dbh = null;
  }
  function CreateMindMap2($user_id,$connect){
    $sql = 'INSERT INTO mindmap2(user_id,mind1_id,content) VALUES(:user_id,:mind1_id,:content)';

    $this->dbh->beginTransaction();
  
    try{
      $stmt = $this->dbh->prepare($sql);
      $stmt->bindValue(':user_id',$user_id,PDO::PARAM_INT);
      $stmt->bindValue(':mind1_id',$connect['mind1_id'],PDO::PARAM_INT);
      $stmt->bindValue(':content',$connect['content'],PDO::PARAM_STR);
      $stmt->execute();
      $this->dbh->commit();
    } catch(PDOException $e){
      $dbh->rollback();
      exit($e);  
      echo ('失敗しました');
    }
  }
  public function UpdateMindMap2($update){
    $sql = "UPDATE mindmap2 SET content = :content WHERE id =:id";
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
  public function deleteChain1($id){
    //idが空の場合
    if(empty($id)){
      exit('IDが不正です');
    }
    //SQL準備
    $sql = "DELETE FROM mindmap2 Where mind1_id = $id";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(':min1_id', (int)$id, PDO::PARAM_INT);

    //SQL実行
    $stmt->execute();
    echo "削除しました";
  }
  public function DeleteMindMap2($id){
    //idが空の場合
    if(empty($id)){
      exit('IDが不正です');
    }
    //SQL準備
    $sql = "DELETE FROM mindmap2 Where id = :id";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);

    //SQL実行
    $stmt->execute();
    echo "削除しました";
  }
}
