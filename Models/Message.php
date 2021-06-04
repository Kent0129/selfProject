<?php
require_once('Db.php');

class Message extends Db{
  function contactMessage($message_relation_id,$user_id,$text){
    $sql = 'INSERT INTO message (message_relation_id,user_id,text) VALUES(:message_relation_id,:user_id,:text)';
    $this->dbh->beginTransaction();
    try{
      $stmt = $this->dbh->prepare($sql);
      $stmt->bindValue(':message_relation_id',$message_relation_id,PDO::PARAM_INT);
      $stmt->bindValue(':user_id',$user_id,PDO::PARAM_INT);
      $stmt->bindValue(':text',"$text",PDO::PARAM_STR);
      $stmt->execute();
      $this->dbh->commit();
    } catch(PDOException $e){
      $this->dbh->rollback();
      exit($e);  
      echo ('失敗しました');
    }
  }

  function MessageAll($message_relation_id){
    $sql = "SELECT m.id,m.user_id,c.id as company_id,c.name,g.id as general_id,g.family_name,g.first_name,m.text
    FROM message m
    INNER JOIN message_relation mr
    ON m.message_relation_id = mr.id
    LEFT JOIN company c 
    ON c.id = mr.company_id
    LEFT JOIN general_user g
    ON g.id = mr.general_id
    WHERE message_relation_id = $message_relation_id";

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

  function CreateMessage($message_relation_id,$user_id,$text){
    $sql = 'INSERT INTO message (message_relation_id,user_id,text) VALUES(:message_relation_id,:user_id,:text)';

    $this->dbh->beginTransaction();

    try{
      $stmt = $this->dbh->prepare($sql);
      $stmt->bindValue(':message_relation_id',$message_relation_id,PDO::PARAM_INT);
      $stmt->bindValue(':user_id',$user_id,PDO::PARAM_INT);
      $stmt->bindValue(':text',"$text",PDO::PARAM_STR);
      $stmt->execute();
      $this->dbh->commit();
    } catch(PDOException $e){
      $this->dbh->rollback();
      exit($e);  
      echo ('失敗しました');
    }
  }

  function getLatestMessage($mr_id){
    $sql = "SELECT text FROM message WHERE message_relation_id = $mr_id ORDER BY create_at DESC LIMIT 1";
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