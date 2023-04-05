// defining path constants
const LOGIN_URL = "../../app/login.php";

// add event Listeners on page load - prevent default submit
window.onload = function () {
  const signInForm = document.getElementById("sign-in");
  signInForm.addEventListener("submit", (event) => {
    event.preventDefault();
    signInRequest(signInForm);
  });
};

// HTTP requests
function signInRequest(signInForm) {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", LOGIN_URL);
  xhr.send(new FormData(signInForm));

  xhr.onload = () => {
    if (xhr.status === 200) {
      let response = Number(xhr.responseText);
      // let response = xhr.responseText;
      console.log(response);
      window.location.href = "../home/home.html";
    }
  };
}
