$("#search").keyup(function (event) {
  const path = "/author";
  event.preventDefault();
  if ($("#input").val().length) {
    $.ajax({
      ajax: true,
      type: "get",
      url: path,
      data: $("#input"),
      dataType: "html", // for json response or 'html' for html response
      success: function (data) {
        response = JSON.parse(data);
        $("#table").html(response.template);
      },
    });
  }
});
