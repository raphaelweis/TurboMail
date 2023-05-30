import {insertUserInfo, sendMessage} from "./message.js";

const SESSION_URL = "../../app/session.php";
const LOGOUT_URL = "../../app/logout/logout.php";
const LOGIN_URL = "../login/login.html";

window.onload = () => {
    fetchUserData();
    $('#logout-button').on('click', () => {
        logoutRequest();
    });
    $("#add-friend-button").on('click', () => {
    });
    $("#to-send").on('keydown', (event) => {
        if (event.keyCode === 13) { // enter key
            event.preventDefault();
            sendMessage();
        }
    }).focus();
    $("#send-button").on('click', () => {
        sendMessage();
    })
};

function fetchUserData() {
    let userData;
    // Check if the user's session is started
    $.post(SESSION_URL, (response) => {
        userData = JSON.parse(response);
        console.log(userData);
        if (userData === null) {
            window.location.href = LOGIN_URL;
        } else {
            insertUserInfo(userData);
        }
    });
}

function logoutRequest() {
    $.post(LOGOUT_URL, () => {
        window.location.href = LOGIN_URL;
    }, 'text');
}
