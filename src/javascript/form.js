//handling of signIn form
function signIn() {
  let httpRequest;
  document.getElementById("sign-in").addEventListener("submit", makeRequest());
  function makeRequest() {
    httpRequest = new XMLHttpRequest();

    httpRequest.open(
      "GET",
      "http://localhost/TurboMail/src/html/dummy.html",
      true
    ); //TODO : verify true parameter
    httpRequest.send();

    //let signInData = new formData(document.getElementById("sign-in"));

    //httpRequest.send(signInData);
  }
}

//handling of signUp form
function signUp() {
  let signUpForm = document.getElementById("sign-up");

  signUpForm.addEventListener("submit", function (event) {
    event.preventDefault();

    let firstname = document.getElementById("su-firstname").value;
    let lastname = document.getElementById("su-lastname").value;
    let email = document.getElementById("su-email").value;
    let password1 = document.getElementById("password1").value;
    let password2 = document.getElementById("password2").value;

    console.log(firstname);
    console.log(lastname);
    console.log(email);
    console.log(password1);
    console.log(password2);
  });
}

window.onload = function () {
  signIn();
  signUp();
};
