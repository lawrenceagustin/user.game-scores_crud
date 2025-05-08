//delete review
$(document).ready(function () {
  $('.delete-button').on('click', function () {
    const form = $(this).closest('.delete-form');
    const reviewId = form.data('review-id');

    if (!confirm("Are you sure you want to delete this review?")) return;

    $.ajax({
      url: 'core/handleForms.php', 
      type: 'POST',
      data: {
        action: 'delete',
        review_id: reviewId
      },
      success: function (response) {
        if (response === 'success') {
          form.closest('.bg-gray-900').remove();
          location.reload(); 
        } else {
          alert('Delete failed. Please try again.');
        }
      },
      error: function () {
        alert('Delete failed. Please try again.');
      }
    });
  });
});

//submit review
$(document).ready(function () {
  $('#reviewForm').on('submit', function (e) {
    e.preventDefault();
    
    var formData = $(this).serialize();
  
    $.ajax({
      url: 'core/handleForms.php',
      type: 'POST',
      data: formData + '&action=submitReview', 
      dataType: 'json',
      success: function (response) {
        if (response.status === 'success') {
          alert(response.message);
          location.reload();
        } else {
          alert(response.message);
        }
      },
      error: function () {
        alert('Something went wrong! Please try again later.');
      }
    });
  });
});

//insert new review
$(document).ready(function () {
  $('#insertNewUser').on('submit', function (e) {
    e.preventDefault();
    
    var formData = $(this).serialize();
    
    $.ajax({
      url: 'core/handleForms.php',
      type: 'POST',
      data: formData + '&action=submitReview',
      dataType: 'json', 
      success: function (response) {
        if (response.status === 'success') {
          alert(response.message);
          location.reload();
        } else {
          alert(response.message);
        }
      },
      error: function () {
        alert('Something went wrong. Please try again!');
      }
    });
  });
});

//edit review
$(document).ready(function () {
  $('#updateReviewForm').on('submit', function (e) {
    e.preventDefault();

    const formData = $(this).serialize();

    $.ajax({
      url: 'core/handleForms.php',
      type: 'POST',
      data: formData,
      success: function (response) {
        if (response === 'success') {
          alert('Review updated successfully!');
          location.reload();
        } else {
          alert('Update failed.');
        }
      },
      error: function () {
        alert('Server error. Please try again.');
      }
    });
  });
});

//login - register
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


