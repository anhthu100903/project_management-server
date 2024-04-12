<?php
namespace Storage;

use Entity\Workspace;
use Entity\WorkspaceMemberships;

interface IWorkspaceStorage{
  public function insertWorkspace(Workspace $workspace):void;
  public function updateWorkspace(Workspace $workspace):void;
  public function deleteWorkspace(String $id):void;
  public function getWorkspacesOfUser(String $user_id):array;
  public function getDefaultWorkspaceOfUser(String $user_id):Workspace;
  public function getUserOfWorkspace(String $workspace_id):array;
}