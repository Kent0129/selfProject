<?php
require_once('Db.php');

class MindMap4 extends Db{
  function getMatch($user_id,$mind3_id){
    $sql = "SELECT * FROM mindmap4 WHERE user_id = $user_id AND mind3_id = $mind3_id";;
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

  function CreateMindMap($contact){
    $sql = 'INSERT INTO mindmap4(mind2_id,content) VALUES(:mind2_id,:content)';

    $this->dbh->beginTransaction();
  
    try{
      $stmt = $this->dbh->prepare($sql);
      $stmt->bindValue(':mind2_id',$contact['id'],PDO::PARAM_INT);
      $stmt->bindValue(':content',$contact['content'],PDO::PARAM_STR);
      $stmt->execute();
      $this->dbh->commit();
    } catch(PDOException $e){
      $dbh->rollback();
      exit($e);  
      echo ('失敗しました');
    }
  }
  function CreateMindMap4($user_id,$connect){
    $sql = 'INSERT INTO mindmap4(user_id,mind1_id,mind2_id,mind3_id,content) VALUES(:user_id,:mind1_id,:mind2_id,:mind3_id,:content)';

    $this->dbh->beginTransaction();
  
    try{
      $stmt = $this->dbh->prepare($sql);
      $stmt->bindValue(':user_id',$user_id,PDO::PARAM_INT);
      $stmt->bindValue(':mind1_id',$connect['mind1_id'],PDO::PARAM_INT);
      $stmt->bindValue(':mind2_id',$connect['mind2_id'],PDO::PARAM_INT);
      $stmt->bindValue(':mind3_id',$connect['mind3_id'],PDO::PARAM_INT);
      $stmt->bindValue(':content',$connect['content'],PDO::PARAM_STR);
      $stmt->execute();
      $this->dbh->commit();
    } catch(PDOException $e){
      $this->dbh->rollback();
      exit($e);  
      echo ('失敗しました');
    }
  }
  public function findById($id){
    $sql = "SELECT m4.id,m1.id as mind1_id ,m2.id as mind2_id,m3.id as mind3_id,m3.content as m3content,m4.content as m4content 
            FROM mindmap4 m4
            JOIN mindmap3 m3
            ON m3.id = m4.mind3_id
            JOIN mindmap2 m2
            ON m2.id = m3.mind2_id
            JOIN mindmap1 m1
            ON m1.id = m2.mind1_id
            WHERE m4.id = $id";
    $stmt = $this->dbh->query($sql);
    if(!$stmt){
      die('失敗');
    }else{
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
    }
      $dbh = null;
  }

  public function UpdateMindMap4($update){
    $sql = "UPDATE mindmap4 SET content = :content WHERE id =:id";
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
    $sql = "DELETE FROM mindmap4 Where mind1_id = $id";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(':min1_id', (int)$id, PDO::PARAM_INT);

    //SQL実行
    $stmt->execute();
    echo "削除しました";
  }
  public function deleteChain2($id){
    //idが空の場合
    if(empty($id)){
      exit('IDが不正です');
    }
    //SQL準備
    $sql = "DELETE FROM mindmap4 Where mind2_id = $id";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(':min2_id', (int)$id, PDO::PARAM_INT);

    //SQL実行
    $stmt->execute();
    echo "削除しました";
  }
  public function deleteChain3($id){
    //idが空の場合
    if(empty($id)){
      exit('IDが不正です');
    }
    //SQL準備
    $sql = "DELETE FROM mindmap4 Where mind3_id = $id";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(':mine3_id', (int)$id, PDO::PARAM_INT);

    //SQL実行
    $stmt->execute();
    echo "削除しました";
  }
  public function DeleteMindMap4($id){
    //idが空の場合
    if(empty($id)){
      exit('IDが不正です');
    }
    //SQL準備
    $sql = "DELETE FROM mindmap4 Where id = :id";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);

    //SQL実行
    $stmt->execute();
    echo "削除しました";
  }
  
}
