<?php

class Database {
  /* 
  /* Properties
  */
  private $serverName = "localhost";
  private $userName = "root";
  private $password = "";
  private $dbName = "TurboMailDB";
  private $connection;

  //
  // Constructor
  //
  public function __construct() {
    $this->createDatabase();
  }

  /*
  /* Methods
  /*

  /**
   * Function to connect to the server
   * @return void
   */
  public function connectToServer(): void {
    try {
      $this->connection = new PDO("mysql:host=$this->serverName", $this->userName, $this->password);

      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected to Server";

    } catch(PDOException $e) {
      echo "Connection failed : " . $e->getMessage();
    }
  }

  /**
   * Function to connect to TurboMail's database
   * @return void
   */
  public function connectToTMDB(): void {
    try {
      $this->connection = new PDO("mysql:host=$this->serverName; $this->dbName", $this->userName, $this->password);
      echo "Connected to TMDB";

      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch(PDOException $e) {
      echo "Connection failed : " . $e->getMessage();
    }
  }

  /**
   * Function to create the database : TurboMailDB
   * Execute a sql file
   * @return void
   */
  public function createDatabase(): void {
    echo "Creation";
    try {
      $this->connectToServer();

      if($this->connection) {
        $query = file_get_contents("createDatabase.sql");
        $this->connection->exec($query);
      }

      echo "Created successfully";
    } catch(PDOException $e) {
      echo "Creation failed" . $e->getMessage();
    }
    
    $this->disconnectFromDB($this->connection);
  }

  /**
   * Function to disconnect from the database
   * @return void
   */
  public function disconnectFromDB(): void {
    $this->connection = null;
  }

  /**
   * Function to execute a query
   * @param mixed $query
   * @return void
   */
  public function execQuery($query): void {
    $use = "USE ".$this->dbName.";";

    try {
      $this->connectToTMDB();

      if($this->connection) {
        $this->connection->exec($use.$query);
      }
    } catch(PDOException $e) {
      echo $query . "<br>" . $e->getMessage();
    }

    $this->disconnectFromDB();
  }
}

echo "Print";

?>
