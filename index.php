<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Demo: welcome page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./themes/prism-okaidia.css">
    <link rel="stylesheet" href="./css/custom.min.css">
    <!-- Global Site Tag (gtag.js) - Google Analytics -->
    <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-KGDJBEFF3W"></script> -->
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-KGDJBEFF3W');
    </script>
  </head>
  <body>
    <div class="navbar navbar-expand-lg fixed-top bg-primary" data-bs-theme="dark">
      <div class="container">
        <a href="./" class="navbar-brand">Demo</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="./read.php">Contacts</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./help.php">Help</a>
            </li>
          </ul>
          <ul class="navbar-nav ms-md-auto">
            <li class="nav-item">
                <a class="nav-link">Hi, <strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong>.</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="reset-password.php">Reset</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Sign Out</a>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="page-header" id="banner">
        <div class="row">
          <div class="col-lg-12 col-md-7 col-sm-6">
            <h1>Demo Bootswatch CRUD Application - Managed with Git</h1>
            <p class="lead">This is the welcome page</p>
          </div>
        </div>
      </div>

      <footer id="footer">
        <div class="row">
          <div class="col-lg-12">
            <p>Made by Luke.</p>
            <p>Code released under the Luke Non-Sense-License (2025).</p>
          </div>
        </div>
      </footer>
    </div>

    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/prism.js" data-manual></script>
    <script src="./js/custom.js"></script>
  </body>
</html>