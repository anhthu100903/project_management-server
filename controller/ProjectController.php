<?php

namespace Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Ramsey\Uuid\Uuid;
use Exception;
use DateTime;
use Service\ProjectService;
use Entity\Project;

class ProjectController
{

  private ProjectService $service;

  public function __construct(ProjectService $service)
  {
    $this->service = $service;
  }

  public function CreateProject(Request $req, Response $res)
  {
    $body = $req->getBody()->getContents();
    $data = json_decode($body);

    if (!isset($data->description)) {
      $data->description = null;
    }

    if (!isset($data->name)) {
      $res = $res->withStatus(400);
      $res->getBody()->write("Name is required");
      return $res;
    }

    if (!isset($data->owner_id)) {
      $res = $res->withStatus(400);
      $res->getBody()->write("OwnerID is required");
      return $res;
    }

    if (!isset($data->project_id)) {
      $data->project_id = Uuid::uuid4();
    }
    $createAt = new DateTime();
    if (isset($data->create_at)) {
      $createAt = DateTime::createFromFormat('Y-m-d H:i:s', $data->create_at);
    }

    $project = new Project($data->project_id, $data->name, $data->description, $data->owner_id, $createAt, $data->color, null, null);

    try {
      $this->service->CreateAproject($project);
      $res = $res->withStatus(200);
      $res->getBody()->write(json_encode(
        array(
          "message" => "Create successfully",
          "project" => $project
        )
      ));
      return $res;
    } catch (Exception $e) {
      if ($e->getCode() == 409) {
        $res = $res->withStatus(409);
      } else {
        $res = $res->withStatus(500);
      }
      $res->getBody()->write($e->getMessage());
      return $res;
    }
  }

  public function getAllProject(Request $req, Response $res)
  {
    $queryParams = $req->getQueryParams();
    $limit = isset($queryParams['limit']) ? (int) $queryParams['limit'] : 10;
    $offset = isset($queryParams['offset']) ? (int) $queryParams['offset'] : 0;

    try {
      $result = $this->service->getAllListProject($limit, $offset);

      $res = $res->withStatus(200);
      $res->getBody()->write(json_encode(
        array(
          "limit" => $limit,
          "page" => (int)($offset / $limit) + 1,
          "projects" => $result
        )
      ));
      return $res;
    } catch (Exception $e) {
      $res = $res->withStatus(500);
      $res->getBody()->write($e->getMessage());
      return $res;
    }
  }


  public function updateProject(Request $req, Response $res)
  {
    try {
      $requestBody = $req->getBody()->getContents();
      $requestBody = json_decode($requestBody, true);

      if (!isset($requestBody['name'])) {
        throw new Exception("Name is required", 400);
      }

      if (!isset($requestBody['description'])) {
        throw new Exception("Description is required", 400);
      }

      if(!isset($requestBody['color'])){
        throw new Exception("Color is required", 400);
      }

      if(!isset($requestBody['status'])){
        throw new Exception("Status is required", 400);
      }

      if(!array_key_exists('due_date', $requestBody)){
        throw new Exception("Due date is required", 400);
      }

      $name = $requestBody['name'];
      $description = $requestBody['description'];
      $color = $requestBody['color'];
      $projectID = $req->getAttribute('project_id');
      $status = $requestBody['status'];
      $dueDate = $requestBody['due_date']? new DateTime($requestBody['due_date']):null;

      $project = new Project($projectID, $name, $description, null, null, $color, $dueDate, $status);

      $this->service->updateAProject($project);
      $res = $res->withStatus(200);
      $res->getBody()->write(json_encode("successfully updated"));
      return $res;
    } catch (Exception $e) {
      if ($e->getCode() == 400) {
        $res = $res->withStatus(400);
        $res->getBody()->write($e->getMessage());
      } else {
        $res = $res->withStatus(500);
        $res->getBody()->write($e->getMessage());
      }
      return $res;
    }
  }

  public function getAProject(Request $req, Response $res)
  {
    try {
      $result = $this->service->getOneProject($req->getAttribute('project_id'));
      $res = $res->withStatus(200);
      $res->getBody()->write(json_encode($result));
      return $res;
    } catch (Exception $e) {
      if ($e->getCode() == 400) {
        $res = $res->withStatus(400);
        $res->getBody()->write($e->getMessage());
      } elseif ($e->getCode() == 404) {
        $res = $res->withStatus(404);
        $res->getBody()->write($e->getMessage());
      } else {
        $res = $res->withStatus(500);
        $res->getBody()->write($e->getMessage());
      }
      return $res;
    }
  }

  public function  deleteProject(Request $req, Response $res)
  {
    $project_id = $req->getAttribute('project_id');
    $project = new Project($project_id);
    try {
      $this->service->deleteAProject($project);
      $res = $res->withStatus(200);
      $res->getBody()->write(json_encode(
        array(
          "message" => "successfully deleted"
        )
      ));
      return $res;
    } catch (Exception $e) {
      if ($e->getCode() == 404) {
        $res = $res->withStatus(404);
      } else {
        $res = $res->withStatus(500);
      }
      $res->getBody()->write($e->getMessage());
      return $res;
    }
  }
  public function GetProjectOfUser(Request $req, Response $res)
  {
    try{
      $projects = $this->service->GetProjectOfUser($req->getAttribute('workspace_id'), $req->getAttribute('user_id'));
      $res = $res->withStatus(200);
      $res->getBody()->write(json_encode(
        array(
          "projects"=>$projects
        )
      ));

    }catch(Exception $e){
      $res = $res->withStatus(200);
      $res->getBody()->write($e->getMessage());
    }finally{
      return $res;
    }
  }

  public function GetUserOfProject(Request $req, Response $res){
    try{
      $project_id = $req->getAttribute('project_id');
      $queryParams = $req->getQueryParams();
      $limit = 10;
      $offset = 0;
      if(isset($queryParams['limit'])){
        $limit = (int)$queryParams['limit'];
      }

      if(isset($queryParams['offset'])){
        $limit = (int)$queryParams['offset'];
      }



      $users = $this->service->getUserOfProject($project_id, $limit, $offset);

      $res = $res->withStatus(200);
      $res->getBody()->write(json_encode(array(
        "users"=> $users
      )));
    }catch(Exception $e){
      $res = $res->withStatus(200);
      $res->getBody()->write($e->getMessage());
    }finally{
      return $res;
    }
  }

  public function GetHistoryMember(Request $req, Response $res){
    try{
      $project_id = $req->getAttribute('project_id');
      $histories = $this->service->getHistoryMember($project_id);
      $res=$res->withStatus(200);
      $res->getBody()->write(json_encode($histories));
      return $res;
    }catch(Exception $e){
      $res = $res->withStatus(500);
      $res->getBody()->write($e->getMessage());
      return $res;
    }
  }
}
