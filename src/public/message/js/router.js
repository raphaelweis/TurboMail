import {User} from '../../User.js';

const SEND_MESSAGE_URL = '../../app/send_message.php';
const SESSION_URL = '../../app/session.php';
const LOGOUT_URL = '../../app/logout.php';
const LOGIN_PAGE_URL = '../login/login.html';
const SEND_RELATION_URL = '../../app/send_relation.php';
const FETCH_CONTACTS_URL = '../../app/fetch_contacts.php';
const FETCH_MESSAGES_URL = '../../app/fetch_messages.php';

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
        });
    });
}

function updateContacts() {
    $.post(FETCH_CONTACTS_URL, {email: loggedInUser.getEmail()}, (response) => {
        let contacts = JSON.parse(response);
        displayContacts(contacts);
    });
}

function sendMessageRequest(messageText) {
    const messageData = {
        idSender: loggedInUser.getId(),
        idReceiver: loggedInUser.getSelectedContact().contactId,
        messageContent: messageText,
    };
    return new Promise((resolve, reject) => {
        $.post(SEND_MESSAGE_URL, messageData, (response) => {
            const serverResponse = parseInt(response);

            if (serverResponse === 0) {
                resolve(serverResponse);
            } else if (serverResponse === 1) {
                reject(serverResponse);
            } else {
                reject(serverResponse);
            }
        });
    })
}

function fetchMessagesRequest() {
    const relationId = loggedInUser.getSelectedContact().relationId;

    $.post(FETCH_MESSAGES_URL, {relationId: relationId}, (response) => {
        const messageArray = JSON.parse(response);
        displayMessages(messageArray);
    });
}

function logoutRequest() {
    $.post(LOGOUT_URL, () => {
        window.location.href = LOGIN_PAGE_URL;
    });
}

function addFriend() {
    const signUpForm = $('#relation-form');
    const addFriendErrorDiv = $('#add-friend-error');
    const formData = signUpForm.serialize();

    addFriendErrorDiv.text('Error: ');

    $.post(SEND_RELATION_URL, formData, (response) => {
        const serverResponse = JSON.parse(response);

        serverResponse.forEach((response) => {
            addFriendErrorDetector(parseInt(response), addFriendErrorDiv);
        })

        if(serverResponse[0] !== 0) {
            addFriendErrorDiv.text(addFriendErrorDiv.text().slice(0, -2)); // removes trailing comma + space
            addFriendErrorDiv.css('visibility', 'visible');
        }
    });
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
    })
    messageTextArea.on('focus', () => {
        resizeMessageTextArea();
    });
    sendButton.on('click', () => {
        sendMessage();
    })
    sendBox.on('input', () => {
        resizeMessageTextArea();
    });

    resizeMessageTextArea();
}

function insertUserInfo() {
    const userInfo = $('#navbar-user-info');

    userInfo.text(loggedInUser.getFirstName() + " " + loggedInUser.getLastName());
}

function resizeMessageTextArea() {
    const container = $('#send-box')[0];
    const textarea = $('#message-textarea')[0];

    container.style.height = 'auto';
    container.style.height = textarea.scrollHeight + 'px';
    scrollElementToBottom(textarea);
}

function resetMessageTextArea() {
    const container = $('#send-box')[0];
    const textarea = $('#message-textarea')[0];

    container.style.height = 4 + 'rem';
    container.style.height = textarea.style.scrollHeight + 'px';
    scrollElementToBottom(textarea);
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
    resetMessageTextArea();
}

function displayMessages(messagesArray) {
    const chat = $('#chat');

    messagesArray.forEach((message) => {
        const messageDiv = $('<div></div>');

        messageDiv.html(message['message']);
        messageDiv.addClass('msg-box');

        if (loggedInUser.getId() === message['id_sender']) {
            messageDiv.addClass('sent');
        } else {
            messageDiv.addClass('received');
        }

        chat.append(messageDiv);
    })

    if (!loggedInUser.getSelectedContact().status) {
        displayAcceptRelationMenu();
    }

    scrollElementToBottom(chat);
}

function removeMessageFromChat(message) {
    message.remove();
}

