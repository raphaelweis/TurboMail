export function setupMessages(user) {
    const messageTextArea = $('#message-textarea');
    const sendBox = $('#send-box');
    const sendButton = $('#send-button');

    insertUserInfo(user);

    messageTextArea.on('keydown', (event) => {
        if (event.keyCode === 13) { // enter key
            event.preventDefault();
            sendMessage();
        }
    }).focus();
    sendButton.on('click', () => {
        sendMessage();
    })
    sendBox.on('input', () => {
        resizeTextArea();
    });
}

function insertUserInfo(user) {
    const userInfo = $('#user-info');
    userInfo.text(user["s_FirstName"] + " " + user["s_LastName"]);
}

function resizeTextArea() {
    const container = $('#send-box')[0];
    const textarea = $('#message-textarea')[0];

    container.style.height = 'auto';
    container.style.overflow = 'hidden';
    container.style.height = textarea.scrollHeight + 'px';
}

function resetTextArea() {
    const container = $('#send-box')[0];

    container.style.height = 4 + 'rem';
}

function scrollChatToBottom() {
    const chat = $('#chat')[0];
    chat.scrollTop = chat.scrollHeight;
}

function sendMessage() {
    const textarea = $('#message-textarea');
    const chat = $('#chat');

    let messageText = textarea.val().replace(/\n/g, '<br/>'); // replace the '\n' characters with '<br>' so that we can preserve line breaks
    let messageDiv = $('<div></div>');

    if (messageText === "") {
        return;
    }

    messageDiv.addClass('msg-box sent');
    messageDiv.html(messageText);
    chat.append(messageDiv);
    textarea.val("");
    textarea.focus()

    scrollChatToBottom();
    resetTextArea();
}