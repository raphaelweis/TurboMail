export function sendForm(method, form, destination) {
  const xhr = new XMLHttpRequest();
  xhr.open(method, destination);
  xhr.send(new FormData(form));

  xhr.onreadystatechange = () => {
    if (xhr.readyState !== 4 && xhr.status !== 200) {
      alert("Oops, something went wrong !");
    } else {
      console.log("request 200");
    }
  };
}
