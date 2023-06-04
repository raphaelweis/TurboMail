import {setupMessages} from "./message.js";
import {errorDetector, setupRelations} from "./relation.js";
import {User} from "../../User.js";

const SEND_MESSAGE_URL = "../../app/send_message.php";
const SESSION_URL = "../../app/session.php";
const LOGOUT_URL = "../../app/logout.php";
const LOGIN_PAGE_URL = "../login/login.html";
const SEND_RELATION_URL = "../../app/send_relation.php"

export let loggedInUser;

window.onload = () => {
    fetchUserData()
        .then((userData) => {
            loggedInUser = new User(userData);

            setupRelations();
            setupMessages();

            setupMessagePage();
        })
        .catch(() => {
            window.location.href = LOGIN_PAGE_URL;
        });
};

//-------------------------//
// Public Functions        //
//-------------------------//

export function sendMessageRequest(contactID, messageText) {
    const messageData = {
        idSender: loggedInUser.id,
        idReceiver: loggedInUser.selectedContact,
        messageContent: messageText,
    }
    return new Promise((resolve, reject) => {
        $.post(SEND_MESSAGE_URL, messageData, (response) => {
            const serverResponse = parseInt(response);

            if (serverResponse === 0) {
                resolve(serverResponse);
            } else {
                reject(serverResponse);
            }
        }, 'text');
    })
}

//-------------------------//
// Private Functions       //
//-------------------------//

function fetchUserData() {
    return new Promise((resolve, reject) => {
        $.post(SESSION_URL, (response) => {
            const userData = JSON.parse(response);
            console.log(userData);

            if (userData != null) {
                resolve(userData);
            } else {
                reject();
            }
        }, 'text');
    });
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
        const addFriendErrorDiv = $('#add-friend-error');

        for(let i = 0; i < response.length; i++) {
            errorDetector(parseInt(response[i]), addFriendErrorDiv);
        }

        addFriendErrorDiv.text(addFriendErrorDiv.text().slice(0, -2)); // removes trailing comma + space
        addFriendErrorDiv.css("visibility", "visible");

        console.log(response);
    }, "json");
}

function setupMessagePage() {
    const logoutButton = $('#logout-button');
    const sendRelationButton = $('#send-relation');

    logoutButton.on('click', () => {
        logoutRequest();
    });
    sendRelationButton.on('click', () => {
        addFriend();
    });
}