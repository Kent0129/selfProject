<?php
require_once('Db.php');

class MessageRelation extends Db{
  function Entry($user_id,$general_id,$company_id,$job_id){
    $sql = 'INSERT INTO message_relation (user_id,general_id,company_id,job_id) VALUES(:user_id,:general_id,:company_id,:job_id)';
    $sql2 = 'SELECT LAST_INSERT_ID() as id'; 
    $this->dbh->beginTransaction();// AUTO INCREMENTした値を取得する
    try{
      $stmt = $this->dbh->prepare($sql);
      $stmt->bindValue(':user_id',$user_id,PDO::PARAM_INT);
      $stmt->bindValue(':general_id',$general_id,PDO::PARAM_INT);
      $stmt->bindValue(':company_id',$company_id,PDO::PARAM_INT);
      $stmt->bindValue(':job_id',$job_id,PDO::PARAM_INT);
      $stmt->execute();
      // 実行
      $this->dbh->commit();
      //-------------------------------------------------
      // AUTO INCREMENTした値を取得
      //-------------------------------------------------
      // SQL準備
      $stmt = $this->dbh->prepare($sql2);

      // 実行
      $stmt->execute();
      // 実行結果から1レコード取ってくる
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result;

    } catch(PDOException $e){
      $this->dbh->rollback();
      exit($e);  
      echo ('失敗しました');
    }
  }
  function Scout($user_id,$general_id,$company_id){
    $sql = 'INSERT INTO message_relation (user_id,general_id,company_id) VALUES(:user_id,:general_id,:company_id)';
    $sql2 = 'SELECT LAST_INSERT_ID() as id'; 
    $this->dbh->beginTransaction();// AUTO INCREMENTした値を取得する
    try{
      $stmt = $this->dbh->prepare($sql);
      $stmt->bindValue(':user_id',$user_id,PDO::PARAM_INT);
      $stmt->bindValue(':general_id',$general_id,PDO::PARAM_INT);
      $stmt->bindValue(':company_id',$company_id,PDO::PARAM_INT);
      $stmt->execute();
      // 実行
      $this->dbh->commit();
      //-------------------------------------------------
      // AUTO INCREMENTした値を取得
      //-------------------------------------------------
      // SQL準備
      $stmt = $this->dbh->prepare($sql2);

      // 実行
      $stmt->execute();
      // 実行結果から1レコード取ってくる
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result;

    } catch(PDOException $e){
      $this->dbh->rollback();
      exit($e);  
      echo ('失敗しました');
    }
  }

  //求職者がメッセージ一覧を開くときの企業名を取得
  function getMessageRelationGeneral($user_id){
    $sql = "SELECT m.id,g.family_name, g.first_name, c.name 
    FROM message_relation m
    LEFT JOIN company c
    ON c.id = m.company_id
    LEFT JOIN  general_user g
    ON m.general_id = g.id 
    WHERE m.user_id = $user_id OR g.user_id = $user_id
    ORDER BY id DESC";

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
  //企業がメッセージ一覧を開くときの求職者の名前を取得
  function getMessageRelationCompany($user_id){
    $sql = "SELECT mr.id, mr.user_id,c.name,g.first_name,g.family_name 
    FROM company c
    JOIN  message_relation mr
    ON mr.company_id =c.id
    INNER JOIN general_user g
    ON g.id = mr.general_id
    WHERE c.user_id = $user_id
    ORDER BY id DESC";
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


  function MessageRelationCheck($user_id,$job_id){
    $sql = "SELECT * FROM message_relation WHERE user_id = $user_id AND job_id = $job_id";
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
  function ScoutCheck($user_id,$general_id){
    $sql = "SELECT * 
            FROM message_relation mr
            JOIN company c 
            ON mr.company_id = c.id
            WHERE c.user_id = $user_id AND mr.general_id = $general_id";
    $stmt = $this->dbh->query($sql);
    //SQLの結果を受け取る
    if($stmt->rowCount()){
			//作成済み
			return true;
		}else{
			//作成していない
			return false;
		}
      $dbh = null;
  }

}
?>
