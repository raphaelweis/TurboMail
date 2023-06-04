import {setupMessages} from "./message.js";
import {setupRelations} from "./relation.js";

const SESSION_URL = "../../app/session.php";
const LOGOUT_URL = "../../app/logout.php";
const LOGIN_PAGE_URL = "../login/login.html";
const SEND_RELATION_URL = "../../app/send_relation.php"

// global user variable. This will be used to store the current contact selected and currently logged-in user's data.
export let user; // we cannot use const because the object assigned to this variable is subject to change

window.onload = () => {
    const logoutButton = $('#logout-button');
    const sendRelationButton = $('#send-relation');

    fetchUserData();
    setupRelations();

    logoutButton.on('click', () => {
        logoutRequest();
    });
    // sendRelationButton.submit((event) => {
    //     event.preventDefault();
    //     addFriend();
    // })
    sendRelationButton.on('click', () => {
        addFriend();
    });
};

function fetchUserData() {
    $.post(SESSION_URL, (response) => {
        const userData = JSON.parse(response);

        if (userData === null) {
            window.location.href = LOGIN_PAGE_URL;
        } else {
            user = userData;
            setupMessages(userData);
        }
    }, 'text');
}

function logoutRequest() {
    $.post(LOGOUT_URL, () => {
        window.location.href = LOGIN_PAGE_URL;
    }, 'text');
}

function addFriend() {
    const signUpForm = $('#relation-form');
    const formData = signUpForm.serialize();

    $.post(SEND_RELATION_URL, formData, (response) => {
        console.log(response);
    })
}