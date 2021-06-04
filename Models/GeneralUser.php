<?php
require_once('Db.php');

class GeneralUser extends Db{

  function getAll($page = 0){
    $sql = "SELECT g.id,g.first_name,g.family_name,g.prefectures_id,g.body,p.prefecture
            FROM general_user g
            LEFT JOIN prefectures p
            ON p.id = g.prefectures_id
            ORDER BY id DESC";
    $sql .=' LIMIT 15 OFFSET '.(15 * $page);
    $stmt = $this->dbh->prepare($sql);
    $stmt->execute();
    //SQLの結果を受け取る
    if(!$stmt){
      die('失敗');
    }else{
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
    }
      $dbh = null;
  }

  function findById($user_id){
    $sql = "SELECT g.id,g.family_name,g.first_name,p.prefecture,g.prefectures_id,g.body,g.career
    FROM general_user g
    LEFT JOIN prefectures p
    ON p.id =g.prefectures_id
    WHERE user_id = $user_id";
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
  function Check($user_id){
    $sql = "SELECT * FROM general_user WHERE user_id = $user_id";
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

  function getUser($id){
    $sql = "SELECT g.id,g.family_name,g.first_name,p.prefecture,g.prefectures_id,g.body,g.career
    FROM general_user g
    LEFT JOIN prefectures p
    ON p.id = g.prefectures_id
    WHERE g.id = $id";
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

  public function countAll():Int{
    $sql = ' SELECT count(*) as count FROM general_user';
    $stmt = $this->dbh->prepare($sql);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    return $count; 
   }

  public function search($words,$prefectures_id,$page){
    //⼊⼒された検索条件からSQl⽂を⽣成
    $where = [];
    if(!empty($words)){
    foreach($words as $word){
      if (!empty($word)) {
        $where[] = "CONCAT(g.body,g.career,p.prefecture) like '%{$word}%'";
      }
    }
  }

    if (!empty($prefectures_id)) {
      $where[] = "g.prefectures_id = $prefectures_id";
    }
  
    if(!empty($where)){
      $whereSql = implode(' AND ', $where);
      $sql =  "SELECT g.id,g.first_name,g.family_name,g.prefectures_id,g.body,g.career,p.prefecture
              FROM general_user g
              LEFT JOIN prefectures p
              ON p.id = g.prefectures_id
              WHERE " . $whereSql ;
      $sql .=' ORDER BY g.id DESC ';
      $sql .=' LIMIT 15 OFFSET '.(15 * $page);

      $stmt = $this->dbh->query($sql);
      //SQLの結果を受け取る
        if(!$stmt){
        die('失敗');
        }else{
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($result)){
          return $result;
        }else{
          return false;
        }
        $dbh = null;
      }
    }
  }

  function CreateGeneralUser($user_id,$connect){
    $sql = 'INSERT INTO general_user(user_id,prefectures_id,family_name,first_name,body,career) VALUES(:user_id,:prefectures_id,:family_name,:first_name,:body,:career)';

    $this->dbh->beginTransaction();

    try{
      $stmt = $this->dbh->prepare($sql);
      $stmt->bindValue(':user_id',$user_id,PDO::PARAM_INT);
      $stmt->bindValue(':prefectures_id',$connect['prefectures_id'],PDO::PARAM_INT);
      $stmt->bindValue(':family_name',$connect['family_name'],PDO::PARAM_STR);
      $stmt->bindValue(':first_name',$connect['first_name'],PDO::PARAM_STR);
      $stmt->bindValue('body',$connect['body'],PDO::PARAM_STR);
      $stmt->bindValue('career',$connect['career'],PDO::PARAM_STR);
      $stmt->execute();
      $this->dbh->commit();
    } catch(PDOException $e){
      $this->dbh->rollback();
      exit($e);  
      echo ('失敗しました');
    }
  }
  

  function UpdateGeneralUser($user_id,$params){
    $sql ="UPDATE general_user 
    SET user_id = :user_id,prefectures_id= :prefectures_id,family_name = :family_name,first_name = :first_name,body = :body,career = :career
    WHERE id = :id";
    $this->dbh->beginTransaction();
    try{
      $stmt = $this->dbh->prepare($sql);
      $stmt->bindValue(':id',$params['id'],PDO::PARAM_INT);
      $stmt->bindValue(':prefectures_id',$params['prefectures_id'],PDO::PARAM_INT);
      $stmt->bindValue(':user_id',$user_id,PDO::PARAM_INT);
      $stmt->bindValue(':family_name',$params['family_name'],PDO::PARAM_STR);
      $stmt->bindValue(':first_name',$params['first_name'],PDO::PARAM_STR);
      $stmt->bindValue('body',$params['body'],PDO::PARAM_STR);
      $stmt->bindValue('career',$params['career'],PDO::PARAM_STR);
      $stmt->execute();
      $this->dbh->commit();
    } catch(PDOException $e){
      $this->dbh->rollback();
      exit($e);  
      echo ('失敗しました');
    }
  }
}
