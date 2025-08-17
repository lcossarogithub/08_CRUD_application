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

/* Code of the example not used
include 'functions.php';
$pdo = pdo_connect_mysql();
*/


$msg = '';
// Check that the contact ID exists
if (isset($_GET['id'])) {
    /* Code of the example not used
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    */
    // Prepare the select statement
    $sql = "SELECT * FROM contacts WHERE id = ?";
    if($stmt_select = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt_select, 'd', $_GET['id']);
        //echo "Contact Id:".$_GET['id'];
        if(mysqli_stmt_execute($stmt_select)){
            /* bind result variables */
            mysqli_stmt_bind_result($stmt_select, $id, $contact_name, $email, $phone, $title, $created);
            mysqli_stmt_fetch($stmt_select);
            mysqli_stmt_close($stmt_select);
            /*
            echo " - Contact name:".$contact_name;
            echo " - email:".$email;
            echo " - phone:".$phone;
            echo " - title:".$title;
            echo " - created:".$created;
            */
        }

    }


    if (!$id) {
        exit('Contact doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            /* Code of the example not used
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM contacts WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            */

            // Prepare the delete statement
            $sql = "DELETE FROM contacts WHERE id = ?";

            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, 'd', $_GET['id']);
                if(mysqli_stmt_execute($stmt)){
                    $msg = '<div class="card text-white bg-success mb-3" style="max-width: 20rem;">';
                    $msg = $msg.'<div class="card-header">Contact</div>';
                    $msg = $msg.'<div class="card-body">';
                    $msg = $msg.'<h4 class="card-title">Success</h4>';
                    $msg = $msg.'<p class="card-text">Contact successfully deleted</p>';
                    $msg = $msg.'</div>';
                    $msg = $msg.'</div>';
                } else {
                    $msg = '<div class="card text-white bg-danger mb-3" style="max-width: 20rem;">';
                    $msg = $msg.'<div class="card-header">Contact</div>';
                    $msg = $msg.'<div class="card-body">';
                    $msg = $msg.'<h4 class="card-title">Error</h4>';
                    $msg = $msg.'<p class="card-text">An error has occurred</p>';
                    $msg = $msg.'</div>';
                    $msg = $msg.'</div>';
                }
            }
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Demo: delete page</title>
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

    <div class="row">
        <div class="col-lg-6">
            <div class="bs-component">
                <legend>Delete contact #<?=$id?></legend>
                <p>Are you sure you want to delete contact #<?=$id?> <?=$contact_name?>?</p>

                <a href="delete.php?id=<?=$id?>&confirm=yes" class="btn btn-warning" role="button">Yes</a>
                <a href="delete.php?id=<?=$id?>&confirm=n" class="btn btn-danger" role="button">No</a>

                <?php if ($msg): ?>
                <p><?=$msg?></p>
                <?php endif; ?>
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

    <!-- <script src="./js/bootstrap.bundle.min.js"></script> -->
    <!-- <script src="./js/prism.js" data-manual></script> -->
    <!-- <script src="./js/custom.js"></script> -->
  </body>
</html>