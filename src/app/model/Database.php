<?php
class Database {
  //
  // Properties
  //
  private $serverName = "localhost";
  private $userName = "root";
  private $password = "";
  private $dbName = "TurboMailDB";
  private $connection;


  //
  // Methods
  //

  /**
   * Function to connect to the server
   */
  function connectToServer() {
    try {
      $this->connection = new PDO("mysql:host=$this->serverName", $this->userName, $this->password);

      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";

    } catch(PDOException $e) {
      echo "Connection failed : " . $e->getMessage();
    }
  }

  /**
   * Function to connect to TurboMail's database
   */
  public function connectToTMDB() {
    try {
      $this->connection = new PDO("mysql:host=$this->serverName; $this->dbName", $this->userName, $this->password);

      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";

    } catch(PDOException $e) {
      echo "Connection failed : " . $e->getMessage();
    }
  }

  /**
   * Function to create the database : TurboMailDB
   * Execute a sql file
   */
  public function createDatabase() {
    try {
      $this->connectToServer();

      if($this->connection) {
        $query = file_get_contents("createDatabase.sql");
        $this->connection->exec($query);
      }
    } catch(PDOException $e) {
      echo "Creation failed" . $e->getMessage();
    }
    
    $this->disconnectFromDB($this->connection);
  }

  /**
   * Function to disconnect from the database
   */
  public function disconnectFromDB() {
    $this->connection = null;
  }

  /**
   * Function to execute a query
   */
  public function execQuery($query) {
    try {
      $this->connectToTMDB();

      if($this->connection) {
        $this->connection->exec($query);
      }
    } catch(PDOException $e) {
      echo $query . "<br>" . $e->getMessage();
    }

    $this->disconnectFromDB();
  }
}
?>