<?php
class database {
  // Properties
  private $serverName = "localhost";
  private $userName = "root";
  private $password = "";
  private $dbName = "TurboMailDB";


  // Methods

  /* Connect to PhpMyAdmin */
  function connectToPhpMyAdmin() {
    try {
      // Create connection
      $connection = new PDO("mysql:host=$this->serverName", $this->userName, $this->password);

      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";

    } catch(PDOException $e) {
      echo "Connection failed : " . $e->getMessage();
    }
    return $connection;
  }

  /* Connect to PhpMyAdmin */
  function connectToTMDB() {
    try {
      // Create connection
      $connection = new PDO("mysql:host=$this->serverName; $this->dbName", $this->userName, $this->password);

      $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";

    } catch(PDOException $e) {
      echo "Connection failed : " . $e->getMessage();
    }
    return $connection;
  }

  /* Create the TurboMail's database */
  function createDatabase() {
    try {
      // Connect to PhpMyAdmin
      $connection = $this->connectToPhpMyAdmin();

      if($connection) {
        $query = file_get_contents("createDatabase.sql");
        $connection->exec($query);
      }
    } catch(PDOException $e) {
      echo "Creation failed" . $e->getMessage();
    }
    
    $this->disconnectFromDB($connection);
  }

  /* Disconnect from PhpMyAdmin */
  function disconnectFromDB($connection) {
    $connection = null;
  }

  /* Execute one query */
  function execQuery($query) {
    try {
      $connection = $this->connectToTMDB();

      if($connection) {
        $connection->exec($query);
      }
    } catch(PDOException $e) {
      echo $query . "<br>" . $e->getMessage();
    }

    $this->disconnectFromDB($connection);
  }
}

?>