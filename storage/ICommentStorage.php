<?php
namespace Storage;

use Entity\Comment;

interface ICommentStorage{
  public function updateComment(Comment $comment):void;
  public function deleteComment(String $id):void;
  public function getCommentOfTask(String $taskID):array;
}
?>