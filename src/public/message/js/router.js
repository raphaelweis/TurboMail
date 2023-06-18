import {User} from '../../User.js';

const SEND_MESSAGE_URL = '../../app/send_message.php';
const SESSION_URL = '../../app/session.php';
const LOGOUT_URL = '../../app/logout.php';
const LOGIN_PAGE_URL = '../login/login.html';
const SEND_RELATION_URL = '../../app/send_relation.php';
const FETCH_CONTACTS_URL = '../../app/fetch_contacts.php';
const FETCH_MESSAGES_URL = '../../app/fetch_messages.php';
const UPDATE_RELATION_STATUS_URL = '../../app/update_relation_status.php';
const DELETE_RELATION_URL = '../../app/delete_relation.php';

const loggedInUser = new User();

//-----------------------------//
// Initial execution           //
//-----------------------------//
window.onload = () => {
    responsivePage();
    fetchUserDataRequest()
        .then((userData) => {
            loggedInUser.setUserData(userData);

            setupRelations();
            setupMessages();

            setupMessagePage();
        })
        .catch(() => {
            alert('Mmh... Looks you aren\'t logged in. We are taking you back to the login page.');
            window.location.href = LOGIN_PAGE_URL;
        });
};

//-----------------------------//
// Server Requests             //
//-----------------------------//
function fetchUserDataRequest() {
    return new Promise((resolve, reject) => {
        $.post(SESSION_URL, (response) => {
            const userData = JSON.parse(response);

            if (userData.length !== 0) {
                resolve(userData);
            } else {
                reject();
            }
        });
    });
}

function fetchContactsRequest() {
    const data = {email: loggedInUser.getEmail()};

    return new Promise((resolve) => {
        $.post(FETCH_CONTACTS_URL, data, (response) => displayContacts(JSON.parse(response)));
        resolve();
    });
}

