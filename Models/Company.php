<?php
require_once('Db.php');

class Company extends Db{
  function CreateCompany($user_id,$connect){
    $sql = 'INSERT INTO company(user_id,name,prefectures_id,location,body) VALUES(:user_id,:name,:prefectures_id,:location,:body)';

    $this->dbh->beginTransaction();

    try{
      $stmt = $this->dbh->prepare($sql);
      $stmt->bindValue('user_id',$user_id,PDO::PARAM_INT);
      $stmt->bindValue(':name',$connect['name'],PDO::PARAM_STR);
      $stmt->bindValue(':prefectures_id',$connect['prefectures_id'],PDO::PARAM_INT);
      $stmt->bindValue(':location',$connect['location'],PDO::PARAM_STR);
      $stmt->bindValue('body',$connect['body'],PDO::PARAM_STR);
      $stmt->execute();
      $this->dbh->commit();
    } catch(PDOException $e){
      $this->dbh->rollback();
      exit($e);  
      echo ('失敗しました');
    }
  }

  function findById($user_id){
    $sql = "SELECT * FROM company WHERE user_id = $user_id";
    $stmt = $this->dbh->query($sql);
    if(!$stmt){
      die('失敗');
    }else{
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }
  }

  function getUser($id){
    $sql = "SELECT * FROM company WHERE id = $id";
    $stmt = $this->dbh->query($sql);
    if(!$stmt){
      die('失敗');
    }else{
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }
  }

  function UpdateCompany($user_id,$connect){
    $sql = "UPDATE company 
    SET user_id = :user_id,name = :name,prefectures_id = :prefectures_id,location = :location,body = :body
    WHERE
    id = :id";

    $this->dbh->beginTransaction();
    try{
      $stmt = $this->dbh->prepare($sql);
      $stmt->bindValue('id',$connect['id'],PDO::PARAM_INT);
      $stmt->bindValue('user_id',$user_id,PDO::PARAM_INT);
      $stmt->bindValue(':name',$connect['name'],PDO::PARAM_STR);
      $stmt->bindValue(':prefectures_id',$connect['prefectures_id'],PDO::PARAM_INT);
      $stmt->bindValue(':location',$connect['location'],PDO::PARAM_STR);
      $stmt->bindValue('body',$connect['body'],PDO::PARAM_STR);
      $stmt->execute();
      $this->dbh->commit();
    } catch(PDOException $e){
      $this->dbh->rollback();
      exit($e);  
      echo ('失敗しました');
    }
  }
}