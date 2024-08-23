<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION["logged_in"])) {
  // Redirect to the navigation page if logged in
  header('Location: ../vnd-admin-user/navigation.php');
  exit(); // Ensure script execution stops after redirection
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/login.css">

  <title>VMIMS</title>
</head>

<body>
  <div class="wrapper ">
    <div class="container main">
      <div class="row">

        <div class="col-md-6 side-image ">

          <h1 class="logo-text">VMEPD<h1>
              <h3 class="logo-desc">Volcano Monitoring Inventory and Management System<h3>
        </div>

        <div class="col-md-6 right ">
          <div class="input-box">

            <header>LOGIN</header>
            <form method="POST" id="admin-login-form">
              <div class="input-field">
                <input type="text" class="input" id="username" required="" autocomplete="off">
                <label for="username">Username</label>
              </div>
              <div class="input-field">
                <input type="password" class="input" id="pass" required="">
                <label for="pass">Password</label>
              </div>
              <div>
                <input type="checkbox" id="show-pass" onchange="togglePassword(event)">
                <label for="show-pass">Show Pasword</label>
              </div>
              <div class="input-field mt-3">
                <input type="submit" class="submit" value="Log In">
              </div>
              <div style="text-align: center;" class="mt-3">
                <span id="logStatus" style="display: inline-block; color: red;"></span>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="js/login.js"></script>
  <script>
    function togglePassword(event) {
      var value = event.target.checked;
      if (value) {
        $('#pass').attr('type', 'text')
      } else {
        $('#pass').attr('type', 'password')
      }
    }
  </script>
</body>

</html>