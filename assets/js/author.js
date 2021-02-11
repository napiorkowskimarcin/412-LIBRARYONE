let toSubmit = document.getElementById("search");
let inputValue = document.getElementById("input");

window.onload = () => {
  let submitValue = window.localStorage.getItem("asearch");
  inputValue.value = submitValue;
  inputValue.focus();
};

toSubmit.addEventListener("keyup", (e) => {
  submitValue = inputValue;
  window.localStorage.setItem("asearch", submitValue.value);
  toSubmit.submit();
  e.preventDefault();
});
