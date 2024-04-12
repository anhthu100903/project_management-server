<?php

namespace Middleware;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Exception;
use Slim\Psr7\Response as Psr7Response;

class EmailVerify
{
  public function __invoke(Request $req, RequestHandler $handler)
  {
    try {
      $email = $req->getAttribute('payload')->email;
      if(!isset($email)){
        $res = new Psr7Response();
        $res = $res->withStatus(401);
        $res->getBody()->write("Token is invalid");
        return $res;
      }
      $body = $req->getBody()->getContents();
      $data = json_decode($body);
      if($email != $data->account->email){
        $res = new Psr7Response();
        $res = $res->withStatus(403);
        return $res;
      }
      $res = $handler->handle($req);
      return $res;
    } catch (Exception $e) {
      $res = new Psr7Response();
        $res = $res->withStatus(500);
        $res->getBody()->write($e->getMessage());
        return $res;
    }
  }
}
