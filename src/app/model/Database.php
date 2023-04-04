<?php
class Database {
  // Properties
  private $serverName = "localhost";
  private $userName = "root";
  private $password = "";
  private $dbName = "TurboMailDB";
  private $connection;


  // Methods

  /* Connect to PhpMyAdmin */
  function connectToServer() {
    try {
      // Create connection
      $this->connection = new PDO("mysql:host=$this->serverName", $this->userName, $this->password);

      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";

    } catch(PDOException $e) {
      echo "Connection failed : " . $e->getMessage();
    }
  }

  /* Connect to TurboMail */
  public function connectToTMDB() {
    try {
      // Create connection
      $this->connection = new PDO("mysql:host=$this->serverName; $this->dbName", $this->userName, $this->password);

      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";

    } catch(PDOException $e) {
      echo "Connection failed : " . $e->getMessage();
    }
  }

  /* Create the TurboMail's database */
  public function createDatabase() {
    try {
      // Connect to PhpMyAdmin
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

  /* Disconnect from Database */
  public function disconnectFromDB() {
    $this->connection = null;
  }

  /* Execute one query */
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