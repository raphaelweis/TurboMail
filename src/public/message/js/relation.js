const RELATION_URL = "../../app/send_relation.php"

export function showAddFriendDialog() {
    let addFriendDialog = $('#add-friend');
    addFriendDialog.get(0).showModal();
    let requestMessage = $('#request-message');
    requestMessage.on("input", () => {
        resizeDialog(requestMessage.get(0));
    });
    window.addEventListener("resize", () => {
        resizeDialog(requestMessage.get(0));
    });
    $('#close-button').on('click', () => {
        addFriendDialog.get(0).close();
    })
}

export function resizeDialog(dialog) {
    dialog.style.height = (dialog.scrollHeight - 10) + "px"; // 10 offset to compensate for a weird height bug
    dialog.setAttribute("style", "height:" + (dialog.scrollHeight) + "px;overflow-y:scroll;");
    dialog.style.height = '0';
    dialog.style.height = (dialog.scrollHeight - 10) + "px"; // 10 offset to compensate for a weird height bug
}

export function relationRequest() {
    // Selecting error div
    let relationErrorDiv = $('#relation-error');

    // Defining error codes
    const SUCCESS = 0;
    const INVALID_EMAIL = 1;

    // Sending post request
    $.post(RELATION_URL, $("#relation-form").serialize(), (response) => {
        console.log(response);
    })
}