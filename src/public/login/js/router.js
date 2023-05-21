// defining path constants
const LOGIN_URL = "../../app/login/login.php";
const REGISTER_URL = "../../app/signup/register.php";

// add event Listeners on page load - prevent default submit
window.onload = function () {
	const signInForm = $("#sign-in");
	signInForm.submit(function (event) {
		event.preventDefault();
		signInRequest();
	});
	const signUpForm = $("#sign-up");
	signUpForm.submit(function (event) {
		event.preventDefault();
		signUpRequest();
	});
};

function signInRequest() {
	// select error div
	let signInErrorDiv = $("#sign-in-error");

	// defining error codes
	const SUCCESS = 0;
	const INVALID_LOGIN = 1;

	// send POST request
	$.post(
		LOGIN_URL,
		$("#sign-in").serialize(),
		function (response) {
			response = parseInt(response);
			if (response === SUCCESS) {
				window.location.href = "../home/home.html";
			} else if (response === INVALID_LOGIN) {
				signInErrorDiv.css("visibility", "visible");
			} else {
				alert("Oops, something unexpected happened...");
			}
		},
		"text"
	);
}

function signUpRequest() {
	// $.ajax({
	// 	url: REGISTER_URL,
	// 	type: "POST",
	// 	success: function (responseData) {
	// 		console.log(responseData);
	// 	},
	// 	error: function (xhr, status, error) {
	// 		console.error("Request failed. Status code: " + xhr.status);
	// 	},
	// });

	// select error div
	let signUpErrorDiv = $("#sign-up-error");
	signUpErrorDiv.text("Error: ");

	// defining error codes
	const SUCCESS = 0;
	const EMPTY_INPUTS = 1;
	const INVALID_FIRSTNAME = 2;
	const INVALID_LASTNAME = 3;
	const INVALID_EMAIL = 4;
	const INVALID_PASSWORD = 5;
	const DIFFERENT_PASSWORDS = 6;
	const EMAIL_TAKEN = 7;

	// send POST request
	$.post(
		REGISTER_URL,
		$("#sign-up").serialize(),
		function (response) {
			console.log(response);
			// let responseArray = Object.values(response);
			let responseInt;
			console.log(response.length);
			for (let i = 0; i < response.length; i++) {
				responseInt = parseInt(response[i]);
				switch (responseInt) {
					case SUCCESS:
						window.location.href = "../home/home.html";
						return;
					case EMPTY_INPUTS:
						signUpErrorDiv.append("empty inputs, ");
						break;
					case INVALID_FIRSTNAME:
						signUpErrorDiv.append("incorrect firstname format, ");
						break;
					case INVALID_LASTNAME:
						signUpErrorDiv.append("incorrect lastname format, ");
						break;
					case INVALID_EMAIL:
						signUpErrorDiv.append("incorrect email format, ");
						break;
					case INVALID_PASSWORD:
						signUpErrorDiv.append("incorrect password format, ");
						break;
					case DIFFERENT_PASSWORDS:
						signUpErrorDiv.append("the passwords don't match, ");
						break;
					case EMAIL_TAKEN:
						signUpErrorDiv.append("email already exists, ");
						break;
					default:
						alert("Oops, something unexpected happened...");
						break;
				}
			}
			signUpErrorDiv.text(signUpErrorDiv.text().slice(0, -2));
			signUpErrorDiv.css("visibility", "visible");
		},
		"json"
	);
}
