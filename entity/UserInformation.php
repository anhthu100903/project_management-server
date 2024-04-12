<?php
namespace Entity;

use JsonSerializable;

class UserInformation implements JsonSerializable {
    private ?string $userID;
    private ?string $firstName;
    private ?string $lastName;
    private ?string $jobTitle;
    private ?string $avatarURL;
    private ?UserAccount $userAccount;
    private ?int $color;

    public function __construct(
        ?string $userID = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $jobTitle = null,
        ?string $avatarURL = null,
        ?UserAccount $userAccount = null,
        ?int $color = null
    ) {
        $this->userID = $userID;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->jobTitle = $jobTitle;
        $this->avatarURL = $avatarURL;
        $this->userAccount = $userAccount;
        $this->color = $color;
    }

    // Getters
    public function getUserID(): ?string {
        return $this->userID;
    }

    public function getFirstName(): ?string {
        return $this->firstName;
    }

    public function getLastName(): ?string {
        return $this->lastName;
    }

    public function getJobTitle(): ?string {
        return $this->jobTitle;
    }

    public function getAvatarURL(): ?string {
        return $this->avatarURL;
    }

    public function getUserAccount(): ?UserAccount {
        return $this->userAccount;
    }

    public function getColor(): ?int {
        return $this->color;
    }

    // Setters
    public function setUserID(?string $userID): void {
        $this->userID = $userID;
    }

    public function setFirstName(?string $firstName): void {
        $this->firstName = $firstName;
    }

    public function setLastName(?string $lastName): void {
        $this->lastName = $lastName;
    }

    public function setJobTitle(?string $jobTitle): void {
        $this->jobTitle = $jobTitle;
    }

    public function setAvatarURL(?string $avatarURL): void {
        $this->avatarURL = $avatarURL;
    }

    public function setUserAccount(?UserAccount $userAccount): void {
        $this->userAccount = $userAccount;
    }

    public function setColor(?int $color): void {
        $this->color = $color;
    }

    // JsonSerializable implementation
    public function jsonSerialize() {
        return [
            'user_id' => $this->userID,
            'firstname' => $this->firstName,
            'lastname' => $this->lastName,
            'job_title' => $this->jobTitle,
            'avatar_url' => $this->avatarURL,
            'user_account' => $this->userAccount,
            'color' => $this->color
        ];
    }
}
