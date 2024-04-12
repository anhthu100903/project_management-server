<?php
namespace Entity;
use JsonSerializable;

class TaskField implements JsonSerializable {
  private ?String $id;
  private ?String $title;
  private ?String $projectID;
  private ?int $type;

  // Constructor
  public function __construct(string $id, string $title, string $projectID, ?int $type) {
      $this->id = $id;
      $this->title = $title;
      $this->projectID = $projectID;
      $this->type = $type;
  }

  // Getter for id
  public function getId(): string {
      return $this->id;
  }

  // Setter for id
  public function setId(string $id): void {
      $this->id = $id;
  }

  // Getter for title
  public function getTitle(): string {
      return $this->title;
  }

  // Setter for title
  public function setTitle(string $title): void {
      $this->title = $title;
  }

  // Getter for projectID
  public function getProjectID(): string {
      return $this->projectID;
  }

  // Setter for projectID
  public function setProjectID(string $projectID): void {
      $this->projectID = $projectID;
  }

  // Getter for type
  public function getType(): int {
      return $this->type;
  }

  // Setter for type
  public function setType(int $type): void {
      $this->type = $type;
  }

  // Implementing JsonSerializable interface
  public function jsonSerialize() {
      return [
          'id' => $this->id,
          'title' => $this->title,
          'projectID' => $this->projectID,
          'type' => $this->type
      ];
  }
}
