<?php

namespace Storage;

use FastRoute\DataGenerator;
use Prs\Http\ServerRequestInterface as Request;

use PDO;
use PDOException;
use Exception;
use DateTime;
use Entity\Comment;

class CommentStorage implements ICommentStorage
{
  private PDOManager $db;
  public function __construct(PDOManager $db = null)
  {
    if (isset($db)) {
      $this->db = $db;
    } else {
      $this->db = new PDOManager(null);
    }
  }

  public function updateComment(Comment $comment): void
  {
    try 
    {
      $dateTimeObject = ($comment->getCreateAt() !== null) ? $comment->getCreateAt() : null;

      $query = "UPDATE comments SET user_id=?, task_id=?, content=?, create_at=? WHERE comment_id=?";
      $stmt = $this->db->getConn()->prepare($query);
      $stmt->bindValue(1, $comment->getUserID(), PDO::PARAM_STR);
      $stmt->bindValue(2, $comment->getTaskID(), PDO::PARAM_STR);
      $stmt->bindValue(3, $comment->getContent(), PDO::PARAM_STR);
      $stmt->bindValue(4, $dateTimeObject, PDO::PARAM_STR);
      $stmt->bindValue(5, $comment->getCommentID(), PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() == 0) 
      {
        throw new Exception("CommentID not found", 404);
      }
    } catch (Exception $e) 
    {
      if ($e->getCode() == 404)
      {
        throw new Exception($e->getMessage(), 404);
      } 
      else throw new Exception($e->getMessage(), 500);
    }
  }

  public function deleteComment(String $id): void
  {
    try 
    {
      $query = "DELETE FROM `comments` WHERE comment_id = ?";
      $stmt = $this->db->getConn()->prepare($query);
      $stmt->execute([$id]);
      if ($stmt->rowCount() == 0) 
      {
        throw new Exception("CommentID not found", 404);
      }
    } catch (Exception $e) 
    {
      if ($e->getCode() == 404) 
      {
        throw new Exception($e->getMessage(), 404);
      } 
      else throw new Exception($e->getMessage(), 404);
    }
  }

  public function getCommentOfTask(String $taskID):array
  {
    try 
    {
      $query = "SELECT * FROM `comments` WHERE task_id = ?";
      $stmt = $this->db->getConn()->prepare($query);
      $stmt->execute([$taskID]);
      if ($stmt->rowCount() == 0) 
      {
        throw new Exception("Comment of Task was not found", 404);
      }
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $comments = array();
      foreach($result as $row){
        $dateTimeObject = ($row['create_at'] !== null) ? DateTime::createFromFormat('Y-m-d H:i:s', $row['create_at']) : null;
        $comment = new Comment($row['comment_id'], $row['user_id'], $row['task_id'], $row['content'], );
        $comments[] = $comment;
      }
      return $comments;
    } catch (Exception $e) 
    {
      if ($e->getCode() == 404) 
      {
        throw new Exception($e->getMessage(), 404);
      } 
      else throw new Exception($e->getMessage(), 500);
    }
  }
}