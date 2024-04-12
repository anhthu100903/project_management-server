<?php
namespace Storage;

use Entity\Membership;

interface IMembership{
  public function insertMembership(Membership $membership);
  public function updateMembership(Membership $membership);
  public function deleteMembership(Membership $membership);
}