<?php

namespace Controller;

use Entity\UserAccount;
use Entity\UserInformation;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Service\AccountService;
use Exception;
use Firebase\JWT\JWT;
use Ramsey\Uuid\Uuid;
use Slim\Psr7\Message;

class AccountController
{
  private AccountService $service;

  public function __construct(AccountService $service)
  {
    $this->service = $service;
  }

  public function Login(Request $req, Response $res)
  {
    $body = $req->getBody()->getContents();
    $data = json_decode($body);
    $email = $data->email;
    $password = $data->password;
    if (!isset($email)) {
      $res = $res->withStatus(400);
      $res->getBody()->write("Email is required");
      return $res;
    }
    if (!isset($password)) {
      $res = $res->withStatus(400);
      $res->getBody()->write("Password is requires");
      return $res;
    }

    try {
      $account = $this->service->Login($email, $password);

      $payload = array(
        "user_id" => $account->getUserID(),
        "exp" => time() + 3600
      );

      $jwt = JWT::encode($payload, "jHsie72Jw", 'HS256');
      $res = $res->withStatus(200);
      $res->getBody()->write(json_encode(array(
        "message" => "login successfully",
        "account" => $account,
        "token" => $jwt
      )));
      return $res;
    } catch (Exception $e) {
      if ($e->getCode() == 401) {
        $res = $res->withStatus(401);
        $res->getBody()->write($e->getMessage());
      }
      if ($e->getCode() == 500) {
        $res = $res->withStatus(500);
        $res->getBody()->write($e->getMessage());
      }
      if ($e->getCode() == 404) {
        $res = $res->withStatus(404);
        $res->getBody()->write($e->getMessage());
      }
      return $res;
    }
  }

  public function Register(Request $req, Response $res){
    $body = $req->getBody()->getContents();
    $data = json_decode($body);

    $dataError = false;
    if(!isset($data->firstname)){
      $res->getBody()->write("First name is required\n");
      $dataError = true;
    }

    if(!isset($data->lastname)){
      $res->getBody()->write("Last name is required\n");
      $dataError = true;
    }

    if(!isset($data->account->email)){
      $res->getBody()->write("Email is required\n");
      $dataError = true;
    }

    if(!isset($data->account->password)){
      $res->getBody()->write("Password is required\n");
      $dataError = true;
    }

    if($dataError){
      $res = $res->withStatus(400);
      return $res;
    }
    $id = Uuid::uuid4();
    $user_account = new UserAccount($id, $data->account->email, $data->account->password);
    $user_information = new UserInformation($id, $data->firstname, $data->lastname, null, null, $user_account, rand(0,131));
    try{
      $this->service->Register($user_information);
      $res = $res->withStatus(200);
      $res->getBody()->write(json_encode(array(
        "message"=>"Register successfully",
        "account_information"=> $user_information
      )));
    }catch(Exception $e){
      $res = $res->withStatus($e->getCode());
      $res->getBody()->write($e->getMessage());
    }
    return $res;

  }
}
