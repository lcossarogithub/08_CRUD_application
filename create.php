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

//include 'functions.php';
//$pdo = pdo_connect_mysql();
$msg = '';

// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $contact_name = isset($_POST['contact_name']) ? $_POST['contact_name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');

    /*
    echo "Contact name:".$contact_name;
    echo " - email:".$email;
    echo " - phone:".$phone;
    echo " - title:".$title;
    echo " - created:".$created;
    
    // Insert new record into the contacts table
    //$stmt = $pdo->prepare('INSERT INTO contacts VALUES (?, ?, ?, ?, ?, ?)');
    //$stmt->execute([$id, $contact_name, $email, $phone, $title, $created]);
    // Output message
    //$msg = 'Created Successfully!';
    */

    // Prepare the insert statement
    // NOTA: fare attenzione al fatto che Visual Studio Code visualizza la stringa SQL come 
    // se NON FOSSE UNA STRINGA ma è corretto! Se si aggiungono due apici singoli 
    // all'inizio e alla fine viene generato un errore
    $sql = "INSERT INTO contacts (name, email, phone, title) VALUES (?, ?, ?, ?)"; 

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, 'ssss', $contact_name, $email, $phone, $title);
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $msg = '<div class="card text-white bg-success mb-3" style="max-width: 20rem;">';
            $msg = $msg.'<div class="card-header">Contact</div>';
            $msg = $msg.'<div class="card-body">';
            $msg = $msg.'<h4 class="card-title">Success</h4>';
            $msg = $msg.'<p class="card-text">Contact successfully created</p>';
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
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Demo: create page</title>
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
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                    <legend>Create a new contact</legend>
                    <div>
                        <fieldset disabled>
                        <label class="form-label" for="disabledInput">Id</label>
                        <input class="form-control" id="id" type="text" placeholder="(AUTO)" disabled>
                        </fieldset>
                    </div>
                    <div>
                        <label for="contact_name" class="form-label mt-4">Name</label>
                        <input type="text" class="form-control" id="contact_name" name="contact_name" aria-describedby="name" placeholder="John Doe">
                    </div>
                    <div>
                        <label for="email" class="form-label mt-4">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="email" placeholder="johndoe@example.com">
                    </div>
                    <div>
                        <label for="phone" class="form-label mt-4">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" aria-describedby="phone" placeholder="2025550143">
                    </div>
                    <div>
                        <label for="title" class="form-label mt-4">Title</label>
                        <input type="text" class="form-control" id="title" name="title" aria-describedby="title" placeholder="Employee">
                    </div>
                    <div>
                        <fieldset disabled>
                        <label class="form-label" for="disabledInput">Created</label>
                        <input class="form-control" id="created" name="created" type="text" value="<?=date('Y-m-d\TH:i')?>" disabled>
                        </fieldset>
                    </div>
                    <div></div>
                    <div>
                        <button type="submit" class="btn btn-primary">Create</button>
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