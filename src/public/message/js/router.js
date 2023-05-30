import {insertUserInfo, sendMessage} from "./message.js";
import {resizeTextArea, relationRequest} from "./relation.js";

const SESSION_URL = "../../app/session.php";
const LOGOUT_URL = "../../app/logout.php";
const LOGIN_PAGE = "../login/login.html";

window.onload = () => {
    fetchUserData();
    $('#logout-button').on('click', () => {
        logoutRequest();
    });
    $("#add-friend-button").on('click', () => {
        $("#add-friend").css("display", "block");
        $("#close-button").on('click', () => {
            $("#add-friend").css("display", "none");
        });
        resizeTextArea();
        const relationForm = $("#relation-form");
        relationForm.submit((event) => {
            event.preventDefault();
            relationRequest();
        })
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
