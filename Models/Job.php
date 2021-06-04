<?php
require_once('Db.php');
class Job extends Db{
  function findAll($page = 0):Array {
    $sql = "SELECT j.id,j.title,p.prefecture,j.location,s.sector_text,j.body,j.educational,j.career,j.industry,j.occupation,c.name
            FROM job j
            LEFT JOIN prefectures p
            ON j.prefectures_id = p.id
            left JOIN sector s
            ON j.sector_id = s.id
            LEFT JOIN company c
            ON j.company_id = c.id
            ORDER BY id DESC";
    $sql .=' LIMIT 12 OFFSET '.(12 * $page);
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

  public function countAll():Int{
    $sql = ' SELECT count(*) as count FROM job';
    $stmt = $this->dbh->prepare($sql);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    return $count; 
   }

  public function getOffer($user_id,$page = 0):Array{
    $sql = "SELECT j.id,j.title,p.prefecture,j.location,s.sector_text,j.body,j.educational,j.career,j.industry,j.occupation,c.name
            FROM job j
            LEFT JOIN prefectures p
            ON j.prefectures_id = p.id
            left JOIN sector s
            ON j.sector_id = s.id
            LEFT JOIN company c
            ON j.company_id = c.id
            WHERE j.user_id = $user_id
            ORDER BY id DESC";
    $sql .=' LIMIT 12 OFFSET '.(12 * $page);
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

  public function showOffer($company_id,$page = 0):Array{
    $sql = "SELECT j.id,j.title,p.prefecture,j.location,s.sector_text,j.body,j.educational,j.career,j.industry,j.occupation,c.name
            FROM job j
            LEFT JOIN prefectures p
            ON j.prefectures_id = p.id
            left JOIN sector s
            ON j.sector_id = s.id
            LEFT JOIN company c
            ON j.company_id = c.id
            WHERE j.company_id = $company_id
            ORDER BY id DESC";
    $sql .=' LIMIT 12 OFFSET '.(12 * $page);
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

  function searchAll($words,$search,$page = 0){
      //⼊⼒された検索条件からSQl⽂を⽣成
      $where = [];
      foreach($words as $word){
        if (!empty($word)) {
          $where[] = "CONCAT(j.title,j.body,p.prefecture,j.location,c.name) like '%{$word}%'";
        }
      }
      if (!empty($search['sector_id'])) {
        $sector_id =$search['sector_id'];
        $where[] = "j.sector_id = $sector_id";
      }
      if (!empty($search['prefectures_id'])) {
        $prefectures_id = $search['prefectures_id'];
        $where[] = "j.prefectures_id = $prefectures_id";
      }
      if (!empty($search['educational'])) {
        $educational = $search['educational'];
        $where[] = "j.educational = $educational";
      }
      if (!empty($search['career'])) {
        $career = $search['career'];
        $where[] = "j.career = $career";
      }
      if (!empty($search['industry'])) {
        $industry = $search['industry'];
        $where[] = "j.industry = $industry";
      }
      if (!empty($search['occupation'])) {
        $occupation = $search['occupation'];
        $where[] = "j.occupation = $occupation";
      }

      if(!empty($where)){
        $whereSql = implode(' AND ', $where);
        $sql = "SELECT j.id,j.title,p.prefecture,j.location,s.sector_text,j.body,j.educational,j.career,j.industry,j.occupation,c.name
                FROM job j
                JOIN prefectures p
                ON j.prefectures_id = p.id
                JOIN sector s
                ON j.sector_id = s.id
                JOIN company c
                ON j.company_id = c.id
                WHERE " . $whereSql ;
        $sql .= ' ORDER BY id DESC ';
        $sql .=' LIMIT 12 OFFSET '.(12 * $page);
       
      
        $stmt = $this->dbh->query($sql);
        //SQLの結果を受け取る
        if(!$stmt){
          die('失敗');
        }else{
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          if(!empty($result)){
            return $result;
          }
        }
        $dbh = null;
      }
    }  

  function CreateJob($user_id,$params){
    $sql = 'INSERT INTO job(user_id,company_id,sector_id,prefectures_id,location,title,body,educational,career,industry,occupation) 
    VALUES(:user_id,:company_id,:sector_id,:prefectures_id,:location,:title,:body,:educational,:career,:industry,:occupation)';
    $sql2 = 'SELECT LAST_INSERT_ID() as id'; 
    $this->dbh->beginTransaction();

    try{
      $stmt = $this->dbh->prepare($sql);
      $stmt->bindValue(':user_id',$user_id,PDO::PARAM_INT);
      $stmt->bindValue(':company_id',$params['company_id'],PDO::PARAM_INT);
      $stmt->bindValue(':sector_id',$params['sector_id'],PDO::PARAM_INT);
      $stmt->bindValue(':prefectures_id',$params['prefectures_id'],PDO::PARAM_INT);
      $stmt->bindValue(':location',$params['location'],PDO::PARAM_STR);
      $stmt->bindValue(':title',$params['title'],PDO::PARAM_STR);
      $stmt->bindValue('body',$params['body'],PDO::PARAM_STR);
      $stmt->bindValue(':educational',$params['educational'],PDO::PARAM_INT);
      $stmt->bindValue(':career',$params['career'],PDO::PARAM_INT);
      $stmt->bindValue(':industry',$params['industry'],PDO::PARAM_INT);
      $stmt->bindValue(':occupation',$params['occupation'],PDO::PARAM_INT);
      $stmt->execute();
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

  public function findById($id = 0):Array {
    $sql ="SELECT j.id,j.user_id,c.name,j.company_id,j.title,j.prefectures_id,p.prefecture,j.location,j.sector_id,s.sector_text,j.body,j.educational,j.career,j.industry,j.occupation
    FROM job j
    JOIN company c
    ON c.id = j.company_id
    JOIN prefectures p
    ON j.prefectures_id = p.id
    JOIN sector s
    ON j.sector_id = s.id
    WHERE j.id = :id"; 
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return array($result);
  }

  public function UpdateJob($params){    
    $sql = "UPDATE job SET
    sector_id = :sector_id,prefectures_id = :prefectures_id,location = :location,title = :title,body = :body,educational = :educational,career = :career,industry = :industry,occupation = :occupation
    WHERE id = :id ";

  $this->dbh->beginTransaction();

    try{
      $stmt = $this->dbh->prepare($sql);
      $stmt->bindValue(':id', $params['id'], PDO::PARAM_INT);
      $stmt->bindValue(':sector_id',$params['sector_id'],PDO::PARAM_INT);
      $stmt->bindValue(':prefectures_id',$params['prefectures_id'],PDO::PARAM_INT);
      $stmt->bindValue(':location',$params['location'],PDO::PARAM_STR);
      $stmt->bindValue(':title',$params['title'],PDO::PARAM_STR);
      $stmt->bindValue('body',$params['body'],PDO::PARAM_STR);
      $stmt->bindValue(':educational',$params['educational'],PDO::PARAM_INT);
      $stmt->bindValue(':career',$params['career'],PDO::PARAM_INT);
      $stmt->bindValue(':industry',$params['industry'],PDO::PARAM_INT);
      $stmt->bindValue(':occupation',$params['occupation'],PDO::PARAM_INT);
      $stmt->execute();
      $this->dbh->commit();
    } catch(PDOException $e){
      $this->dbh->rollback();
      exit($e);  
      echo ('失敗しました');
    }
  }

  public function Delete($id){
    //idが空の場合
    if(empty($id)){
      exit('IDが不正です');
    }
    //SQL準備
    $stmt = $this->dbh->prepare("DELETE FROM job Where id = :id");
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
    //SQL実行
    $stmt->execute();
  }
}