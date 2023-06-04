import {User} from "../../User.js";

const SEND_MESSAGE_URL = '../../app/send_message.php';
const SESSION_URL = "../../app/session.php";
const LOGOUT_URL = "../../app/logout.php";
const LOGIN_PAGE_URL = "../login/login.html";
const SEND_RELATION_URL = "../../app/send_relation.php"
const FETCH_CONTACTS_URL = '../../app/fetch_contacts.php'

const loggedInUser = new User();

//-----------------------------//
// Initial execution           //
//-----------------------------//
window.onload = () => {
    fetchUserData()
        .then((userData) => {
            loggedInUser.setUserData(userData);

            setupRelations();
            setupMessages();

            setupMessagePage();
        })
        .catch(() => {
            window.location.href = LOGIN_PAGE_URL;
        });
};

//-----------------------------//
// Server Requests             //
//-----------------------------//
function fetchUserData() {
    return new Promise((resolve, reject) => {
        $.post(SESSION_URL, (response) => {
            const userData = JSON.parse(response);

            if (userData != null) {
                resolve(userData);
            } else {
                reject();
            }
        }, 'text');
    });
}

function updateContacts() {
    $.post(FETCH_CONTACTS_URL, {email: loggedInUser.getEmail()}, (response) => {
        let contacts = JSON.parse(response);
        displayContacts(contacts);
    }, 'text');
}

