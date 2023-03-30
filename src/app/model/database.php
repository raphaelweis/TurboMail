<?php
$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "TurboMailDB";

/* Connect to PhpMyAdmin */
function connectToDB($serverName, $userName, $password) {
  // Create connection
  $conn = new mysqli($serverName, $userName, $password);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  return $conn;
}

/* Disconnect from PhpMyAdmin */
function disconnectToDB($conn) {
  $conn->close();
}

/* Create the TurboMail's database */
function createDatabase($serverName, $userName, $password) {
  // Connection to PhpMyAdmin
  $conn = connectToDB($serverName, $userName, $password);

  // Read the SQL file
  $queries = file_get_contents('createDatabase.sql');
  echo $queries;

  // Execute the SQL queries
  if ($conn->multi_query($queries) === TRUE) {
      echo "Database and tables created successfully!";
  } else {
      echo "Error creating database: " . $conn->error;
  }

  disconnectToDB($conn);
}

/* Connect to the TurboMail's database */
function connectToTMDB($serverName, $userName, $password, $dbName) {
  // Create connection
  $conn = new mysqli($serverName, $userName, $password, $dbName);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  return $conn; 
}

/* Disconnect from TurboMail's database */
function disconnectToTMDB($conn) {
  $conn->close();
}

?>