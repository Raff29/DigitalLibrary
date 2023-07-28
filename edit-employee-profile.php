<?php

session_start();

if (isset($_SESSION["employee-username"])) {
// needs to connect to database
  require_once "Include/db.php";       

  $currentUser = $_GET["id"];



  if (isset($_POST["Submit"])) {
    if (
      !empty($_POST["Name"]) && !empty($_POST["password"])
    ) {
      $name = $_POST["Name"];
      $password = $_POST["password"];
      $hash = password_hash($password, PASSWORD_DEFAULT);

      global $ConnectingDB;
      $sql = "UPDATE employee_accounts SET name='$name',
      password='$hash' WHERE id='$currentUser'";
      $Execute = $ConnectingDB->query($sql);

      if ($Execute) {
        echo '<script>window.open("employee-profile.php?id="Record Update Successfully","_self")</script>';
      }
    } else {
      echo '<script>alert("Changes were not updated, please try again")</script>';
    }
  }

?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="Include/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous" async></script>

  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link" aria-current="page" href="home.php"><i class="fa fa-fw fa-home"></i> Home</a>
            <a class="nav-link" href="insert-into-database.php"><i class="fa fa-fw fa-plus"></i> Insert</a>
            <a class="nav-link" href="view-catalog.php"><i class="fa fa-fw fa-search"></i> Catalog</a>
            <a class="nav-link active" href="employee-profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>                     
            <a class="nav-link" href="logout.php"><i class="fa fa-fw fa-lock"></i> Log out</a>
          </div>
        </div>
      </div>
    </nav>

    <?php
    global $ConnectingDB;
    $sql = "SELECT * From employee_accounts WHERE id='$currentUser'";
    $stmt = $ConnectingDB->query($sql);
    while ($DataRows = $stmt->fetch()) {
      $Id             = $DataRows["id"];
      $Name           = $DataRows["name"];
      $username       = $DataRows["username"];
      $password       = $DataRows["password"];
    }

    ?>
    
    <div>
      <form class="" action="edit-employee-profile.php?id=<?php echo $currentUser; ?>"  method="POST">
        <div class="employee-profile row">
          <div class="col-md-6">
            <label for="Name" class="form-label">Name</label>
            <input type="text" class="form-control" id="Name" name="Name" placeholder=" John" value="<?php echo $Name; ?>" required />
          </div>
          
          <div class="col-md-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="jsmith" value="<?php echo $username; ?>" disabled />
          </div>
          <div class="col-md-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>" required />
          </div>
          
         
          <div class="container">
            <div class="row justify-content-middle">
              <div class="col-4">
                <button type="submit" name="Submit" class="btn btn-dark">
                  <?php
                  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    echo "Information Updated";
                  } else {
                    echo "Save";
                  } ?></button>
              </div>

            </div>
          </div>
        </div>



    </div>

    </form>

    </div>



    <style>
      .employee-profile {
        margin: 1rem;
      }

      .btn {
        margin-top: 1rem;
      }

      .form-label {
        padding-top: 10px;
      }
    </style>
  </body>

  </html>

<?php 

} else {
  header("Location: home.php");
} 

//EOF

?>

