<?php
namespace Storage;
use Storage\ITaskFieldStorage;
use Storage\PDOManager;
use Entity\TaskField;
use Exception;
use PDOException;

class TaskFieldStorage implements ITaskFieldStorage{

  private PDOManager $db;

  public function __construct(PDOManager $db)
  {
    $this->db = $db;
  }

  public function insertTaskField(TaskField $taskFields){
    try{
      $query = "insert into task_fields values (?, ?, ?, ?)";
      $stmt = $this->db->getConn()->prepare($query);
      $stmt->execute([$taskFields->getId(), $taskFields->getTitle(), $taskFields->getProjectID(), $taskFields->getType()]);
    }catch(PDOException $e){
      if($e->errorInfo[1] == 1452){
        throw new Exception("Project is not exist", 400);
      }else{
        throw new Exception($e->getMessage(), $e->getCode());
      }
    }
  }
  
  public function removeTaskField(String $id){
    try{
      $query = "delete from task_fields where task_field_id = ?";
      $stmt = $this->db->getConn()->prepare($query);
      $stmt->execute([$id]);
      $rowCount = $stmt->rowCount();
      if($rowCount == 0){
        throw new Exception("No Task Field Found", 404);
      }
    }catch(PDOException $e){
      if($e->errorInfo[1] == 1452){
        throw new Exception("Project is not exist", 400);
      }else{
        throw new Exception($e->getMessage(), $e->getCode());
      }
    }
  }
  public function getTaskFieldByProjectID(String $projectID):array{
    try{
      $query = "select * from task_fields where project_id = ?";
      $stmt = $this->db->getConn()->prepare($query);
      $stmt->execute([$projectID]);
      $data = $stmt->fetchAll();
      $taskFields = [];
      foreach($data as $row){
        $taskField = new TaskField($row['task_field_id'], $row['name'], $projectID, $row['type']);
        $taskFields[] = $taskField;
      }
      return $taskFields;
    }catch(PDOException $e){
      throw new Exception($e->getMessage(), 500);
    
    }
  }

  public function updateTaskField(TaskField $taskField)
  {
    try{
      $query = "update task_fields set name = ? where task_field_id = ?";
      $stmt = $this->db->getConn()->prepare($query);
      $stmt->execute([$taskField->getTitle(), $taskField->getId()]);
      $rowEffect = $stmt->rowCount();
      if($rowEffect == 0){
        throw new Exception("No Task Field Found",404);
      }
    }catch(PDOException $e){
      throw new Exception($e->getMessage(), 500);
    }
  }
}
