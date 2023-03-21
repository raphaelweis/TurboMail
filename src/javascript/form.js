//handling of signIn form
function signIn() {
  var signInForm = document.getElementById("sign-in");

  signInForm.addEventListener("submit", function (event) {
    event.preventDefault(); //prevent the html from auto submitting data

    var email = document.getElementById("si-email").value;
    console.log(email);
    var password = document.getElementById("si-password").value;
    console.log(password);
  });
}
