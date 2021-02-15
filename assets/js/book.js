const path = "/book/show";

$("#title").keyup(function (event) {
  event.preventDefault();
  if ($("#inputTitle").val().length) {
    $.ajax({
      ajax: true,
      type: "get",
      url: path,
      data: $("#inputTitle"),
      dataType: "html", // for json response or 'html' for html response
      success: function (data) {
        response = JSON.parse(data);
        $("#table").html(response.template);
      },
    });
  }
});

$("#author").keyup(function (event) {
  event.preventDefault();
  if ($("#inputAuthor").val().length) {
    $.ajax({
      ajax: true,
      type: "get",
      url: path,
      data: $("#inputAuthor"),
      dataType: "html",
      success: function (data) {
        response = JSON.parse(data);
        $("#table").html(response.template);
      },
    });
  }
});

$("#isbn").keyup(function (event) {
  event.preventDefault();
  if ($("#inputIsbn").val().length) {
    $.ajax({
      ajax: true,
      type: "get",
      url: path,
      data: $("#inputIsbn"),
      dataType: "html",
      success: function (data) {
        response = JSON.parse(data);
        $("#table").html(response.template);
      },
    });
  }
});
