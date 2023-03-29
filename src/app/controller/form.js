//handling of signIn form
function signIn() {
  let signInForm = document.getElementById("sign-in");
  signInForm.addEventListener("submit", function (event) {
    // prevent HTML from auto sending the form
    event.preventDefault();

    let email = document.getElementById("si-email").value;
    let password = document.getElementById("si-password").value;

    const httpRequest = new XMLHttpRequest();
    httpRequest.open("POST", "../model/test.php");

    // set data type for the request - see MIME documentation
    httpRequest.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
    );
    httpRequest.send(
      `email=${encodeURIComponent(email)}
      &password=${encodeURIComponent(password)}`
    );
  });
}

//handling of signUp form
function signUp() {
  let signUpForm = document.getElementById("sign-up");
  signUpForm.addEventListener("submit", function (event) {
    event.preventDefault();

    let firstName = document.getElementById("su-firstname").value;
    let lastName = document.getElementById("su-lastname").value;
    let email = document.getElementById("su-email").value;
    let password = document.getElementById("su-password").value;
    let passwordCheck = document.getElementById("su-passwordcheck").value;

    const httpRequest = new XMLHttpRequest();
    httpRequest.open("POST", "../model/test.php");

    httpRequest.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
    );
    httpRequest.send(
      `firstName=${encodeURIComponent(firstName)}
      &lastName=${encodeURIComponent(lastName)}
      &email=${encodeURIComponent(email)}
      &password=${encodeURIComponent(password)}
      &passwordCheck=${encodeURIComponent(passwordCheck)}`
    );
  });
}

window.onload = function () {
  signIn();
  signUp();
};
