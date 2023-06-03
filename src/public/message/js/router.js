import {setupMessages} from "./message.js";
import {setupRelations} from "./relation.js";

const SESSION_URL = "../../app/session.php";
const LOGOUT_URL = "../../app/logout.php";
const LOGIN_PAGE = "../login/login.html";

export let user = undefined;

window.onload = () => {
    fetchUserData();

    setupRelations();

    $('#logout-button').on('click', () => {
        logoutRequest();
    });
};

function fetchUserData() {
    // Check if the user's session is started
    $.post(SESSION_URL, (response) => {
        const userData = JSON.parse(response);
        if (userData === null) {
            window.location.href = LOGIN_PAGE;
        } else {
            user = userData;
            setupMessages(userData);
        }
    });
}

function logoutRequest() {
    $.post(LOGOUT_URL, () => {
        window.location.href = LOGIN_PAGE;
    }, 'text');
}

export function sendMessageRequest() {

}