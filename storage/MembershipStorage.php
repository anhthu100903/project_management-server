<?php

namespace Storage;

use Entity\Membership;
use Ramsey\Uuid\Uuid;
use Storage\PDOManager;
use Exception;
use PDOException;
use DateTime;

class MembershipStorage implements IMembership
{
  private PDOManager $db;

  public function __construct(PDOManager $db)
  {
    $this->db = $db;
  }
  public function insertMembership(Membership $membership)
  {
    try {
      $this->db->getConn()->beginTransaction();

      $query = "INSERT INTO memberships (user_id, project_id, role) VALUES (?, ?, ?)";
      $stmt = $this->db->getConn()->prepare($query);
      $stmt->execute([$membership->getUserId(), $membership->getProjectId(), $membership->getRole()]);

      $query = "insert into project_history_member values (?, ?, ?, ?, ?, ?)";
      $stmt = $this->db->getConn()->prepare($query);
      $now = new DateTime();
      $stmt->execute([Uuid::uuid4(), $membership->getProjectId(), $membership->getUserId(), "join", null, $now->format("Y-m-d H:i:s")]);

      $this->db->getConn()->commit();
    } catch (PDOException $e) {
      $this->db->getConn()->rollBack();
      if ($e->getCode() == '23000') {
        throw new Exception($e->getMessage(), 409);
      } else {
        throw new Exception($e->getMessage(), 500);
      }
    }
  }


  public function updateMembership(Membership $membership){}
  public function deleteMembership(Membership $membership){}
}
