<?php 
namespace Storage;

use DateTime;
use Entity\Task;


interface ItaskStorage{
  public function inserTask(Task $task):void;
  public function updateTask(Task $task):void;
  public function updateStatus(String $boardID, String $staskID): void;
  public function updateAssignedUSer(String $assignedUserID,String $taskID):void;
  public function getTasksOfProject(?String $projectID, ?int $status, ?String $assignee_id, ?DateTime $startDate, ?DateTime $endDate):array;
  public function deleteTask(String $taskID):void;
  
}