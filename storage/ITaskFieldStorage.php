<?php
namespace Storage;
use Entity\TaskField;

interface ITaskFieldStorage{
  public function insertTaskField(TaskField $taskFields);
  public function removeTaskField(String $id);
  public function updateTaskField(TaskField $taskField);
  public function getTaskFieldByProjectID(String $projectID):array;
}