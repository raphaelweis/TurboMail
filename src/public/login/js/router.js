// classes imports

// defining path constants
const LOGIN_URL = "../../app/login.php";

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
    // remove previous error divs
    const validationErrorsDivs = $("validation-errors")
    validationErrorsDivs.forEach((div) => div.remove());

    $.post(LOGIN_URL, $("#sign-in").serialize(), function (response) {
        if (response === 0) {
            window.location.href = "../../home/home.html";
        } else if (response === 1) {
            alert("Login failed !");
        } else {
            alert("Oops, something unexpected happened...");
        }
    }, "text");
}

function signUpRequest(form) {

}