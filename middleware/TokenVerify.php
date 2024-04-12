<?php

namespace Middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Exception;
use Slim\Psr7\Response as Psr7Response;

class TokenVerify{

  public function __invoke(Request $req, RequestHandler $handler){
    $authorization = $req->getHeaderLine('Authorization');
    if(empty($authorization)){
      $res = new Psr7Response();
      $res = $res->withStatus(401);
      $res->getBody()->write("Unauthorized");
      return $res;
    }

    $token = explode(" ", $authorization);
    $secret_key = "L939sdj9-jejjdej-j3j3";

    try{
      $payload = JWT::decode($token[1], new Key($secret_key,'HS256'));
      $req = $req->withAttribute('payload',$payload);
      $res = $handler->handle($req);
      return $res;
    }catch(Exception $e){
      $res = new Psr7Response();
      $res = $res->withStatus(401);
      $res->getBody()->write($e->getMessage());
      return $res;
    }

  }
}