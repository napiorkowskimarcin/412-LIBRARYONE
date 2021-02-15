$("#title").keyup(function (event) {
  const path = "/book/show";
  event.preventDefault();
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
});

$("#author").keyup(function (event) {
  const path = "/book/show";
  event.preventDefault();
  $.ajax({
    ajax: true,
    type: "get",
    url: path,
    data: $("#inputAuthor"),
    dataType: "html", // for json response or 'html' for html response
    success: function (data) {
      response = JSON.parse(data);
      $("#table").html(response.template);
    },
  });
});
