<?php

namespace Storage;
use Entity\Attachment;
use Exception;
use PDO;
use PDOException;

class AttachmentStorage implements IAttachmentStorage{
  private PDOManager $db;

  public function __construct(PDOManager $db = null){

    if(isset($db)){
      $this->db = $db;
    }else{
      $this->db = new PDOManager(null);
    }

  }
  public function InsertAttachment(Attachment $attachment): void{
    try {
       $query = 'INSERT INTO attachments (attachment_id, attachment_url, title, project_id) VALUES (?,?,?,?);';
       $stmt = $this->db->getConn()->prepare($query);
       $stmt->bindValue(1, $attachment->getAttachmentId(), PDO::PARAM_STR);
       $stmt->bindValue(2, $attachment->getAttachmentUrl(), PDO::PARAM_STR);
       $stmt->bindValue(3, $attachment->getTitle(), PDO::PARAM_STR);
       $stmt->bindValue(4, $attachment->getProjectId(), PDO::PARAM_STR);
       $stmt->execute();

    }catch(Exception $e){
       throw new Exception($e->getMessage(), 500);

    }
  }
  public function updateAttachment(String $attachmentId ,String $title): void{
    try{
        $query = 'UPDATE attachments SET title = ? WHERE attachment_id = ?';
        $stmt = $this->db->getConn()->prepare($query);
        $stmt->execute([ $title, $attachmentId]);
        $result = $stmt->rowCount();
        if ($result ==0)
        {
          throw new Exception ("No attachment Found",404);
        }

    }catch(PDOException $e){
        throw new Exception($e->getMessage(), 500);
    }
  }
public function deleteAttachment(String $attachmentId){
  try{
    $query = 'DELETE FROM attachments WHERE attachment_id = ?;';

    $stmt = $this->db->getConn()->prepare($query);
    $stmt->bindValue(1, $attachmentId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->rowCount();
    if($result == 0){
      throw new Exception("not found", 404);
    }
  }catch(PDOException $e){
    throw new Exception($e->getMessage(), 500);
  }
}
}