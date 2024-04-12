<?php
namespace Storage;

use Exception;
use PDO;
use PDOException;

class PDOManager
{
  private ?PDO $conn;

  public function getConn():PDO{
      if($this->conn == null){
        throw new Exception("Cannot connect to database", 500);
      }
      return $this->conn;
  }

  public function __construct($conn = null)
  {
    if ($conn === null) {
      // Tạo kết nối nếu không được cung cấp
      try {
         $servername = "172.17.0.1";
        $username = "root";
        $password = "qwerty..";
        $this->conn = new PDO("mysql:host=$servername;port=3306;dbname=project_management", $username, $password);
        
        // set the PDO error mode to exception
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        $this->conn = null;
      }
    } else {
      // Sử dụng kết nối được cung cấp
      $this->conn = $conn;
    }
  }
}
