<?php

namespace Controller;

use Entity\TaskField;
use Exception;
use Service\TaskFieldservice;
use Service\TaskService;
use Ramsey\Uuid\Uuid;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TaskFieldController{
  private TaskFieldservice $service;

  public function __construct(TaskFieldService $service)
  {
    $this->service = $service;
  }

  public function CreateTaskField(Request $req, Response $res){
    $body = $req->getBody()->getContents();
    $data = json_decode($body);

    if(!isset($data->name)){
      $res = $res->withStatus(400);
      $res->getBody()->write("Name is required");
      return $res; 
    }

    if(!isset($data->project_id)){
      $res = $res->withStatus(400);
      $res->getBody()->write("ProjectID is required");
      return $res;
    }

    if(!isset($data->type)){
      $res = $res->withStatus(400);
      $res->getBody()->write("Type is required");
      return $res;
    }

    $taskFieldID = Uuid::uuid4();

    $taskField = new TaskField($taskFieldID, $data->name, $data->project_id, $data->type);

    try{
      $this->service->CreateTaskField($taskField);
      $res = $res->withStatus(200);
      $res->getBody()->write("create successfully");
      return $res;
    }catch(Exception $e){
      $res = $res->withStatus($e->getCode());
      $res->getBody()->write($e->getMessage());
      return $res;
    }

  }

  public function DeleteTaskField(Request $req, Response $res){
    
    $taskFieldID = $req->getAttribute('task_field_id');

    try{
      $this->service->DeleteTaskField($taskFieldID);
      $res = $res->withStatus(200);
      $res->getBody()->write("Delete successfully");
    }catch(Exception $e){
      $res = $res->withStatus($e->getCode());
      $res->getBody()->write($e->getMessage());
    }finally{
      return $res;
    }
  }

  public function GetTaskFieldByProjectID(Request $req, Response $res){
    $projectID = $req->getAttribute('project_id');
    try{
      $taskFields = $this->service->getTaskFieldOfProject($projectID);
      $res = $res->withStatus(200);
      $res->getBody()->write(json_encode(array(
        "task_fields"=> $taskFields
      )));

    }catch(Exception $e){
      $res = $res->withStatus($e->getCode());
      $res->getBody()->write($e->getMessage());
    }finally{
      return $res;
    }
  }

  public function UpdateTaskField(Request $req, Response $res){
    $projectID = $req->getAttribute('project_id');
    $taskFieldID = $req->getAttribute('task_field_id');
    $body = $req->getBody()->getContents();
    $data = json_decode($body);
    try{
      if(!isset($data->name)){
        throw new Exception("Name is required", 400); 
      }
      $taskField = new TaskField($taskFieldID, $data->name, $projectID, null);
      $this->service->UpdateTaskField($taskField);
      $res = $res->withStatus(200);
      $res->getBody()->write("update successful");
    }catch(Exception $e){
      $res = $res->withStatus($e->getCode());
      $res->getBody()->write($e->getMessage());
    }finally{
      return $res;
    }

  }

}