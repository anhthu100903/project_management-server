<?php

namespace Storage;

use Psr\Http\Message\ServerRequestInterface as Request;
use Entity\Project;


interface IProjectStorage
{
  public function insertAProject(Project $project);
  public function updateAProject(Project $project);
  public function deleteAProject(Project $project);
  public function getAProject(String $projectID): Project;
  public function getAllProject(Int $limit, int $offset): array;
  public function getProjectOfUser(String $workspace_id, String $user_id): array;
  public function getUserOfProject(String $project_id, int $limit, int $offset): array;
  public function getHistoryMember(String $project_id): array;
}
