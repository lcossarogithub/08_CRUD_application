<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

//include 'functions.php';
//$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
    
    // Insert new record into the contacts table
    //$stmt = $pdo->prepare('INSERT INTO contacts VALUES (?, ?, ?, ?, ?, ?)');
    //$stmt->execute([$id, $name, $email, $phone, $title, $created]);
    // Output message
    //$msg = 'Created Successfully!';

    // Prepare the insert statement
    $sql = "'INSERT INTO contacts VALUES (?, ?, ?, ?, ?, ?)'";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, 'dssssd', $id, $name, $email, $phone, $title, $created);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $msg = 'Created Successfully!';
        } else {
            $msg = 'Something went wrong.';
        }
    }

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

    <div class="row">
        <div class="col-lg-6">
            <div class="bs-component">
                <form action="create.php" method="post">
                    <legend>Create a new contact</legend>

                    
                    <label for="id">ID</label>
                    <label for="name">Name</label>
                    <input type="text" name="id" placeholder="26" value="auto" id="id">
                    <input type="text" name="name" placeholder="John Doe" id="name">
                    <label for="email">Email</label>
                    <label for="phone">Phone</label>
                    <input type="text" name="email" placeholder="johndoe@example.com" id="email">
                    <input type="text" name="phone" placeholder="2025550143" id="phone">
                    <label for="title">Title</label>
                    <label for="created">Created</label>
                    <input type="text" name="title" placeholder="Employee" id="title">
                    <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i')?>" id="created">
                    <input type="submit" value="Create">
                    
                    <div>
                        <label for="email" class="form-label mt-4">Email address</label>
                        <input type="email" class="form-control" id="email" aria-describedby="email" placeholder="Enter email">
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

    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/prism.js" data-manual></script>
    <script src="./js/custom.js"></script>
  </body>
</html>