<?php
namespace Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Ramsey\Uuid\Uuid;
use Exception;
use DateTime;
use Service\CommentService;
use Entity\Comment;

class CommentController{
  private CommentService $service;

  public function __construct(CommentService $service)
  {
    $this->service = $service;
  }

  public function updateComment(Request $req, Response $res){
    $body = $req->getBody()->getContents();
    $data = json_decode($body);
    if(!isset($data->comment_id)){
      $res = $res->withStatus(400);
      $res->getBody()->write("CommentID is required");
      return $res;
    }
    if(!isset($data->create_at)){
      $data->create_at = null;
    }
    if(!isset($data->user_id)){
      $data->user_id = null;
    }
    if(!isset($data->task_id)){
      $data->task_id = null;
    }
    if(!isset($data->content)){
      $data->content = null;
    }

    $dateTimeObject = ($data->create_at !== null) ? DateTime::createFromFormat('Y-m-d H:i:s', $data->create_at) : null;
    $comment = new Comment($data->comment_id, $data->user_id, $data->task_id, $data->content, $dateTimeObject);

    try{
      $this->service->updateComment($comment);
      $res = $res->withStatus(200);
      $res->getBody()->write(json_encode(
        array(
          "message" => "Update successfully",
          "comment" => $comment)
      ));

    }catch (Exception $e){
      if ($e->getCode() == 400) {
        $res = $res->withStatus(400);
      } 
      else if ($e->getCode() == 404) {
        $res = $res->withStatus(404);
      }else {
          $res = $res->withStatus(500);
      }
      $res->getBody()->write($e->getMessage());
    }
    return $res;
  }

  public function deleteComment(Request $req, Response $res){
    try{
      $this->service->deleteComment($req->getAttribute("comment_id"));
      $res = $res->withStatus(200);
      $res->getBody()->write(json_encode(
        array("message"=>"delete successfully")
      ));
    }catch(Exception $e){
      if($e->getCode()==404){
        $res=$res->withStatus(404);
      }else $res=$res->withStatus(500);
      $res->getBody()->write($e->getMessage());
    }
    return $res;
  }

  public function getCommentOfComment(Request $req, Response $res){
    try
    {
      $comment = $this->service->getCommentOfTask($req->getAttribute("task_id"));
      $res = $res->withStatus(200);
      $res->getBody()->write(json_encode(
        array("message"=>"delete successfully", "comments"=>$comment)
      ));
    }catch(Exception $e)
    {
      if($e->getCode()==404)
      {
        $res=$res->withStatus(404);
      }
      else $res=$res->withStatus(500);
      $res->getBody()->write($e->getMessage());
    }
    return $res;
  }
}
?>