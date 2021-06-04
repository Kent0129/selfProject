<?php
require_once('Db.php');

class LikeJob extends Db{
  public function DbConnect(){
    return $this->dbh;
  }
  public function getLike($j_id){
    $sql ="SELECT * FROM like_job WHERE job_id = :j_id";
    $data = array(':j_id' => $j_id);

    $stmt = $this->dbh->prepare($sql);
    $stmt->execute($data);
    if($stmt){
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}else{
			return false;
		}
  }

  public function isLike($u_id,$j_id){
    $sql ="SELECT * FROM like_job WHERE job_id = :j_id AND user_id = :u_id";
    $data = array(':j_id' => $j_id, 'u_id' => $u_id);

    $stmt = $this->dbh->prepare($sql);
    $stmt->execute($data);
    if($stmt->rowCount()){
			//お気に入りです
			return true;
		}else{
			//特に気に入ってません
			return false;
		}
    $this->dbh = null;
  }
  public function getAll($user_id){
    $sql ="SELECT j.id,j.title,j.body 
    FROM like_job l
    JOIN job j
    ON j.id = l.job_id
    WHERE l.user_id = $user_id
    ORDER BY id DESC";
    $stmt = $this->dbh->query($sql);
    if($stmt){
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}else{
			return false;
		}
  }
}
