let toSubmit = document.getElementById("search");
let inputValue = document.getElementById("input");

window.onload = () => {
  let submitValue = window.localStorage.getItem("bsearch");
  inputValue.value = submitValue;
  inputValue.focus();
};

toSubmit.addEventListener("keyup", (e) => {
  submitValue = inputValue;
  window.localStorage.setItem("bsearch", submitValue.value);
  toSubmit.submit();
  e.preventDefault();
});
