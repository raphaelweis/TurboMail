// defining path constants
const LOGOUT_URL = "../../app/logout/logout.php";
const LOGIN_URL = "../login/login.html";

$("#logout-button").click(function () {
    $.post(LOGOUT_URL, function () {
        window.location.href = LOGIN_URL;
    });
});
