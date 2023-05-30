export function insertUserInfo(user) {
    $("#user-info").text(user["s_FirstName"] + " " + user["s_LastName"]);
}

export function sendMessage() {
    let textAreaDiv = $('#to-send');
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