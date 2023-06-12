// defining path constants
const LOGIN_URL = "../../app/login.php";
const REGISTER_URL = "../../app/register.php";
const HOME_PAGE = "../message/message.html";

// add event Listeners on page load - prevent default submit
window.onload = () => {
    const signInForm = $("#sign-in");
    const signUpForm = $("#sign-up");

    signInForm.submit((event) => {
        event.preventDefault();
        signInRequest();
    });
    signUpForm.submit((event) => {
        event.preventDefault();
        signUpRequest();
    });
};

function signInRequest() {
    const signInForm = $('#sign-in');
    const signInErrorDiv = $("#sign-in-error");
    const SUCCESS = 0;
    const INVALID_LOGIN = 1;
    const data = signInForm.serialize();

    $.post(LOGIN_URL, data, (response) => {
        const responseInt = parseInt(response);

        if (responseInt === SUCCESS) {
            window.location.href = HOME_PAGE;
        } else if (responseInt === INVALID_LOGIN) {
            signInErrorDiv.css("visibility", "visible");
        } else {
            alert("Oops, something unexpected happened...");
        }
    });
}

function signUpRequest() {
    const signUpForm = $('#sign-up');
    const signUpErrorDiv = $("#sign-up-error");
    const SUCCESS = 0;
    const EMPTY_INPUTS = 1;
    const INVALID_FIRSTNAME = 2;
    const INVALID_LASTNAME = 3;
    const INVALID_EMAIL = 4;
    const INVALID_PASSWORD = 5;
    const DIFFERENT_PASSWORDS = 6;
    const EMAIL_TAKEN = 7;
    const data = signUpForm.serialize();

    signUpErrorDiv.text("Error: ");

    $.post(REGISTER_URL, data, (response) => {
        let responseInt;
        for (let i = 0; i < response.length; i++) {
            responseInt = parseInt(response[i]);
            switch (responseInt) {
                case SUCCESS:
                    window.location.href = HOME_PAGE;
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
        signUpErrorDiv.text(signUpErrorDiv.text().slice(0, -2)); // removes trailing comma + space
        signUpErrorDiv.css("visibility", "visible");
    });
}
