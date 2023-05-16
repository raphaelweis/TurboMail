// // defining path constants
// const LOGIN_URL = "../../app/login.php";
// const REGISTER_URL = "../../app/register.php";

// // add event Listeners on page load - prevent default submit
// window.onload = function () {
// 	const signInForm = $("#sign-in");
// 	signInForm.submit(function (event) {
// 		event.preventDefault();
// 		signInRequest();
// 	});
// 	const signUpForm = $("#sign-up");
// 	signUpForm.submit(function (event) {
// 		event.preventDefault();
// 		signUpRequest();
// 	});
// };

// function signInRequest() {
// 	// select error div
// 	let signInErrorDiv = $("#sign-in-error");

// 	// defining error codes
// 	const SUCCESS = 0;
// 	const INVALID_LOGIN = 1;

// 	// send POST request
// 	$.post(
// 		LOGIN_URL,
// 		$("#sign-in").serialize(),
// 		function (response) {
// 			response = parseInt(response);
// 			if (response === SUCCESS) {
// 				window.location.href = "../../home/home.html";
// 			} else if (response === INVALID_LOGIN) {
// 				signInErrorDiv.css("visibility", "visible");
// 			} else {
// 				alert("Oops, something unexpected happened...");
// 			}
// 		},
// 		"text"
// 	);
// }

// function signUpRequest() {
// 	// select error div
// 	let signUpErrorDiv = $("#sign-up-error");
// 	signUpErrorDiv.text("Error: ");

// 	// defining error codes
// 	const SUCCESS = 0;
// 	const INVALID_EMAIL = 1;
// 	const INVALID_PASSWORD = 2;
// 	const INVALID_FIRSTNAME = 3;
// 	const INVALID_LASTNAME = 4;
// 	const EMAIL_TAKEN = 5;
// 	const DIFFERENT_PASSWORDS = 6;

// 	// send POST request
// 	$.post(
// 		REGISTER_URL,
// 		$("#sign-up").serialize(),
// 		function (response) {
// 			response = JSON.parse(response);
// 			console.log(response);

// 			let responseInt;
// 			for (let i = 0; i < response.length; i++) {
// 				responseInt = parseInt(response[i]);
// 				switch (responseInt) {
// 					case SUCCESS:
// 						window.location.href = "../../home/home.html";
// 						return;
// 					case INVALID_EMAIL:
// 						signUpErrorDiv.append("incorrect email format, ");
// 						break;
// 					case INVALID_PASSWORD:
// 						signUpErrorDiv.append("incorrect password format, ");
// 						break;
// 					case INVALID_FIRSTNAME:
// 						signUpErrorDiv.append("incorrect firstname format, ");
// 						break;
// 					case INVALID_LASTNAME:
// 						signUpErrorDiv.append("incorrect lastname format, ");
// 						break;
// 					case EMAIL_TAKEN:
// 						signUpErrorDiv.append("email already exists, ");
// 						break;
// 					case DIFFERENT_PASSWORDS:
// 						signUpErrorDiv.append("the passwords don't match, ");
// 						break;
// 					default:
// 						alert("Oops, something unexpected happened...");
// 						break;
// 				}
// 			}
// 			signUpErrorDiv.text(signUpErrorDiv.text().slice(0, -2));
// 			signUpErrorDiv.css("visibility", "visible");
// 		},
// 		"text"
// 	);
// }