function displayAcceptRelationMenu() {
    const chat = $('#chat');
    const acceptRelationMenu = $('<div id="accept-relation-menu"></div>');
    const acceptRelationMenuMessage = $('<div id="accept-relation-menu-message"></div>');
    const acceptRelationMenuButtons = $('<div id="accept-relation-menu-buttons"></div>');
    const acceptRelationMenuYes = $('<button id="accept-relation-menu-yes" class="common-button">Yes</button>')
    const acceptRelationMenuNo = $('<button id="accept-relation-menu-no" class="common-button">No</button>')

    const firstName = loggedInUser.getSelectedContact().firstName;
    const lastName = loggedInUser.getSelectedContact().lastName;
    const acceptRelationMenuText = `Do you accept the friend request sent by ${firstName} ${lastName} ?`

    acceptRelationMenu.append(acceptRelationMenuMessage, acceptRelationMenuButtons);
    acceptRelationMenuButtons.append(acceptRelationMenuNo, acceptRelationMenuYes);
    acceptRelationMenuMessage.html(acceptRelationMenuText);

    chat.append(acceptRelationMenu);
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
    const acceptedContactsContainer = $('#accepted-contacts');
    const pendingContactsContainer = $('#pending-contacts');

    acceptedContactsContainer.empty();
    pendingContactsContainer.empty();

    relations.forEach((relation) => {
        console.log(relation);
        const contactDiv = $('<div></div>');
        contactDiv.html(relation.first_name + ' ' + relation.last_name);

        contactDiv.on('click', () => {
            selectContact(relation, contactDiv);
        });

        if (!relation.status) {
            contactDiv.addClass('pending-contact');
            pendingContactsContainer.append(contactDiv);
        } else {
            contactDiv.addClass('accepted-contact');
            acceptedContactsContainer.append(contactDiv);
        }
    })
}

function selectContact(relation, contactDiv) {
    const messagesOverlay = $('#messages-overlay');
    const chat = $('#chat');
    const messageTextArea = $('#message-textarea');

    chat.empty();

    if (loggedInUser.getSelectedContact() !== undefined) {
        loggedInUser.getSelectedContact().contactDiv.css({
            'background-position': '0 0',
            'font-size': '1rem',
            'color': '#000000',
        });
    } else {
        messagesOverlay.fadeOut(100, () => {
            messagesOverlay.remove();
        });
        messageTextArea.focus();
    }

    loggedInUser.setSelectedContact({
        contactId: relation.id,
        firstName: relation.first_name,
        lastName: relation.last_name,
        relationId: relation.id_relation,
        status: relation.status,
        contactDiv: contactDiv
    });
    contactDiv.css({
        'background-position': '-100% 0',
        'font-size': '1.3rem',
        'color': '#ffffff',
    });

    fetchMessagesRequest();
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
            clearDialog();
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

function showAddFriendDialog() {
    const addFriendDialog = $('#add-friend');
    const requestMessage = $('#request-message');
    const closeButton = $('#close-button');

    addFriendDialog[0].showModal();

    requestMessage.on('keydown', (event) => {
        if (!event.shiftKey && event.key === 'Enter') {
            event.preventDefault();
            addFriend();
        }
    });

    requestMessage.on("input", () => {
        resizeDialogTextArea();
    });
    closeButton.on('click', () => {
        addFriendDialog[0].close();
    })
    window.addEventListener("resize", () => {
        resizeDialogTextArea(requestMessage[0]);
    });
}

function clearDialog() {
    const addFriendErrorDiv = $('#add-friend-error');
    const addFriendEmail = $('#add-friend-email');
    const addFriendTextArea = $('#request-message');

    addFriendErrorDiv.val('');
    addFriendEmail.val('');
    addFriendTextArea.val('');
}

function resizeDialogTextArea() {
    const Textarea = $('#request-message');
    const textarea = Textarea[0];

    let verticalPadding, finalHeight;
    verticalPadding = parseInt(Textarea.css('padding-bottom')) + parseInt(Textarea.css('padding-top'));

    textarea.style.overflow = 'hidden';
    textarea.style.height = 'auto';

    finalHeight = textarea.scrollHeight - verticalPadding;
    textarea.style.height = finalHeight + 'px';
    textarea.style.overflow = 'scroll';

    scrollElementToBottom(textarea);
}