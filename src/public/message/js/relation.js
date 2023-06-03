export function setupRelations() {
    $("#add-friend-button").on('click', () => {
        showAddFriendDialog();
    });
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

