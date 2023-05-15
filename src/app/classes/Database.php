<?php

namespace app\classes;

use mysqli;
use mysqli_result;

class Database {

	/**************/
	/* Properties */
	/**************/
	private string $serverName = "localhost";
	private string $userName = "root";
	private string $password = "";
	private string $dbName = "TurboMailDB";
	private mysqli $connection;

	/***************/
	/*   Methods   */
	/***************/
	public function __construct() {
		$this->createDatabase();
	}

	/**
	 * Function to connect to the server
	 *
	 * @return void
	 */
	public function connectToServer(): void {
		// Create connection
		$this->connection = new mysqli($this->serverName, $this->userName,
			$this->password);

		// Check connection
		if ($this->connection->connect_error) {
			die("Connection failed: ".$this->connection->connect_error);
		}
	}

	/**
	 * Function to connect to TurboMail's database
	 *
	 * @return void
	 */
	public function connectToTMDB(): void {
		// Create connection
		$this->connection = new mysqli($this->serverName, $this->userName,
			$this->password, $this->dbName);

		// Check connection
		if ($this->connection->connect_error) {
			die("Connection failed: ".$this->connection->connect_error);
		}
	}

	/**
	 * Function to disconnect from the database
	 *
	 * @return void
	 */
	public function disconnect(): void {
		$this->connection->close();
	}

	/**
	 * Function to create the database : TurboMailDB
	 * Execute a sql file
	 *
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
	 *
	 * @param  mixed  $selection  Selection of the query
	 * @param  mixed  $table  Table where the query will be executed
	 * @param  mixed  $condition  Condition for select data
	 *
	 * @return mysqli_result Result of the query
	 */
	public function execSelectQuery(
		$selection,
		$table,
		$condition
	): mysqli_result {
		$this->connectToTMDB();
//		if ($this->connection) {
		$result = mysqli_query($this->connection,
			"SELECT ".$selection." FROM ".$table." WHERE ".$condition.";");
//		}
		$this->disconnect();

		return $result;
	}

	/**
	 * Function to execute a query
	 *
	 * @param  mixed  $query  Query which will be executed
	 */
	public function execQuery($query): void {
		$this->connectToTMDB();
		if (!$this->connection->connect_error) {
			mysqli_query($this->connection, $query);
		}
		$this->disconnect();
	}
}

$db = new Database();
$db->execQuery("INSERT INTO users(Email, Firstname, Lastname, Password) VALUES ('sam.barthazon@gmail.com', 'Sam', 'BARTHAZON', 'password');");
// $result = $db->execSelectQuery("*", "users", "Email = sam.barthazon@gmail.com");
// if($result) {
//   echo "Success";
// }