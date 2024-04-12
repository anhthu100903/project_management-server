<?php

namespace Service;

use Entity\Workspace;
use Exception;
use Storage\IWorkspaceStorage;

class WorkspaceService{
  private IWorkspaceStorage $store;
  public function __construct(IWorkspaceStorage $store)
  {
    $this->store = $store; 
  }

  public function CreateWorkspace(Workspace $workspace){
    if($workspace->getName() == ""){
      throw new Exception("Name cannot be blank", 400);
    }

    $this->store->insertWorkspace($workspace);
  }

  public function GetWorkspacesOfUser(String $user_id):array{
    return $this->store->getWorkspacesOfUser($user_id);
  }

  public function GetWorkSpaceOfUser(String $user_id):Workspace{
    return $this->store->getDefaultWorkspaceOfUser($user_id);
  }

  public function GetUserOfWorkspace(String $workspace_id):array{
    return $this->store->getUserOfWorkspace($workspace_id);
  }
  
}