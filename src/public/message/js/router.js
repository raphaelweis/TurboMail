// defining path constants
const SESSION_URL = "../../app/session.php";
const LOGOUT_URL = "../../app/logout/logout.php";
const LOGIN_URL = "../login/login.html";

window.onload = function () {
    let user;
    // Check if the user's session is started
    $.post(SESSION_URL, function (response) {
        user = JSON.parse(response);
        if (user == null) {
            window.location.href = LOGIN_URL;
        } else {
            insertUserInfo(user);
        }
    });
};

// Insert in "user-info" div the first name and the last name of the user
function insertUserInfo(user) {
    document.getElementById("user-info").innerHTML =
        user["s_FirstName"] + " " + user["s_LastName"];
}

// Proceed with logout procedure when the logout button is clicked
$("#logout-button").click(function () {
    $.post(LOGOUT_URL, function () {
        window.location.href = LOGIN_URL;
    });
});
