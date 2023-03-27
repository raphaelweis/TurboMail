//handling of signIn form
function signIn() {
  let signInForm = document.getElementById("sign-in");

  signInForm.addEventListener("submit", function (event) {
    event.preventDefault(); //prevent the html from auto submitting data

    let email = document.getElementById("si-email").value;
    let password = document.getElementById("si-password").value;

    console.log(email);
    console.log(password);
  });
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
