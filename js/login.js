$(document).ready(function () {
  $("#admin-login-form").submit(function (event) {
    event.preventDefault();

    // Get input values
    var uname = $("#username").val();
    var password = $("#pass").val();

    if (!isValidUsername(uname)) {
      $("#logStatus").text("Incorrect credentials");
      return;
    }

    if (!isValidPassword(password)) {
      $("#logStatus").text("Incorrect credentials");
      return;
    }
    $.ajax({
      type: "POST",
      url: "verify_login.php",
      data: {
        uname: uname,
        password: password,
      },
      dataType: "json",
      success: function (response) {
        var alertDiv = $("#logStatus");

        if (response.status === "success") {
          console.log("yes");
          window.location.href = response.redirect;
        } else {
          alertDiv.text(response.message);
        }
      },
      error: function (xhr, textStatus, errorThrown) {
        console.error(xhr.responseText);
        // Handle error cases if needed
      },
    });
  });

  // Validate username
  function isValidUsername(uname) {
    if (uname.length < 6 || uname.length > 50) {
      return false;
    }
    var sqlRegex = /[;'"\\()|*+--]/;
    if (sqlRegex.test(uname)) {
      return false;
    }
    return true;
  }

  // Validate password
  function isValidPassword(password) {
    // Password validation logic here (e.g., minimum length)
    return password.length >= 8;
  }
});
