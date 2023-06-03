import {insertUserInfo, sendMessage} from "./message.js";
import {showAddFriendDialog} from "./relation.js";

const SESSION_URL = "../../app/session.php";
const LOGOUT_URL = "../../app/logout.php";
const LOGIN_PAGE = "../login/login.html";

window.onload = () => {
    fetchUserData();
    $('#logout-button').on('click', () => {
        logoutRequest();
    });
    $("#add-friend-button").on('click', () => {
        showAddFriendDialog();
    });

    let messageTextArea = $('#message-textarea');
    messageTextArea.on('keydown', (event) => {
        if (event.keyCode === 13) { // enter key
            event.preventDefault();
            sendMessage();
        }
    }).focus();
    $("#send-button").on('click', () => {
        sendMessage();
    })
    document.getElementById('send-box').addEventListener('keyup', function () {
        let textarea = document.getElementById('message-textarea');

        if (textarea.scrollHeight > textarea.clientHeight) {
            let element = this;
            let computedStyle = window.getComputedStyle(element);
            let currentHeightInPixels = parseFloat(computedStyle.height);
            let fontSizeInPixels = parseFloat(computedStyle.fontSize);
            let currentHeightInRems = currentHeightInPixels / fontSizeInPixels;
            let newHeightInRems = currentHeightInRems + 1;
            element.style.height = newHeightInRems + 'rem';
        }
    });
};

function fetchUserData() {
    let userData;
    // Check if the user's session is started
    $.post(SESSION_URL, (response) => {
        userData = JSON.parse(response);
        console.log(userData);
        if (userData === null) {
            window.location.href = LOGIN_PAGE;
        } else {
            insertUserInfo(userData);
        }
    });
}

function logoutRequest() {
    $.post(LOGOUT_URL, () => {
        window.location.href = LOGIN_PAGE;
    }, 'text');
}
