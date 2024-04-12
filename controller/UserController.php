<?php

namespace Controller;

use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Service\UserService;

class UserController{
  private UserService $service;

  public function __construct(UserService $service)
  {
    $this->service = $service;
  }

  public function GetAnUser(Request $req, Response $res){
    try{
      $user_id = $req->getAttribute('user_id');
      $userInformation = $this->service->getAnUser($user_id);
      $res = $res->withStatus(200);

      $res->getBody()->write(json_encode($userInformation));

    }catch(Exception $e){
      if($e->getCode() == 404){
        $res = $res->withStatus(404);
        $res->getBody()->write($e->getMessage());
      }else{
        $res = $res->withStatus(500);
      $res->getBody()->write($e->getMessage());
    }
    }finally{
      return $res;
    }
  }
}