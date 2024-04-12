<?php

namespace Storage;
use Entity\UserInformation;
use Entity\UserAccount;
use PDOException;
use PDO;
use Exception;

class UserStorage implements IUserStorage{

  private PDOManager $db;
  public function __construct(PDOManager $db)
  {
    $this->db = $db;
  } 

  public function insertUser(UserInformation $userInformation):void{

  }

  public function getAnUser(String $userID):UserInformation{
    try{
      $query = "select * from user_informations where user_id = ?";
      $stmt = $this->db->getConn()->prepare($query);
      $stmt->execute([$userID]);

      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if($result){
        $user = new UserInformation($userID, $result['first_name'], $result['last_name'], $result['job_title'], $result['avatar_url'], null, $result['color']);
      }else{
        throw new Exception("No User Found", 404);
      }
      return $user;
    }catch (PDOException $e){
      throw new Exception($e->getMessage(), 500);
    }
  }

  public function getAllUsers():array{
    return [];
  }

  public function updateUserInformation(UserInformation $userInformation):void{

  }


  

}