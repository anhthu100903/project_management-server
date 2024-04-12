<?php
namespace Entity;

use JsonSerializable;

class Workspace implements JsonSerializable {
    private ?String $id;
    private ?String $name;
    private ?int $defaultWorkspace;

    public function __construct(?String $id = null, ?String $name = null, ?int $a = null) {
        $this->id = $id;
        $this->name = $name;
        $this->defaultWorkspace = $a;
    }

    public function getId(): ?String {
        return $this->id;
    }

    public function setId(?String $id): void {
        $this->id = $id;
    }

    public function getName(): ?String {
        return $this->name;
    }

    public function setName(?String $name): void {
        $this->name = $name;
    }

    public function getDefaultWorkspace():?int{
        return $this->defaultWorkspace;
    }

    public function setDefaultWorkspace(?int $defaultWordspace){
        $this->defaultWorkspace = $defaultWordspace;
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'default_workspace'=>$this->defaultWorkspace
        ];
    }
}