function sendMessageRequest(messageText) {
    const data = {
        idSender: loggedInUser.getId(),
        idReceiver: loggedInUser.getSelectedContact().contactId,
        messageContent: messageText,
    };
    return new Promise((resolve, reject) => {
        $.post(SEND_MESSAGE_URL, data, (response) => {
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
    const chat = $('#chat');
    const data = {relationId: loggedInUser.getSelectedContact().relationId}

    chat.empty();

    return new Promise((resolve) => {
        $.post(FETCH_MESSAGES_URL, data, (response) => {
            displayMessages(JSON.parse(response))
            resolve(response);
        });
    })
}

function logoutRequest() {
    return new Promise((resolve) => {
        $.post(LOGOUT_URL, () => window.location.href = LOGIN_PAGE_URL);
        resolve();
    });
}

function addFriendRequest() {
    const addFriendDialog = $('#add-friend');
    const signUpForm = $('#relation-form');
    const addFriendErrorDiv = $('#add-friend-error');
    const data = signUpForm.serialize().replace(/%0D%0A/g, '<br/>');

    addFriendErrorDiv.text('Error: ');

    return new Promise((resolve) => {
        $.post(SEND_RELATION_URL, data, (response) => {
            const serverResponse = JSON.parse(response);

            serverResponse.forEach((response) => {
                addFriendErrorDetector(parseInt(response), addFriendErrorDiv);
            })

            if (serverResponse[0] !== 0) {
                addFriendErrorDiv.text(addFriendErrorDiv.text().slice(0, -2)); // to remove the trailing comma + space
                addFriendErrorDiv.css('visibility', 'visible');
                addFriendDialog[0].close(); //TODO
                addFriendDialog[0].showModal();
            }
            resolve();
        });
    });
}

function updateRelationStatusRequest(newRelationStatus) {
    const data = {new_status: newRelationStatus, id_relation: loggedInUser.getSelectedContact().relationId}

    return new Promise((resolve, reject) => {
        $.post(UPDATE_RELATION_STATUS_URL, data, (response) => {
            const serverResponse = parseInt(response);

            if (serverResponse === 1) {
                alert('Oops... There\'s an issue with the database. Come back later maybe?');
                reject();
            } else if (serverResponse !== 0) {
                alert('Oops... something unexpected just happened. Is your internet connection at fault?');
                reject();
            }
            resolve();
        });
    });
}

function deleteRelationRequest() {
    const data = {id_relation: loggedInUser.getSelectedContact().relationId};

    return new Promise((resolve, reject) => {
        $.post(DELETE_RELATION_URL, data, (response) => {
            const serverResponse = parseInt(response);

            if (serverResponse === 1) {
                alert('Oops... We couldn\'t delete this relation. Maybe you two are meant to be friends after all...');
                reject(serverResponse);
            } else if (serverResponse !== 0) {
                alert('Oops... To be honest, we don\'t know what happened. Come back later, please?');
                reject(serverResponse);
            }
            resolve(serverResponse);
        });
    })
}

//-----------------------------//
// Messages related functions  //
//-----------------------------//
function setupMessagePage() {
    const logoutButton = $('#logout-button');
    const sendRelationButton = $('#send-relation');

    logoutButton.on('click', () => logoutRequest());
    sendRelationButton.on('click', () => addFriendRequest());
}

function setupMessages() {
    const trashButton = $('#messages-trash-button');
    const refreshButton = $('#messages-refresh-button');
    const messageTextArea = $('#message-textarea');
    const sendBox = $('#send-box');
    const sendButton = $('#send-button');

    insertUserInfo();

    trashButton.on('click', () => showDeleteRelationDialog());
    refreshButton.on('click', () => fetchMessagesRequest());
    messageTextArea.on('keydown', (event) => {
        if (!event.shiftKey && event.key === 'Enter') {
            event.preventDefault();
            sendMessage();
        }
    })
    messageTextArea.on('focus', () => resizeMessageTextArea());
    sendButton.on('click', () => sendMessage());
    sendBox.on('input', () => resizeMessageTextArea());

    resizeMessageTextArea();
}

function showDeleteRelationDialog() {
    const deleteRelationDialog = $('#confirm-relation-delete');
    const closeButton = $('#confirm-relation-delete-close-button');
    const noButton = $('#confirm-relation-delete-no');
    const yesButton = $('#confirm-relation-delete-yes');

    deleteRelationDialog[0].showModal();

    closeButton.on('click', () => deleteRelationDialog[0].close());
    noButton.on('click', () => deleteRelationDialog[0].close());
    yesButton.on('click', () => deleteCurrentConversation());
}

function deleteCurrentConversation() {
    const deleteRelationDialog = $('#confirm-relation-delete');
    const chat = $('#chat');

    deleteRelationDialog[0].close();
    deleteRelationRequest()
        .then(() => {
            chat.empty();
            refreshContacts();
        })
        .catch();
}

function insertUserInfo() {
    const userInfo = $('#navbar-user-info');

    userInfo.text(loggedInUser.getFirstName() + " " + loggedInUser.getLastName());
}

function resizeMessageTextArea() {
    const chat = $('#chat')[0];
    const container = $('#send-box')[0];
    const textarea = $('#message-textarea')[0];

    container.style.height = 'auto';
    container.style.height = textarea.scrollHeight + 'px';
    scrollElementToBottom(textarea);
    scrollElementToBottom(chat);
}

function resetMessageTextArea() {
    const chat = $('#chat')[0];
    const container = $('#send-box')[0];
    const textarea = $('#message-textarea')[0];

    container.style.height = 4 + 'rem';
    container.style.height = textarea.style.scrollHeight + 'px';
    scrollElementToBottom(textarea);
    scrollElementToBottom(chat);
}

function scrollElementToBottom(element) {
    element.scrollTop = element.scrollHeight;
}

function sendMessage() {
    const textarea = $('#message-textarea');
    const chat = $('#chat');
    const messageText = textarea.val().replace(/\n/g, '<br/>'); // replace the '\n' characters with '<br>' so that we can preserve line breaks
    const messageDiv = $('<div></div>');
    const COULD_NOT_SEND_MESSAGE = 1;

    if (messageText === "") return;

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
    const selectedContact = loggedInUser.getSelectedContact();
    const isRelationAccepted = selectedContact.status;
    const isRelationSender = selectedContact.senderId === loggedInUser.getId();

    messagesArray.forEach((message) => {
        const messageDiv = $('<div></div>');

        messageDiv.html(message['message']);
        messageDiv.addClass('msg-box');

        if (loggedInUser.getId() === message['id_sender']) messageDiv.addClass('sent'); else messageDiv.addClass('received');

        chat.append(messageDiv);
    })

    if (!isRelationAccepted && isRelationSender) showRelationSentBanner(); else if (!isRelationAccepted && !isRelationSender) showAcceptRelationBanner();

    scrollElementToBottom(chat[0]);
}

function removeMessageFromChat(message) {
    message.remove();
}

function showAcceptRelationBanner() {
    const chat = $('#chat');
    const messageTextarea = $('#message-textarea');
    const acceptRelationMenu = $('<div id="accept-relation-banner" class="relation-pending"></div>');
    const acceptRelationMenuMessage = $('<div id="accept-relation-banner-message" class="relation-pending-message"></div>');
    const acceptRelationMenuButtons = $('<div id="accept-relation-banner-buttons"></div>');
    const acceptRelationMenuYes = $('<button id="accept-relation-banner-yes" class="common-button">Yes</button>')
    const acceptRelationMenuNo = $('<button id="accept-relation-banner-no" class="common-button">No</button>')
    const selectedContact = loggedInUser.getSelectedContact();
    const acceptRelationMenuText = `${selectedContact.firstName} ${selectedContact.lastName} sent you a friend request! Do you accept it?`;

    acceptRelationMenu.append(acceptRelationMenuMessage, acceptRelationMenuButtons);
    acceptRelationMenuButtons.append(acceptRelationMenuNo, acceptRelationMenuYes);
    acceptRelationMenuMessage.html(acceptRelationMenuText);

    chat.append(acceptRelationMenu);

    messageTextarea.prop('disabled', true);

    acceptRelationMenuYes.on('click', () => acceptRelationRequest());
    acceptRelationMenuNo.on('click', () => denyRelationRequest());
}

function showRelationSentBanner() {
    const chat = $('#chat');
    const messageTextarea = $('#message-textarea');
    const acceptRelationMenu = $('<div id="relation-sent-banner" class="relation-pending"></div>');
    const acceptRelationMenuMessage = $('<div id="relation-sent-banner-message" class="relation-pending-message"></div>');
    const selectedContact = loggedInUser.getSelectedContact();
    const acceptRelationMenuText = `Your request has been sent to ${selectedContact.firstName} ${selectedContact.lastName}. Now you just have to wait!`;

    acceptRelationMenu.append(acceptRelationMenuMessage);
    acceptRelationMenuMessage.html(acceptRelationMenuText);

    chat.append(acceptRelationMenu);

    messageTextarea.prop('disabled', true);
}

//-----------------------------//
// Relations related functions //
//-----------------------------//
function setupRelations() {
    const addFriendButton = $('#add-friend-button');
    const refreshButton = $('#contacts-refresh-button');

    fetchContactsRequest().then(() => {
        refreshButton.on('click', () => refreshContacts());
        addFriendButton.on('click', () => showAddFriendDialog());
    });
}

function refreshContacts() {
    const messagesOverlay = $('#messages-overlay');
    const chat = $('#chat');
    const messageTextarea = $('#message-textarea');

    loggedInUser.setSelectedContact(undefined);
    chat.empty();
    messageTextarea.prop('disabled', false);
    messagesOverlay.fadeIn(100);
    fetchContactsRequest();
}

function displayContacts(relations) {
    const acceptedContactsContainer = $('#accepted-contacts');
    const pendingContactsContainer = $('#pending-contacts');

    acceptedContactsContainer.empty();
    pendingContactsContainer.empty();

    relations.forEach((relation) => {
        const contactDiv = $('<div></div>');
        contactDiv.html(relation.first_name + ' ' + relation.last_name);

        contactDiv.on('click', () => selectContact(relation, contactDiv));

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
    const currentWindow = $(window);
    const messagesOverlay = $('#messages-overlay');
    const chat = $('#chat');
    const messageTextArea = $('#message-textarea');

    if (currentWindow.width() < 500) {
        selectContactInResponsive();
    }

    chat.empty();

    if (loggedInUser.getSelectedContact() !== undefined) {
        loggedInUser.getSelectedContact().contactDiv.css({
            'background-position': '0 0', 'font-size': '1rem', 'color': '#000000',
        });
    } else {
        messagesOverlay.fadeOut(100);
        messageTextArea.focus();
    }

    loggedInUser.setSelectedContact({
        contactId: relation.id,
        firstName: relation.first_name,
        lastName: relation.last_name,
        relationId: relation.id_relation,
        senderId: relation.id_sender,
        status: relation.status,
        contactDiv: contactDiv
    });
    contactDiv.css({'background-position': '-100% 0', 'font-size': '1.3rem', 'color': '#ffffff',});

    fetchMessagesRequest();
}

function addFriendErrorDetector(error, errorDiv) {
    const addFriendDialog = $('#add-friend');

    const SUCCESS = 0;
    const EMPTY_INPUTS = 1;
    const INVALID_EMAIL = 2;
    const USER_NOT_FOUND = 3;
    const SAME_USER = 4;
    const RELATION_ALREADY_EXISTS = 5;
    const RELATION_NOT_FOUND = 6;

    switch (error) {
        case SUCCESS:
            fetchContactsRequest().then(() => {
                addFriendDialog[0].close();
                clearDialog();
            });
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
    const closeButton = $('#add-friend-close-button');
    let keydownFlag = 0;

    addFriendDialog[0].showModal();

    requestMessage.on('keydown', (event) => {
        if (!event.shiftKey && event.key === 'Enter' && !keydownFlag) {
            keydownFlag = 1;
            event.preventDefault();
            addFriendRequest();
        }
    });
    keydownFlag = 0;

    requestMessage.on("input", () => resizeDialogTextArea());
    closeButton.on('click', () => addFriendDialog[0].close());
    window.addEventListener('resize', () => resizeDialogTextArea(requestMessage[0]));
}

function clearDialog() {
    const addFriendErrorDiv = $('#add-friend-error');
    const addFriendEmail = $('#add-friend-email');
    const addFriendTextArea = $('#request-message');

    addFriendErrorDiv.css('visibility', 'hidden');
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

function acceptRelationRequest() {
    const acceptRelationBanner = $('#accept-relation-banner');
    const acceptedContactsContainer = $('#accepted-contacts');
    const contactDiv = loggedInUser.getSelectedContact().contactDiv;
    const messageTextarea = $('#message-textarea');
    const ACCEPTED_STATUS = 1;

    updateRelationStatusRequest(ACCEPTED_STATUS);

    acceptRelationBanner.remove();
    contactDiv.remove();

    contactDiv.removeClass('pending-contact');
    contactDiv.addClass('accepted-contact');

    acceptedContactsContainer.prepend(contactDiv);
    messageTextarea.prop('disabled', false);
}

function denyRelationRequest() {
    const messagesOverlay = $('#messages-overlay');
    const chat = $('#chat');
    const acceptRelationBanner = $('#accept-relation-banner');
    const messageTextarea = $('#message-textarea');
    const contactDiv = loggedInUser.getSelectedContact().contactDiv;

    deleteRelationRequest();

    acceptRelationBanner.remove();
    contactDiv.remove();

    messageTextarea.prop('disabled', false);
    chat.empty();

    loggedInUser.setSelectedContact(undefined);
    messagesOverlay.fadeIn(100);
}

//------------------------------//
// Responsive related functions //
//------------------------------//
function responsivePage() {
    const currentWindow = $(window);
    const backArrow = $('#back-arrow');
    const contacts = $('#contacts');
    const messages = $('#messages');

    if (currentWindow.width() <= 1000) adaptAddFriendDialog();

    if (currentWindow.width() <= 500) displayContactsInResponsive();

    currentWindow.on('resize', () => {
        messages.css('display', 'flex');

        if (currentWindow.width() <= 1000) adaptAddFriendDialog();

        if (currentWindow.width() <= 500) displayContactsInResponsive();

        if (currentWindow.width() > 500) contacts.css({'width': '20%', 'max-width': '30rem'});

        if (currentWindow.width() > 1000) resetAddFriendDialog();
    })

    backArrow.on('click', () => {
        displayContactsInResponsive();
    })
}

function displayContactsInResponsive() {
    const logo = $('#navbar-logo');
    const backArrow = $('#back-arrow');
    const contacts = $('#contacts');
    const messages = $('#messages');

    logo.css('display', 'inline');
    backArrow.css('display', 'none');

    messages.css('display', 'none');

    contacts.css({'display': 'inline', 'width': '100%', 'max-width': '100%'});

    if (loggedInUser.getSelectedContact() !== undefined) {
        loggedInUser.getSelectedContact().contactDiv.css({
            'background-position': '0 0', 'font-size': '1rem', 'color': '#000000',
        });
    }
}

function selectContactInResponsive() {
    const logo = $('#navbar-logo');
    const backArrow = $('#back-arrow');
    const contacts = $('#contacts');
    const messages = $('#messages');

    logo.css('display', 'none');
    backArrow.css('display', 'inline');
    contacts.css('display', 'none');
    messages.css('display', 'flex');
}

function adaptAddFriendDialog() {
    const addFriendEmail = $('#add-friend-email');
    const addFriendMessage = $('#request-message');

    addFriendEmail.prop('placeholder', 'Email');
    addFriendMessage.prop('placeholder', 'Message');
}

function resetAddFriendDialog() {
    const addFriendEmail = $('#add-friend-email');
    const addFriendMessage = $('#request-message');

    addFriendEmail.prop('placeholder', 'Enter your new relation\'s email');
    addFriendMessage.prop('placeholder', 'Write an impactful message to go along with your request');
}