<?php
namespace Controller;

use Entity\Workspace;
use Exception;
use LDAP\Result;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Ramsey\Uuid\Nonstandard\Uuid;
use Service\WorkspaceService;

class WorkspaceController{
  private WorkspaceService $service;

  public function __construct(WorkspaceService $service)
  {
    $this->service = $service;
  }

  public function CreateWorkspace(Request $req, Response $res){
    
    try{
      $body = $req->getBody()->getContents();
      $data = json_decode($body);
  
      if(!isset($data->name)){
        throw new Exception("Name is required", 400);
      }
  
      $id = Uuid::uuid4();
  
      $workspace = new Workspace($id, $data->name);
      $this->service->CreateWorkspace($workspace);
      $res = $res->withStatus(200);
      $res->getBody()->write(json_encode(array(
        "message"=> "successfully created",
        "workspace"=> $workspace
      )));
    }catch(Exception $e){
      if($e->getCode() == 400){
        $res = $res->withStatus(400);
      }else{
        $res = $res->withStatus(500);
      }
      $res->getBody()->write($e->getMessage());
      return $res;
    }finally{
      return $res;
    }

  }

  public function GetWorkspacesOfUser(Request $req, Response $res){
    try{
      $user_id = $req->getAttribute('user_id');
      $workspaces = $this->service->GetWorkspacesOfUser($user_id);
      $res = $res->withStatus(200);
      $res->getBody()->write(json_encode(array(
        "workspaces"=> $workspaces
      )));
    }catch(Exception $e){
      $res = $res->withStatus(500);
      $res->getBody()->write($e->getMessage());
    }finally{
      return $res;
    }
  }

  public function GetUserOfWorkspace(Request $req, Response $res){
    try{
      $workspace_id = $req->getAttribute('workspace_id');
      $users = $this->service->GetUserOfWorkspace($workspace_id);
      $res = $res->withStatus(200);
      $res->getBody()->write(json_encode(array(
        "users" => $users
      )));
      return $res;
    }catch(Exception $e){
      $res = $res->withStatus(500);

      $res->getBody()->write($e->getMessage());
      return $res;
    }finally{
    }
  }

}