function sendMessageRequest(messageText) {
    const messageData = {
        idSender: loggedInUser.getId(),
        idReceiver: loggedInUser.getSelectedContact(),
        messageContent: messageText,
    };
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

function logoutRequest() {
    $.post(LOGOUT_URL, () => {
        window.location.href = LOGIN_PAGE_URL;
    }, 'text');
}

function addFriend() {
    const signUpForm = $('#relation-form');
    const formData = signUpForm.serialize();
    const addFriendErrorDiv = $('#add-friend-error');

    addFriendErrorDiv.text("Error: ");

    $.post(SEND_RELATION_URL, formData, (response) => {
        for (let i = 0; i < response.length; i++) {
            addFriendErrorDetector(parseInt(response[i]), addFriendErrorDiv);
        }

        addFriendErrorDiv.text(addFriendErrorDiv.text().slice(0, -2)); // removes trailing comma + space
        addFriendErrorDiv.css("visibility", "visible");

        console.log(response);
    }, "json");
}

//-----------------------------//
// Messages related functions  //
//-----------------------------//
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

function setupMessages() {
    const messageTextArea = $('#message-textarea');
    const sendBox = $('#send-box');
    const sendButton = $('#send-button');

    insertUserInfo();

    messageTextArea.on('keydown', (event) => {
        if (!event.shiftKey && event.key === 'Enter') {
            event.preventDefault();
            sendMessage();
        }
        if (event.shiftKey && event.key === 'Enter') {
            insertNewLine();
        }
    })
    messageTextArea.on('focus', () => {
        resizeTextArea();
    });
    sendButton.on('click', () => {
        sendMessage();
    })
    sendBox.on('input', () => {
        resizeTextArea();
    });

    resizeTextArea();
    messageTextArea.focus();
}

function insertUserInfo() {
    const userInfo = $('#user-info');

    userInfo.text(loggedInUser.getFirstName() + " " + loggedInUser.getLastName());
}

function resizeTextArea() {
    const container = $('#send-box')[0];
    const textarea = $('#message-textarea')[0];

    container.style.height = 'auto';
    container.style.overflow = 'hidden';
    container.style.height = textarea.scrollHeight + 'px';
    scrollElementToBottom(textarea);
}

function resetTextArea() {
    const container = $('#send-box')[0];

    container.style.height = 4 + 'rem';
}

function insertNewLine() {
    const textarea = $('#message-textarea');

    textarea.val(textarea.val() + '\n');
}

function scrollElementToBottom(element) {
    element.scrollTop = element.scrollHeight;
}

function sendMessage() {
    const COULD_NOT_SEND_MESSAGE = 1;

    const textarea = $('#message-textarea');
    const chat = $('#chat');

    const messageText = textarea.val().replace(/\n/g, '<br/>'); // replace the '\n' characters with '<br>' so that we can preserve line breaks
    const messageDiv = $('<div></div>');

    if (messageText === "") {
        return;
    }

    sendMessageRequest(messageText)
        .catch((error) => {
            if (error === COULD_NOT_SEND_MESSAGE) {
                alert('Sorry... We were not able to send your message! Is your internet down?')
                textarea.val("");
                removeMessageFromChat(messageDiv);
            } else {
                alert('Oops... An unexpected server error happened! Sit back and relax while we try to fix the problem.')
                textarea.val("");
                removeMessageFromChat(messageDiv);
            }
        })

    messageDiv.addClass('msg-box sent');
    messageDiv.html(messageText);
    chat.append(messageDiv);
    textarea.val("");
    textarea.focus()

    scrollElementToBottom(chat[0]);
    resetTextArea();
}

function removeMessageFromChat(message) {
    message.remove();
}

//-----------------------------//
// Relations related functions //
//-----------------------------//
function setupRelations() {
    const addFriendButton = $('#add-friend-button');

    updateContacts();

    addFriendButton.on('click', () => {
        showAddFriendDialog();
    });
}

function displayContacts(relations) {
    const contactsContainer = $('#contacts');

    contactsContainer.empty();

    relations.forEach((relation) => {
        const contactDiv = $('<div></div>');
        contactDiv.addClass('contact');
        contactDiv.html(relation.first_name + ' ' + relation.last_name);

        contactDiv.on('click', () => {
            selectContact(relation.id);
        });

        contactsContainer.append(contactDiv);
    })
}


function addFriendErrorDetector(error, errorDiv) {
    const SUCCESS = 0;
    const EMPTY_INPUTS = 1;
    const INVALID_EMAIL = 2;
    const USER_NOT_FOUND = 3;
    const SAME_USER = 4;
    const RELATION_ALREADY_EXISTS = 5;
    const RELATION_NOT_FOUND = 6;

    switch (error) {
        case SUCCESS:
            updateContacts();
            break;
        case EMPTY_INPUTS:
            errorDiv.append("empty inputs, ");
            break;
        case INVALID_EMAIL:
            errorDiv.append("incorrect email format, ");
            break;
        case USER_NOT_FOUND:
            errorDiv.append("user not found, ");
            break;
        case SAME_USER:
            errorDiv.append("your are this user, ");
            break;
        case RELATION_ALREADY_EXISTS:
            errorDiv.append("relation already exists, ");
            break;
        case RELATION_NOT_FOUND:
            errorDiv.append("relation not found, ");
            break;
        default:
            alert("Oops, something unexpected happened...");
            break;
    }
}

function selectContact(relationID) {
    loggedInUser.setSelectedContact(relationID);
    console.log(loggedInUser.getSelectedContact());
}

function showAddFriendDialog() {
    const addFriendDialog = $('#add-friend');
    const requestMessage = $('#request-message');
    const closeButton = $('#close-button');

    addFriendDialog[0].showModal();

    requestMessage.on("input", () => {
        resizeDialog();
    });
    closeButton.on('click', () => {
        addFriendDialog[0].close();
    })
    window.addEventListener("resize", () => {
        resizeDialog(requestMessage[0]);
    });
}

function resizeDialog() {
    const textarea = $('#request-message')[0];

    textarea.style.height = 'auto';

    const currentScrollHeight = textarea.scrollHeight;
    const topPadding = parseInt(window.getComputedStyle(textarea).paddingTop);
    const bottomPadding = parseInt(window.getComputedStyle(textarea).paddingBottom);
    const verticalPadding = topPadding + bottomPadding;
    const finalHeight = currentScrollHeight - verticalPadding;

    textarea.style.height = finalHeight + 'px';
}

