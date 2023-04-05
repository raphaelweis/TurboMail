// imports
import { InvalidEmail } from "./validationErrors";

// defining path constants
const LOGIN_URL = "../../../app/login.php";

// add event Listeners on page load - prevent default submit
window.onload = function () {
  console.log("hello");
  const signInForm = document.getElementById("sign-in");
  signInForm.addEventListener("submit", (event) => {
    event.preventDefault();
    signInRequest();
  });
};

function signInRequest() {
  const signInForm = document.getElementById("sign-in");
  const formData = new FormData(signInForm);

  //use of the fetch API to send a POST request
  fetch(LOGIN_URL, {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      let errorCode = Number(response.text());
      if (errorCode == 910) {
        throw new InvalidEmail(document.getElementById("si-email"));
      }
    })
    .catch((error) => {
      if (error instanceof InvalidEmail) {
        error.appendError();
      }
    });
}
