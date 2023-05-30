export function resizeTextArea() {
    $("#asking-message").each(function () {
        this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:scroll;");
    }).on("input", function () {
        this.style.height = 0;
        this.style.height = this.scrollHeight + "px";
        this.style.maxHeight = 25 + "em";
    });
}