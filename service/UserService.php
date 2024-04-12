<?php

namespace Service;

use Entity\UserInformation;
use Storage\IUserStorage;

class UserService{
  private IUserStorage $store;

  public function __construct(IUserStorage $store)
  {
    $this->store = $store;
  }

  public function getAnUser(String $userID):UserInformation{
    return $this->store->getAnUser($userID);
  }
  
}