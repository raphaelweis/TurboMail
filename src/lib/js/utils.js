export function sendForm(method, form, destination) {
  const xhr = new XMLHttpRequest();
  xhr.open(method, destination);
  xhr.send(new FormData(form));
  return xhr;
}
