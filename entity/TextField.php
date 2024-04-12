<?php

class TextField implements JsonSerializable {
    private string $taskID;
    private string $taskFieldID;
    private string $content;

    // Constructor
    public function __construct(string $taskID, string $taskFieldID, string $content) {
        $this->taskID = $taskID;
        $this->taskFieldID = $taskFieldID;
        $this->content = $content;
    }

    // Getter và Setter cho taskID
    public function getTaskID(): string {
        return $this->taskID;
    }

    public function setTaskID(string $taskID): void {
        $this->taskID = $taskID;
    }

    // Getter và Setter cho taskFieldID
    public function getTaskFieldID(): string {
        return $this->taskFieldID;
    }

    public function setTaskFieldID(string $taskFieldID): void {
        $this->taskFieldID = $taskFieldID;
    }

    // Getter và Setter cho content
    public function getContent(): string {
        return $this->content;
    }

    public function setContent(string $content): void {
        $this->content = $content;
    }

    // Phương thức của JsonSerializable interface để chuyển đổi object thành mảng khi serialize
    public function jsonSerialize() {
        return [
            'taskID' => $this->taskID,
            'taskFieldID' => $this->taskFieldID,
            'content' => $this->content
        ];
    }
}
?>
