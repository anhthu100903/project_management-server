<?php
namespace Service;

use Entity\TaskField;
use Exception;
use Storage\ITaskFieldStorage;

class TaskFieldService{
  private ITaskFieldStorage $store;

  public function __construct(ITaskFieldStorage $store)
  {
    $this->store = $store;
  }

  public function CreateTaskField(TaskField $taskField){
    if($taskField->getTitle() == ""){
      throw new Exception("Title cannot be blank", 400);
    }

    if($taskField->getType() > 4){
      throw new Exception("Type is invalid", 400);
    }

    $this->store->insertTaskField($taskField);

  }

  public function DeleteTaskField(String $id){
    $this->store->removeTaskField($id);
  }

  public function getTaskFieldOfProject(String $projectID){
    return $this->store->getTaskFieldByProjectID($projectID);
  }
  
  public function updateTaskField(TaskField $taskField){
    if($taskField->getTitle() == ""){
      throw new Exception("Name cannot be blank");
    }
    $this->store->updateTaskField($taskField);
  }


}