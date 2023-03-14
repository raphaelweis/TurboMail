<?php
$firstname = "";
$lastname = "";
$email = "";
$password = "";
$checkPassword = "";

if(!empty($_POST['firstname'])){
  $firstname = $_POST['firstname'];
}

header("Location: index.php");
die();

?>