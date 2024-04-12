<?php
namespace Entity;

use DateTime;
use JsonSerializable;

class ProjectHistory implements JsonSerializable {
    private ?String $id;
    private ?String $project_id;
    private ?UserInformation $user;
    private ?String $type;
    private ?String $status;
    private ?DateTime $create_at;

    public function __construct(
        ?String $id,
        ?String $project_id,
        ?UserInformation $user,
        ?String $type,
        ?String $status,
        ?DateTime $create_at
    ) {
        $this->id = $id;
        $this->project_id = $project_id;
        $this->user = $user;
        $this->status = $status;
        $this->create_at = $create_at;
        $this->type = $type;
    }

    // Getter methods
    public function getId(): ?String {
        return $this->id;
    }

    public function getProjectId(): ?String {
        return $this->project_id;
    }

    public function getUserId(): ?UserInformation {
        return $this->user;
    }


    public function getType(): ?String {
        return $this->type;
    }

    public function getStatus(): ?String {
        return $this->status;
    }

    public function getCreateAt(): ?DateTime {
        return $this->create_at;
    }

    // Setter methods
    public function setId(?String $id): void {
        $this->id = $id;
    }

    public function setProjectId(?String $project_id): void {
        $this->project_id = $project_id;
    }

    public function setUserId(?UserInformation $user): void {
        $this->user = $user;
    }

    public function setType(?String $type): void {
        $this->type = $type;
    }

    public function setStatus(?String $status): void {
        $this->status = $status;
    }

    public function setCreateAt(?DateTime $create_at): void {
        $this->create_at = $create_at;
    }

    // JsonSerializable interface method
    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'user'=>$this->user,
            'type' => $this->type,
            'status' => $this->status,
            'create_at' => $this->create_at->format('Y-m-d H:i:s') // Format datetime as string
        ];
    }
}
?>
