<?php

class Database {
  
  /**************/
  /* Properties */
  /**************/
  private $serverName = "localhost";
  private $userName = "root";
  private $password = "";
  private $dbName = "TurboMailDB";
  private $connection;

  /***************/
  /*   Methods   */
  /***************/
  public function __construct() {
    $this->createDatabase();
  }

  /**
   * Function to connect to the server
   * @return void
   */
  public function connectToServer(): void {
    // Create connection
    $this->connection = new mysqli($this->serverName, $this->userName, $this->password);

    // Check connection
    if($this->connection->connect_error) {
      die("Connection failed: " . $this->connection->connect_error);
    }
  }

  /**
   * Function to connect to TurboMail's database
   * @return void
   */
  public function connectToTMDB(): void {
    // Create connection
    $this->connection = new mysqli($this->serverName, $this->userName, $this->password, $this->dbName);

    // Check connection
    if($this->connection->connect_error) {
      die("Connection failed: " . $this->connection->connect_error);
    }
  }

  /**
   * Function to disconnect from the database
   * @return void
   */
  public function disconnect(): void {
    $this->connection->close();
  }

  /**
   * Function to create the database : TurboMailDB
   * Execute a sql file
   * @return void
   */
  public function createDatabase(): void {
    // Connect to the server
    $this->connectToServer();

    // Execute SQL file to create the database
    $queries = file_get_contents("createDatabase.sql");
    mysqli_multi_query($this->connection, $queries);

    // Disconnect from DB
    $this->disconnect();
  }

  /**
   * Function to execute a query based on : SELECT selection FROM table WHERE condition
   * @param mixed $selection Selection of the query
   * @param mixed $table Table where the query will be executed 
   * @param mixed $condition Condition for select datas
   * @return string Result of the query
   */
  public function execStandardQuery($selection, $table, $condition): string {
    $this->connectToTMDB();
    if($this->connection) {
      $result = $this->connection->query("SELECT " . $selection . " FROM " . $table . " WHERE " . $condition . ";");
    }
    $this->disconnect();

    return $result;
  }

  /**
   * Function to execute a query
   * @param mixed $query Query which will be executed
   * @return string Result of the query
   */
  public function execQuery($query): string {
    $this->connectToTMDB();
    if($this->connection) {
      $result = $this->connection->query($query);
    }
    $this->disconnect();

    return $result;
  }
}

?>
