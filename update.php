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
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $contact_name = isset($_POST['contact_name']) ? $_POST['contact_name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
        /* Code of the example not used
        // Update the record
        $stmt = $pdo->prepare('UPDATE contacts SET id = ?, name = ?, email = ?, phone = ?, title = ?, created = ? WHERE id = ?');
        $stmt->execute([$id, $contact_name, $email, $phone, $title, $created, $_GET['id']]);
        */

        // Prepare the update statement
        $sql = "UPDATE contacts SET name = ?, email = ?, phone = ?, title = ? WHERE id = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, 'ssssd', $contact_name, $email, $phone, $title, $_GET['id']);

            /*            
            //echo "Contact Id:".$_GET['id'];
            echo " - Contact name:".$contact_name;
            echo " - email:".$email;
            echo " - phone:".$phone;
            echo " - title:".$title;
            echo " - created:".$created;
            */


            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $msg = '<div class="card text-white bg-success mb-3" style="max-width: 20rem;">';
                $msg = $msg.'<div class="card-header">Contact</div>';
                $msg = $msg.'<div class="card-body">';
                $msg = $msg.'<h4 class="card-title">Success</h4>';
                $msg = $msg.'<p class="card-text">Contact successfully updated</p>';
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

    }
    /* Code of the example not used
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    */
    // Prepare the select statement
    $sql = "SELECT * FROM contacts WHERE id = ?";
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, 'd', $_GET['id']);
        //echo "Contact Id:".$_GET['id'];
        if(mysqli_stmt_execute($stmt)){
            /* bind result variables */
            mysqli_stmt_bind_result($stmt, $id, $contact_name, $email, $phone, $title, $created);
            mysqli_stmt_fetch($stmt);
            /*
            echo " - Contact name:".$contact_name;
            echo " - email:".$email;
            echo " - phone:".$phone;
            echo " - title:".$title;
            echo " - created:".$created;
            */
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
    <title>Demo: update page</title>
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
                <form method="POST" action="update.php?id=<?=$id?>">
                    <legend>Update contact #<?=$id?></legend>
                    <div>
                        <fieldset disabled>
                        <label class="form-label" for="disabledInput">Id</label>
                        <input class="form-control" id="id" type="text" placeholder="(AUTO)" value="<?=$id?>" name="id" disabled>
                        </fieldset>
                    </div>
                    <div>
                        <label for="contact_name" class="form-label mt-4">Name</label>
                        <input type="text" class="form-control" id="contact_name" name="contact_name" aria-describedby="name" placeholder="John Doe" value="<?=$contact_name?>">
                    </div>
                    <div>
                        <label for="email" class="form-label mt-4">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="email" placeholder="johndoe@example.com" value="<?=$email?>">
                    </div>
                    <div>
                        <label for="phone" class="form-label mt-4">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" aria-describedby="phone" placeholder="2025550143" value="<?=$phone?>">
                    </div>
                    <div>
                        <label for="title" class="form-label mt-4">Title</label>
                        <input type="text" class="form-control" id="title" name="title" aria-describedby="title" placeholder="Employee" value="<?=$title?>">
                    </div>
                    <div>
                        <fieldset disabled>
                        <label class="form-label" for="disabledInput">Created</label>
                        <input class="form-control" id="created" name="created" type="text" value="<?=date('Y-m-d\TH:i', strtotime($created))?>" disabled>
                        </fieldset>
                    </div>
                    <div></div>
                    <div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
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