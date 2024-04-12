<?php

namespace Storage;

use Entity\UserAccount;
use Entity\UserInformation;

interface IUserStorage{
  public function insertUser(UserInformation $userInformation):void;
  public function getAnUser(String $userID):UserInformation;
  public function getAllUsers():array;
  public function updateUserInformation(UserInformation $userInformation):void;
}