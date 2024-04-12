<?php
namespace Service;

use Entity\Membership;
use Storage\IMembership;

class MembershipService{
  private IMembership $store;
  public function __construct(IMembership $store){
    $this->store = $store;
  }

  public function addMembership(Membership $membership){
    $this->store->insertMembership($membership);
  }
  
}