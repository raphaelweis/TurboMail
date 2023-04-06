// classes imports
import * as ValidationErrors from "./validationErrors.js";

// defining path constants
const LOGIN_URL = "../../app/login.php";

// add event Listeners on page load - prevent default submit
window.onload = function () {
  const signInForm = document.getElementById("sign-in");
  signInForm.addEventListener("submit", (event) => {
    event.preventDefault();
    formRequest(signInForm, "login");
  });
  const signUpForm = document.getElementById("sign-up");
  signUpForm.addEventListener("submit", (event) => {
    event.preventDefault();
    formRequest(signUpForm, "register");
  });
};

function formRequest(form, type) {
  const formCopy = form;
  const formData = new FormData(formCopy);
  formData.append("type", type);

  // remove previous error divs
  const validationErrorsDivs = document.querySelectorAll(".validation-error");
  validationErrorsDivs.forEach((div) => div.remove());

  //use of the fetch API to send a POST request
  fetch(LOGIN_URL, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.text())
    .then((responseText) => {
      let errorCode = parseInt(responseText);
      checkErrorCodes(errorCode, formCopy);
    })
    .catch((error) => {
      if (error instanceof ValidationErrors.ValidationError) {
        error.appendError();
      } else {
        alert("Oops, an unexpected server error happened !");
      }
    });
}

function checkErrorCodes(errorCode, form) {
  const INVALID_EMAIL = 910;
  const INVALID_PASSWORD = 911;
  const INVALID_FIRST_NAME = 912;
  const INVALID_LAST_NAME = 913;
  const EMAIL_TAKEN = 914;
  const NON_MATCHING_PASSWORDS = 915;
  const EMAIL_NOT_FOUND = 916;
  const WRONG_PASSWORD = 917;

  switch (errorCode) {
    case INVALID_EMAIL:
      throw new ValidationErrors.InvalidEmail(form.elements["email"]);
    case INVALID_PASSWORD:
      throw new ValidationErrors.InvalidPassword(form.elements["password"]);
    case INVALID_FIRST_NAME:
      throw new ValidationErrors.InvalidFirstName(form.elements["firstname"]);
    case INVALID_LAST_NAME:
      throw new ValidationErrors.InvalidLastName(form.elements["lastname"]);
    case EMAIL_TAKEN:
      throw new ValidationErrors.EmailTaken(form.elements["email"]);
    case NON_MATCHING_PASSWORDS:
      throw new ValidationErrors.NonMatchingPasswords(
        form.elements["passwordcheck"]
      );
    case EMAIL_NOT_FOUND:
      throw new ValidationErrors.EmailNotFound(form.elements["email"]);
    case WRONG_PASSWORD:
      throw new ValidationErrors.WrongPassword(form.elements["password"]);
  }
}
