<?php

$servername = 'localhost';
$username = 'root';
$password = '';

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    exit('Connection failed: '.$conn->connect_error);
}

// Read the SQL file
$sql = file_get_contents('createDatabase.sql');
echo $sql;

// Execute the SQL queries
if ($conn->multi_query($sql) === true) {
    echo 'Database and tables created successfully!';
} else {
    echo 'Error creating database: '.$conn->error;
}

// Add redirection
