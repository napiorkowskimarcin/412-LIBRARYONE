const path = "/book/show";
let data = "";

let sendAjax = {
  ajax: true,
  type: "get",
  url: path,
  dataType: "html",
  success: function (data) {
    response = JSON.parse(data);
    $("#table").html(response.template);
  },
};

$("#title").keyup(function (event) {
  event.preventDefault();
  sendAjax.data = $("#inputTitle");
  if ($("#inputTitle").val().length) {
    $.ajax(sendAjax);
  }
});

$("#author").keyup(function (event) {
  event.preventDefault();
  sendAjax.data = $("#inputAuthor");
  if ($("#inputAuthor").val().length) {
    $.ajax(sendAjax);
  }
});

$("#isbn").keyup(function (event) {
  event.preventDefault();
  sendAjax.data = $("#inputIsbn");
  if ($("#inputIsbn").val().length) {
    $.ajax(sendAjax);
  }
});
