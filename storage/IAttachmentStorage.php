<?php

namespace Storage;
use Entity\Attachment;

interface IAttachmentStorage{
    public function InsertAttachment(Attachment $attachment): void;
    public function updateAttachment(String $attachmentId ,String $title): void;
    public function deleteAttachment(String $attachmentId);

}