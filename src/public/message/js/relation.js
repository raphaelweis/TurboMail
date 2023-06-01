const RELATION_URL = "../../app/send_relation.php"

export function showAddFriendDialog() {
    let addFriendDialog = $('#add-friend');
    addFriendDialog.get(0).showModal();
    let requestMessage = $('#request-message');
    requestMessage.each(function () {
        this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:scroll;");
    }).on("input", function () {
        this.style.height = 0;
        this.style.height = this.scrollHeight + "px";
        this.style.maxHeight = 25 + "em";
    });
    window.addEventListener("resize", () => {
        requestMessage.each(function () {
            this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:scroll;");
            this.style.height = 0;
            this.style.height = this.scrollHeight + "px";
            this.style.maxHeight = 25 + "em";
        });
    })
    $('#close-button').on('click', () => {
        addFriendDialog.get(0).close();
    })
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