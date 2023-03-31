import { sendForm } from "../../lib/js/utils.js";

// defining path constants
const CONTROLLERS_URL = "../../app/controllers/";
const USER_CONTROLLER_URL = `${CONTROLLERS_URL}UserController.php`;

// add event Listeners on page load - prevent default submit
window.onload = function () {
  const signInForm = document.getElementById("sign-in");
  signInForm.addEventListener("submit", (event) => {
    event.preventDefault();
    signInRequest(signInForm);
  });

  const signUpForm = document.getElementById("sign-up");
  signUpForm.addEventListener("submit", (event) => {
    event.preventDefault();
    signUpRequest(signInForm);
  });
};

// HTTP requests
function signInRequest(signInForm) {
  let xhr = sendForm("POST", signInForm, USER_CONTROLLER_URL);
  xhr.onreadystatechange = () => {
    if (xhr.readyState !== 4 && xhr.status !== 200) {
      alert("Oops, something went wrong with your request !");
      return;
    }
    if (xhr.responseText === "success") {
      window.location.href = "../home/home.html";
    } else {
      // alert("Wrong credentials !");
    }
  };
}

function signUpRequest(signUpForm) {
  sendForm("POST", signUpForm, USER_CONTROLLER_URL);
}
