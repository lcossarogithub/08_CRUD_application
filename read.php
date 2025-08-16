<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

// Include functions file
//require_once "functions.php";

	// Prepare a select statement
	$sql = "SELECT * FROM contacts ORDER BY id";

	$contacts = $link->execute_query($sql);

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Demo: products page</title>
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

      <!-- Tables
      ================================================== -->
      <div class="bs-docs-section">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-header">
              <h1 id="tables">Contacts</h1>
            </div>
            <a href="create.php" class="btn btn-info">Create Contact</a>
            <div class="bs-component">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Title</th>
                    <th scope="col">Created</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($contacts as $contact): ?>
                  <tr class="table-active">
                      <th scope="row"><?=$contact['id']?></th>
                      <td><?=$contact['name']?></td>
                      <td><?=$contact['email']?></td>
                      <td><?=$contact['phone']?></td>
                      <td><?=$contact['title']?></td>
                      <td><?=$contact['created']?></td>
                      <td>
                          <a href="update.php?id=<?=$contact['id']?>" class="btn btn-warning" role="button">update</a>
                          <a href="delete.php?id=<?=$contact['id']?>" class="btn btn-danger" role="button">delete</a>
                      </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div><!-- /example -->
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