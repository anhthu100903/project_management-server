<?php

namespace Controller;

use Entity\Attachment;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Service\AttachmentService;
use Exception;
use Ramsey\Uuid\Nonstandard\Uuid;

class AttachmentController{
  private AttachmentService $service;
  public function __construct(AttachmentService $service)
  {
    $this->service = $service;
  }

  public function InsertAttachment(Request $req, Response $res){
    $body = $req->getBody()->getContents();
      $data = json_decode($body);
      if(!isset($data->title)) {
        $data->title = null;
      }
      if(!isset($data->attachment_url)) {
        $data->attachment_url = null;
      }
      if(!isset($data->project_id)) {
        $res = $res->withStatus(400);
        $res->getBody()->write("Project id is required");
        return $res;
      }
      if (!isset($data->attachment_id)) {
        $res = $res->withStatus(400);
        $res->getBody()->write("Attachment id is required");
        return $res;
      }
      
      $attachment = new Attachment($data->attachment_id, $data->attachment_url, $data->title, $data->project_id);
      try{
        $this->service->InsertAttachment($attachment);
        $res = $res->withStatus(200);
        $res->getBody()->write(json_encode(
        array("message" => "create successfully",
        "attachment" => $attachment
        )
      ));
      return $res;
    } catch(Exception $e){
      if($e->getCode() == 404){
        $res = $res->withStatus(400);
        $res->getBody()->write($e->getMessage());
      }else{
        $res = $res->withStatus(500);
        $res->getBody()->write($e->getMessage());
      }
      return $res;
    }
  }
  public function updateAttachment(Request $req, Response $res){
    try{
    $requestBody = $req->getBody()->getContents();
    $requestBody = json_decode($requestBody, true);
    if (isset($requestBody['title'])) {
      $title = $requestBody['title'];
    } else {
      $title = null;
    }
    // $title = $requestBody['title'];
   
    $attachmentId = $req->getAttribute('attchment_id');
   

    $this->service->updateAttachment($attachmentId,$title);
    $res = $res->withStatus(200);
    $res->getBody()->write(json_encode(array("update successfully",
      "attachment_id" => $attachmentId,
      "title" => $title
    )
  ));
    return $res;
  }catch(Exception $e){
    if($e->getCode() == 400){
      $res = $res->withStatus(400);
      $res->getBody()->write($e->getMessage());
    }else{
      $res = $res->withStatus(500);
      $res->getBody()->write($e->getMessage());
    }
    return $res;
  }
}
public function deleteAttachment(Request $req, Response $res){
  $attachmentId = $req->getAttribute('attchment_id');

  try {
    $this->service->deleteAttachment($attachmentId);
    $res = $res->withStatus(200);
    $res->getBody()->write(json_encode(
      array(
        "message" => "Delete successfully"
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
}
?>