<?php

namespace Service;

use Storage\IProjectStorage;
use Entity\Project;
use Exception;

class ProjectService{
  private IProjectStorage $store;

  public function __construct(IProjectStorage $store)
  {
    $this->store = $store;
  }

  public function CreateAproject(Project $project):void{

    if($project->getOwnerID() == ""){
      throw new Exception("OwnerID cannot be blank", 400);
    }

    if($project->getName() == ""){
      throw new Exception("Project name cannot be blank", 400);
    }

    $this->store->insertAProject($project);

  }

  public function getAllListProject(int $limit, int $offset){
    return $this->store->getAllProject($limit, $offset);
  }

  public function getOneProject(String $projectID){
    return $this->store->getAProject($projectID);
  }

  public function updateAProject(Project $project){
    if($project->getName() == ""){
      throw new Exception("Project name cannot be blank", 400);
    }

    if($project->getColor() < 0 && $project->getColor()>36){
      throw new Exception("Color must be 0 to 35", 400);
    }

    $this->store->updateAProject($project);
    
  }
  public function deleteAProject(Project $project){
    return $this->store->deleteAProject($project);
  }

  public function GetProjectOfUser($workspace_id, $user_id){
    return $this->store->getProjectOfUser($workspace_id, $user_id);
  }
  
  public function getUserOfProject(String $project_id,int $limit, int $offset):array{
    return $this->store->getUserOfProject($project_id, $limit, $offset);
  }

  public function getHistoryMember($project_id):array{
    return $this->store->getHistoryMember($project_id);
  }
  
}
