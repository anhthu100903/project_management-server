<?php
namespace Entity;

use JsonSerializable; 

class Attachment implements JsonSerializable{

  private ?String $attachmentId;
  private ?String $attachment_url;
  private ?String $title;
  private ?String $project_id;
 

  public function __construct($attachment_id = null, $attachment_url = null, $title = null, $project_id = null){
    $this->attachmentId = $attachment_id;
    $this->attachment_url = $attachment_url;
    $this->title = $title;
    $this->project_id = $project_id;
  }

  public function jsonSerialize(): mixed
  {
    return array(
      'attachment_id' => $this->attachmentId,
      'attachment_url' => $this->attachment_url,
      'title' => $this->title,
      'project_id' => $this->project_id
    );
  }

  public function getAttachmentId(): string {
      return $this->attachmentId;
  }

  public function setAttachmentId(string $attachmentId): void {
      $this->attachmentId = $attachmentId;
  }

  public function getAttachmentUrl(): ?string {
      return $this->attachment_url;
  }

  public function setAttachmentUrl(string $attachment_url): void {
      $this->attachment_url = $attachment_url;
  }

  public function getTitle(): ?string {
      return $this->title;
  }

  public function setTitle(string $title): void {
      $this->title = $title;
  }

  public function getProjectId(): string {
      return $this->project_id;
  }

  public function setProjectId(string $project_id): void {
      $this->project_id = $project_id;
  }

}
