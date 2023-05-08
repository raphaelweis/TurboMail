// defining path constants
const LOGIN_URL = '../../app/login.php';

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

    // send POST request
    $.post(LOGIN_URL, $('#sign-in').serialize(), function (response) {
        response = parseInt(response);
        if (response === 0) {
            window.location.href = '../../home/home.html';
        } else if (response === 1) {
            $('#sign-in-error').css('visibility', 'visible');
        } else {
            alert('Oops, something unexpected happened...');
        }
    }, 'text');
}

function signUpRequest(form) {

}