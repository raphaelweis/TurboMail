// parent class for form Validation Errors
export class ValidationError extends Error {
  constructor(formInput) {
    if (formInput === undefined) throw new InvalidTypeError();
    super();
    this.formInput = formInput;
  }
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
    super(emailInput);
    this.message = "Error, the email address's format is invalid";
  }
}

export class InvalidPassword extends ValidationError {
  constructor(passwordInput) {
    super(passwordInput);
    this.message = "Error, the password's format is invalid";
  }
}

export class InvalidFirstName extends ValidationError {
  constructor(firstNameInput) {
    super(firstNameInput);
    this.message = "Error, the first name's format is invalid";
  }
}

export class InvalidLastName extends ValidationError {
  constructor(lastNameInput) {
    super(lastNameInput);
    this.message = "Error, the last name's format is invalid";
  }
}

export class EmailTaken extends ValidationError {
  constructor(emailInput) {
    super(emailInput);
    this.message = "Error, this email address is already taken";
  }
}

export class NonMatchingPasswords extends ValidationError {
  constructor(checkPasswordInput) {
    super(checkPasswordInput);
    this.message = "Error, the passwords provided do not match";
  }
}

export class EmailNotFound extends ValidationError {
  constructor(emailInput) {
    super(emailInput);
    this.message =
      "Error, there is no account associated with this email adress";
  }
}

export class WrongPassword extends ValidationError {
  constructor(passwordInput) {
    super(passwordInput);
    this.message = "Error, wrong password";
  }
}
