<?php
namespace Entity;

use JsonSerializable; 

class UserAccount implements JsonSerializable {
  private ?string $userID;
  private ?string $email;
  private ?string $password;

  public function __construct(string $userID = null, string $email = null, string $password = null) {
      $this->userID = $userID;
      $this->email = $email;
      $this->password = $password;
  }

  // Getters
  public function getUserID(): ?string {
      return $this->userID;
  }

  public function getEmail(): ?string {
      return $this->email;
  }

  public function getPassword(): ?string {
      return $this->password;
  }

  // Setters
  public function setUserID(?string $userID): void {
      $this->userID = $userID;
  }

  public function setEmail(?string $email): void {
      $this->email = $email;
  }

  public function setPassword(?string $password): void {
      $this->password = $password;
  }

  // JsonSerializable implementation
  public function jsonSerialize() {
      return array(
        'user_id' => $this->userID,
          'email' => $this->email,
          'password' => $this->password
      );
  }
}