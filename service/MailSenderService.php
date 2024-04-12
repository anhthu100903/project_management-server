<?php

namespace Service;

use Storage\IMailSenderStorage;
use Exception;

class MailSenderService{
  private IMailSenderStorage $store;

  public function __construct(IMailSenderStorage $store){
      $this->store = $store;
  }

  public function CreateOTP(int $otp, String $email):void{
    
    if($otp < 1000 || $otp > 9999){
      throw new Exception("OTP is not valid", 400);
    }
    if(!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)){
      throw new Exception("email is not valid", 400);
    }
    $this->store->insertOTP($otp, $email);
  }

  public function VerifyOTP(String $email, int $otpVerify){
    $otp = $this->store->getOtp($email);
    if($otp != $otpVerify){
      throw new Exception($otp." ".$otpVerify , 401);
    }
  }
}