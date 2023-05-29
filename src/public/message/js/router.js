// defining path constants
const SESSION_URL = "../../app/session.php";
const LOGOUT_URL = "../../app/logout/logout.php";
const LOGIN_URL = "../login/login.html";

window.onload = function () {
    let userData;
    // Check if the user's session is started
    $.post(SESSION_URL, function (response) {
        userData = JSON.parse(response);
        console.log(userData);
        if (userData === null) {
            window.location.href = LOGIN_URL;
        } else {
            insertUserInfo(userData);
        }
    });
};

// Insert in "user-info" div the first name and the last name of the user
function insertUserInfo(user) {
    document.getElementById("user-info").innerHTML =
        user["s_FirstName"] + " " + user["s_LastName"];
}

// Proceed with logout procedure when the logout button is clicked
$("#logout-button").on("click", function () {
    $.post(LOGOUT_URL, function () {
        window.location.href = LOGIN_URL;
    });
});

$("#add-friend-button").on("click", function () {});
