<?php
namespace Service;

use Entity\UserAccount;
use Entity\UserInformation;
use Storage\IAccountStorage;
use Exception;
class AccountService{
  private IAccountStorage $store;

  public function __construct(IAccountStorage $store)
  {
    $this->store = $store;
  }

  public function Login(String $email, String $password):UserAccount{
    $account = $this->store->getAnAccount($email);
    if(password_verify($password, $account->getPassword())){
      return $account;
    }else{
      throw new Exception("Email or password is incorrect", 401);
    }

  }

  public function Register(UserInformation $user_information){
    if($user_information->getLastName() == ""){
      throw new Exception("Last name cannot be blank", 400);
    }
    if($user_information->getFirstName() == ""){
      throw new Exception("First name cannot be blank", 400);
    }
    if (strlen($user_information->getUserAccount()->getPassword()) <=6 ){
      throw new Exception("Password must have more than 6 characters", 400);
    }

    $hashPassword = password_hash($user_information->getUserAccount()->getPassword(), PASSWORD_BCRYPT);
    $user_information->getUserAccount()->setPassword($hashPassword);

    $this->store->insertAnAccount($user_information);

  }

  public function VerifyOpt(String $otp, String $email){
    
  }
}