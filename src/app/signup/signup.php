<?php

if (isset($_POST['submit'])) {
	// Grabbing the data
	$firstName = trim(htmlspecialchars($_POST['firstname']));
	$lastName = trim(htmlspecialchars($_POST['lastname']));
	$email = trim(htmlspecialchars($_POST['email']));
	$password = trim(htmlspecialchars($_POST['password']));
	$passwordCheck = trim(htmlspecialchars($_POST['password-check']));

	// Instantiate SignupContr class
	include '../database/dbh_class.php';
	include 'signup_class.php';
	include 'signup-contr_class.php';
	$signup = new NewUserController($firstName, $lastName, $email, $password,
		$passwordCheck);

	// Running error handlers and user signup
	$signup->signupUser();
}

$errors[] = 0;
echo json_encode($errors);