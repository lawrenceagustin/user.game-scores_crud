$('#insertNewUser').on('submit', function (event) {
  event.preventDefault();
  var formData = {
    first_name: $("#firstNameInput").val(),
    last_name: $("#lastNameInput").val(),
    email: $("#emailInput").val(),
    gender: $("#genderInput").val(),
    insertNewUser: 1
  };
  if (formData.first_name != "" && formData.last_name != "" && formData.email != "" && formData.gender != "") {
    $.ajax({
      type: "POST",
      url: "controller.php",
      data: formData,
      success: function (data) {
        location.reload();
      }
    })
  }
})

$('#inputFieldNameSearch').on('input', function (event) {
  $.ajax({
    method: "POST",
    url: "controller.php",
    data: {
      searchAUser: 1,
      keyword: $('#inputFieldNameSearch').val()
    },
    success: function (data) {
      if ($('#inputFieldNameSearch').val() != "" && data != "") {
        $('#loadData').html(data);
      } else {
        $('#loadData').html("<h2>No results found</h2>");
      }
    }
  })
}) 
