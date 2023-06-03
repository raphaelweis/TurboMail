import {setupMessages} from "./message.js";
import {setupRelations} from "./relation.js";

const SESSION_URL = "../../app/session.php";
const LOGOUT_URL = "../../app/logout.php";
const LOGIN_PAGE = "../login/login.html";
const SEND_RELATION_URL = "../../app/send_relation.php"

export let user = undefined;

window.onload = () => {
    fetchUserData();

    setupRelations();

    $('#logout-button').on('click', () => {
        logoutRequest();
    });

    // $('#send-relation').submit((event) => {
    //     event.preventDefault();
    //     addFriend();
    // })
    $('#send-relation').on('click', () => {
        addFriend();
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

function addFriend() {
    $.post(SEND_RELATION_URL, $('#relation-form').serialize(), (response) => {
        console.log(response);
    })
}