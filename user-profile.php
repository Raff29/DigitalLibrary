<?php

session_start();
if (isset($_SESSION["user-username"])) {

  // needs to connect to database
  require_once "Include/db.php" ;
  $currentuser = $_SESSION["user-username"];
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous" async>
    </script>

  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link" aria-current="page" href="home.php"><i class="fa fa-fw fa-home"></i> Home</a>
            <a class="nav-link" href="view-catalog.php"><i class="fa fa-fw fa-search"></i> Catalog</a>
            <a class="nav-link active" href="user-profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
            <a class="nav-link" href="subscribe.php"><i class="fa fa-fw fa-check"></i> Subscribe</a>            
            <a class="nav-link" href="logout.php"><i class="fa fa-fw fa-lock"></i> Log out</a>
          </div>
        </div>
      </div>
    </nav>

    <?php


    global $ConnectingDB;
    $sql = "SELECT * From user_accounts WHERE username='$currentuser'";
    $stmt = $ConnectingDB->query($sql);
    while ($DataRows = $stmt->fetch()) {
      $Id             = $DataRows["id"];
      $Name           = $DataRows["name"];
      $billing_Address = $DataRows["billing_address"];
      $email          = $DataRows["email"];
      $credit_Card    = $DataRows["credit_card_number"];
      $cvv            = $DataRows["cvv"];
      $username       = $DataRows["username"];
      $password       = $DataRows["password"];
      $rented         = $DataRows["rented_catalog"];
      $subcription    = $DataRows["subscribed"];
    }
    ?>
      <!-- <form action="editUser.php" method="GET"></form> -->
      <div class="user-profile row">
        <div class="col-md-6">
          <label for="Name" class="form-label">Name</label>
          <input type="text" class="form-control" id="Name" name="Name placeholder=" John" value="<?php echo $Name; ?>" disabled />
        </div>
        <div class="col-md-6">
          <label for="Address" class="form-label">Billing Address</label>
          <input type="text" class="form-control" id="Address" name="Address" placeholder="1234 Main st" value="<?php echo $billing_Address; ?>"  disabled/>
        </div>
        <div class="col-md-6">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" placeholder="john.smith@gmail.com" name="email" value="<?php echo $email; ?>"  disabled/>
        </div>
        <div class="col-md-3">
          <label for="credit-card" class="form-label">Credit Card Number</label>
          <input type="text" class="form-control" id="credit-card" name="credit-card" value="<?php echo $credit_Card; ?>" disabled/>
        </div>
        <div class="col-md-3">
          <label for="cvv" class="form-label">CVV</label>
          <input type="text" class="form-control" id="cvv" name="cvv" value="<?php echo $cvv; ?>"  disabled/>
        </div>

        <div class="col-md-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="jsmith" value="<?php echo $username; ?>" disabled />
        </div>
        <div class="col-md-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>" disabled />
        </div>
        <div class="col-md-3">
          <label for="number" class="form-label">Items Rented: </label>
          <p><?php if ($rented == NULL) {
                echo "0";
              } else {
                echo "$rented";
              }
              ?></p>
        </div>
        <div class="col-md-3">
          <label for="subscription" class="form-label">Subscription: </label>
          <p><?php if ($subcription == 0) {
                echo "No subscription on file";
              } else {
                echo "Subscribed";
              }
              ?></p>
        </div>



      <div class="container">
        <div class="row justify-content-start">
          <div class="col-4">
            <button type="submit" class="btn btn-dark"><a class="text-decoration-none text-white" href="edit-user-profile.php?id=<?php echo $Id; ?>">Edit</a></button>
          </div>
        </div>
      </div>
      <!-- </form> -->
      <style>
        .user-profile {
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

<?php } else {
  header("Location: home.php");
} ?>

<!-- EOF -->
