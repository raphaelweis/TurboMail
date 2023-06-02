export function insertUserInfo(user) {
    $("#user-info").text(user["s_FirstName"] + " " + user["s_LastName"]);
}

export function sendMessage() {
    let textAreaDiv = $('#message-textarea');
    let messageText = textAreaDiv.val();
    let messageDiv = $('<div></div>');

    if (messageText === "") {
        return;
    }

    messageDiv.addClass('msg-box sent');
    messageDiv.text(messageText);

    $('#chat').append(messageDiv);
    textAreaDiv.val("");
    textAreaDiv.focus()
}

export function resizeTextArea(textarea) {
    textarea.style.height = 0;
    textarea.style.height = textarea.scrollHeight + 'px';
}