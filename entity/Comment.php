<?php
namespace Entity;

use JsonSerializable;
use DateTime; 
  class Comment implements JsonSerializable{
    private ?String $commentID;
    private ?String $userID;
    private ?String $taskID;
    private ?String $content;
    private ?DateTime $createAt;
    
    public function __construct(?string $commentID = null, ?string $userID = null, ?string $taskID = null, ?string $content = null, ?DateTime $createAt = null)
    {
      $this->commentID = $commentID;
      $this->userID = $userID;
      $this->taskID = $taskID;
      $this->content = $content;
      $this->createAt = $createAt;

    }
    public function jsonSerialize(): mixed
    {
      return array(
        'comment_id' => $this->commentID,
        'user_id' => $this->userID,
        'task_id' => $this->taskID,
        'content' => $this->content,
        'create_at' => $this->createAt
      );
    }

    public function toArray():array
    {
      return [$this->commentID, $this->userID, $this->taskID, $this->content, $this->createAt->format('Y-m-d H:i:s')];
    }

    public function getCommentID(): ?string
    {
      return $this->commentID;
    }
    public function getUserID(): ?string
    {
      return $this->userID;
    }
    public function getTaskID(): ?string
    {
      return $this->taskID;
    }
    public function getContent(): ?string
    {
      return $this->content;
    }
    public function getCreateAt(): ?DateTime
    {
      return $this->createAt;
    }

    public function setCommentID(?string $commentID): void
    {
      $this->commentID = $commentID;
    }
    public function setUserID(?string $userID): void
    {
      $this->userID = $userID;
    }
    public function setTaskID(?string $taskID): void
    {
      $this->taskID = $taskID;
    }
    public function setContent(?string $content): void
    {
      $this->content = $content;
    }
    public function setCreateAt(?string $createAt): void
    {
      $this->createAt = $createAt;
    }
  }
?>