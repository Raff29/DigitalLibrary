<?php

session_start();

if (isset($_SESSION["user-username"])) {

  // needs to connect to database
  require_once "Include/db.php";

  $currentUser = $_GET["id"];
  
  // get info from the database
  global $ConnectingDB;
  $sql = "SELECT * From user_accounts WHERE id='$currentUser'";
  $stmt = $ConnectingDB->query($sql);
  while ($DataRows = $stmt->fetch()) {
    $database_name           = $DataRows["name"];
    $database_billing_address = $DataRows["billing_address"];
    $database_credit_card    = $DataRows["credit_card_number"];
    $database_cvv            = $DataRows["cvv"];
  }


  $price = 9.99;


  if (isset($_POST["Submit"])) {
    if (
      !empty($_POST["Address"]) &&
      !empty($_POST["credit-card"]) &&
      !empty($_POST["cvv"])
    ) {
      $address = $_POST["Address"];
      $credit_card = $_POST["credit-card"];
      $cvv = $_POST["cvv"];

      if ((($cvv == $database_cvv && $credit_card == $database_credit_card) || ($database_cvv == null && $database_credit_card == null)) && (strlen($credit_card) == 16 && strlen($cvv) == 3)) {

        global $ConnectingDB;
        $sql = "UPDATE user_accounts SET billing_address='$address', credit_card_number='$credit_card', cvv='$cvv' WHERE id='$currentUser'";
        $Execute = $ConnectingDB->query($sql);

        if ($Execute) {
          echo '<script>window.open("confirmation.php","_self")</script>';
        } else {
          echo '<script>alert("Changes were not updated, please try again")</script>';
        }
      }
      else {
        echo '<script>alert("please Add valid Card Number or CVV number")</script>';
      }
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous" async>
  </script>

</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link" aria-current="page" href="home.php"><i class="fa fa-fw fa-home"></i> Home</a>
            <a class="nav-link" href="view-catalog.php"><i class="fa fa-fw fa-search"></i> Catalog</a>
            <a class="nav-link" href="user-profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
            <a class="nav-link" href="subscribe.php"><i class="fa fa-fw fa-check"></i> Subscribe</a>            
            <a class="nav-link" href="logout.php"><i class="fa fa-fw fa-lock"></i> Log out</a>
          </div>
        </div>
      </div>
    </nav>

  <div class="checkout" align="center">
    <h2>Checkout<h2>
        <h4> Monthly Subscribtion fee CA $<?php echo $price?> </h4>
        <h4> Subtotal: CA $<?php echo $price?></h4>

  </div>
  <div>
    <form class="" action="edit-checkout.php?id=<?php echo $currentUser; ?>" method="POST">
      <div class="box">

        <div class="input-group">
          <span>Name</span>
          <input type="text" class="inp" id="Name" name="Name" placeholder=" John"
            value="<?php echo $database_name; ?>" disabled />
        </div>

        <!-- <div class="input-group">
               <span>Email</span>
               <input type="email" placeholder="Ex. jsmith123@xyz.com" name="user-email" class="inp"/>
           </div> -->
        <div class="input-group">
          <span>Billing Address</span>
          <input type="text" placeholder="Ex. 123 Markham Drive" name="Address" class="inp"
            value="<?php echo $database_billing_address?>" required/>
        </div>
        <div class="input-group">
          <span>Credit Card Number</span>
          <input type="number" placeholder="" name="credit-card" class="inp" value="<?php echo $database_credit_card?>"
            required />
        </div>
        <div class="input-group">
          <span>Credit Card CVV</span>
          <input type="password" placeholder="" name="cvv" class="inp" value="<?php echo $database_cvv ?>" requried/>
        </div>

        <div class="input-group">
          <a><input type="submit" name="Submit" value="Confirm and Pay" class="inp submit-inp" /></a>
        </div>


      </div>
    </form>

  </div>


</body>

</html>

<?php 

} else {
  header("Location: home.php");

  // EOF

} 

?>