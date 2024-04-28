<?php
require_once 'connect-db.php';
require_once 'Database.php';

class Database
{

   private $dbConnector;

   public function __construct()
   {

      $username = Config::$db["username"];
      $password = Config::$db["password"];
      $host = Config::$db["host"];
      $database = Config::$db["database"];
      $dsn = "mysql:host=$host;dbname=$database";

      try {
         //  $db = new PDO("mysql:host=$hostname;dbname=db-demo", $username, $password);
        // $db = new PDO($dsn, $username, $password);
         $this->dbConnector = new PDO($dsn, $username, $password);
         // dispaly a message to let us know that we are connected to the database 
         // echo "<p>You are connected to the database -- host=$host</p>";
      } catch (PDOException $e)     // handle a PDO exception (errors thrown by the PDO library)
      {
         // Call a method from any object, use the object's name followed by -> and then method's name
         // All exception objects provide a getMessage() method that returns the error message 
         $error_message = $e->getMessage();
         echo "<p>An error occurred while connecting to the database: $error_message </p>";
      } catch (Exception $e)       // handle any type of exception
      {
         $error_message = $e->getMessage();
         echo "<p>Error message: $error_message </p>";
      }
      $this->createUserTable();
   }

   public function getConnector()
   {
      return $this->dbConnector;
   }

   private function createUserTable()
   {
      $createQuery = "
       CREATE TABLE IF NOT EXISTS `User` (
           user_id INT NOT NULL, 
           user_password VARCHAR(255), 
           profile_picture TEXT, 
           first_name VARCHAR(255), 
           last_name VARCHAR(255), 
           PRIMARY KEY (user_id)
       );
   ";
      try {
         $this->dbConnector->exec($createQuery);
      } catch (PDOException $e) {
         error_log('Failed to create table: ' . $e->getMessage());
         throw new Exception('Failed to create table: ' . $e->getMessage());
      }
   }

}
