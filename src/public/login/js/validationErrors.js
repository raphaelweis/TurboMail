// parent class for form Validation Errors
export class ValidationError extends Error {
  // insert a div below the form input with the error message
  appendError() {
    const errorDiv = document.createElement("div");
    errorDiv.textContent = this.message;
    errorDiv.classList.add("validation-error");
    this.formInput.insertAdjacentElement("afterend", errorDiv);
  }
}

// child classes to provide customized error messages
export class InvalidEmail extends ValidationError {
  constructor(emailInput) {
    super();
    this.message = "Error, the email address's format is invalid";
    this.formInput = emailInput;
  }
}

export class InvalidPassword extends ValidationError {
  constructor(passwordInput) {
    super();
    this.message = "Error, the password's format is invalid";
    this.formInput = passwordInput;
  }
}

export class InvalidFirstName extends ValidationError {
  constructor(firstNameInput) {
    super();
    this.message = "Error, the first name's format is invalid";
    this.formInput = firstNameInput;
  }
}

export class InvalidLastName extends ValidationError {
  constructor(lastNameInput) {
    super();
    this.message = "Error, the last name's format is invalid";
    this.formInput = lastNameInput;
  }
}

export class EmailTaken extends ValidationError {
  constructor(emailInput) {
    super();
    this.message = "Error, this email address is already taken";
    this.formInput = emailInput;
  }
}

export class NonMatchingPasswords extends ValidationError {
  constructor(checkPasswordInput) {
    super();
    this.message = "Error, the passwords provided do not match";
    this.formInput = checkPasswordInput;
  }
}

export class EmailNotFound extends ValidationError {
  constructor(emailInput) {
    super();
    this.message =
      "Error, there is no account associated with this email adress";
    this.formInput = emailInput;
  }
}

export class WrongPassword extends ValidationError {
  constructor(passwordInput) {
    super();
    this.message = "Error, wrong password";
    this.formInput = passwordInput;
  }
}
