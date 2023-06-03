export function setupRelations() {
    $("#add-friend-button").on('click', () => {
        showAddFriendDialog();
    });
}

function showAddFriendDialog() {
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

function resizeDialog(dialog) {
    dialog.style.height = (dialog.scrollHeight - 10) + "px"; // 10 offset to compensate for a weird height bug
    dialog.setAttribute("style", "height:" + (dialog.scrollHeight) + "px;overflow-y:scroll;");
    dialog.style.height = 'auto';
    dialog.style.height = (dialog.scrollHeight - 10) + "px"; // 10 offset to compensate for a weird height bug
}

export function relationRequest() {
    // Sending post request
}