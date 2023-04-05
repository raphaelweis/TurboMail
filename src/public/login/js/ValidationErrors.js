export class InvalidEmail extends Error {
  constructor(emailInput) {
    super();
    this.message = "Error, the email address is invalid";
    this.emailInput = emailInput;
  }
  appendError() {
    const errorDiv = document.createElement("div");
    errorDiv.textContent = this.message;
    errorDiv.classList.add("validation-error");
    this.emailInput.insertAdjacentElement("afterend", errorDiv);
  }
}
