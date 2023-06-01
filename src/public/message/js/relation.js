const RELATION_URL = "../../app/send_relation.php"

export function resizeTextArea() {
    $("#asking-message").each(function () {
        this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:scroll;");
    }).on("input", function () {
        this.style.height = 0;
        this.style.height = this.scrollHeight + "px";
        this.style.maxHeight = 25 + "em";
    });
}

export function showAddFriendDialog() {
    // we need the get(0) method to access the actual html element, the 0 is to reference the 0 position in the array returned by jquery
    // we have to put the 0 even though there is only one element being returned, otherwise we are accessing the array object.
    $('#add-friend').get(0).showModal();
    // Note: $('add-friend')[0].showModal(); is equivalent
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

// Not sure to implement
// Feature : close popup when we click outside
// window.onclick = function (event) {
//     if (event.target == document.getElementById("add-friend")) {
//         document.getElementById("add-friend").style.display = "none";
//     }
// };