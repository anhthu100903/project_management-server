<?php
namespace Entity;
use JsonSerializable;

class Member implements JsonSerializable {
    private ?string $user_id;
    private ?String $avatar_url;
    private ?string $firstname;
    private ?string $lastname;
    private ?string $email;
    private ?string $role;
    private ?int $color;
    public function __construct(?string $user_id = null, ?string $firstname = null, ?string $lastname = null, ?string $email = null, ?string $role = null, ?string $avatar_url = null, ?int $color = null) {
        $this->user_id = $user_id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->role = $role;
        $this->avatar_url = $avatar_url;
        $this->color = $color;
    }
    public function getProjectId(): ?string {
        return $this->user_id;
    }

    public function setProjectId(?string $user_id): void {
        $this->user_id = $user_id;
    }

    public function getfirstname(): ?string {
        return $this->firstname;
    }

    public function setfirstname(?string $firstname): void {
        $this->firstname = $firstname;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function getlastname(): ?string {
        return $this->lastname;
    }

    public function setlastname(?string $lastname): void {
        $this->lastname = $lastname;
    }

    public function setEmail(?string $email): void {
        $this->email = $email;
    }

    public function getRole(): ?string {
        return $this->role;
    }

    public function setRole(?string $role): void {
        $this->role = $role;
    }

    public function getAvatarUrl(): ?string {
        return $this->avatar_url;
    }

    public function setAvatarUrl(?string $avatar_url): void {
        $this->avatar_url = $avatar_url;
    }
    public function getColor(): ?int {
        return $this->color;
    }

    public function setColor(?int $color): void {
        $this->color = $color;
    }

    // Các phương thức getter và setter cho các thuộc tính khác đã có

    public function jsonSerialize() {
        return [
            'user_id' => $this->user_id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'role' => $this->role,
            'avatar' => $this->avatar_url,
            'color' => $this->color
        ];
    }
}
