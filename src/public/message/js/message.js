import {sendMessageRequest, loggedInUser} from "./router.js";

//-------------------------//
// Public Functions        //
//-------------------------//

export function setupMessages() {
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

//-------------------------//
// Private Functions       //
//-------------------------//

function insertUserInfo() {
    const userInfo = $('#user-info');

    userInfo.text(loggedInUser.firstName + " " + loggedInUser.lastName);
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
    const SUCCESS = 0;
    const COULD_NOT_SEND_MESSAGE = 1;

    const textarea = $('#message-textarea');
    const chat = $('#chat');

    const messageText = textarea.val().replace(/\n/g, '<br/>'); // replace the '\n' characters with '<br>' so that we can preserve line breaks
    const messageDiv = $('<div></div>');

    if (messageText === "") {
        return;
    }

    sendMessageRequest(loggedInUser.selectedContact, messageText)
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