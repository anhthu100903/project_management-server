<?php

namespace Storage;
use Entity\UserInformation;
use Entity\UserAccount;

interface IAccountStorage{
  public function insertAnAccount(UserInformation $user_information):void;
  public function getAnAccount(String $email):UserAccount;
  public function updatePassword(UserAccount $user_account):void;
}