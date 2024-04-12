<?php

namespace Storage;
use Entity\UserAccount;
use Entity\UserInformation;
use PDO;
use PDOException;
use Exception;
use Firebase\JWT\ExpiredException;

class AccountStorage implements IAccountStorage{

  private PDOManager $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function insertAnAccount(UserInformation $user_information):void{
    try{
      $this->db->getConn()->beginTransaction();
      $query1 = "insert into user_informations values(?, ?, ?, ?, ?, ?)";
      $stmt1 = $this->db->getConn()->prepare($query1);
      $stmt1->execute([$user_information->getUserID(), null, $user_information->getLastName(), $user_information->getFirstName(), $user_information->getUserAccount()->getEmail(), intval(rand(0,131))]);

      $query2 = "insert into user_accounts values(?, ?, ?)";
      $stmt2 = $this->db->getConn()->prepare($query2);
      $stmt2->execute([$user_information->getUserID(), $user_information->getUserAccount()->getEmail(), $user_information->getUserAccount()->getPassword()]);

      $this->db->getConn()->commit();


    }catch(PDOException $e){
      $this->db->getConn()->rollBack();
      if($e->errorInfo[1] == 1062){
        throw new Exception("Duplicate email",400);
      }else{
        throw new Exception($e->getMessage(), 500);
      }
    }
  }
  
  public function getAnAccount(String $email):UserAccount{
    try{
      $query = "select * from user_accounts where email = ?";
      $stmt = $this->db->getConn()->prepare($query);
      $stmt->execute([$email]);

      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if($result){
        return new UserAccount($result['user_id'], $result['email'], $result['password']);
      }else{
        throw new Exception("No User Found", 404);
      }
    }catch (PDOException $e){
      throw new Exception($e->getMessage(), 500);
    }
  }


  public function updatePassword(UserAccount $user_account):void{

  }
}