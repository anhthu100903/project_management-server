<?php
namespace Entity;

use JsonSerializable; 
use DateTime;

class Project implements JsonSerializable {
    private ?string $projectID;
    private ?string $name;
    private ?string $description;
    private ?string $ownerID;
    private ?DateTime $createAt;
    private ?int $color; 
    private ?DateTime $dueDate;
    private ?string $status;

    public function __construct(
        ?string $projectID = null,
        ?string $name = null,
        ?string $description = null,
        ?string $ownerID = null,
        ?DateTime $createAt = null,
        ?int $color = null,
        ?DateTime $dueDate = null,
        ?string $status = null
    ) {
        $this->projectID = $projectID;
        $this->name = $name;
        $this->description = $description;
        $this->ownerID = $ownerID;
        $this->createAt = $createAt;
        $this->color = $color;
        $this->dueDate = $dueDate;
        $this->status = $status;
    }

    public function jsonSerialize(): mixed {
        return [
            'project_id' => $this->projectID,
            'name' => $this->name,
            'description' => $this->description,
            'create_at' => $this->createAt ? $this->createAt->format('Y-m-d H:i:s') : null,
            'color' => $this->color,
            'due_date' => $this->dueDate ? $this->dueDate->format('Y-m-d H:i:s') : null,
            'status' => $this->status,
        ];
    }

    // Getter and setter for projectID
    public function getProjectID(): ?string {
        return $this->projectID;
    }

    public function setProjectID(?string $projectID): void {
        $this->projectID = $projectID;
    }

    // Getter and setter for name
    public function getName(): ?string {
        return $this->name;
    }

    public function setName(?string $name): void {
        $this->name = $name;
    }

    // Getter and setter for description
    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(?string $description): void {
        $this->description = $description;
    }

    // Getter and setter for ownerID
    public function getOwnerID(): ?string {
        return $this->ownerID;
    }

    public function setOwnerID(?string $ownerID): void {
        $this->ownerID = $ownerID;
    }

    // Getter and setter for createAt
    public function getCreateAt(): ?DateTime {
        return $this->createAt;
    }

    public function setCreateAt(?DateTime $createAt): void {
        $this->createAt = $createAt;
    }

    // Getter and setter for color
    public function getColor(): ?int {
        return $this->color;
    }

    public function setColor(?int $color): void {
        $this->color = $color;
    }

    // Getter and setter for dueDate
    public function getDueDate(): ?DateTime {
        return $this->dueDate;
    }

    public function setDueDate(?DateTime $dueDate): void {
        $this->dueDate = $dueDate;
    }

    // Getter and setter for status
    public function getStatus(): ?string {
        return $this->status;
    }

    public function setStatus(?string $status): void {
        $this->status = $status;
    }
}
?>
