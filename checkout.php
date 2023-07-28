<?php

session_start();
if (isset($_SESSION["user-username"])) {

  require_once("Include/db.php");

  $currentuser = $_SESSION["user-username"];

  $price = 9.99;

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
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
            <a class="nav-link" href="user-profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
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
            $Name = $DataRows["name"];
            $billing_Address = $DataRows["billing_address"];
            $credit_Card    = $DataRows["credit_card_number"];
            $cvv            = $DataRows["cvv"];
          
        }

    ?>

  <div class="checkout" align="center">
    <h2>Checkout<h2>
        <h4> Monthly Subscribtion fee CA $<?php echo $price?> </h4>
        <h4> Subtotal: CA $<?php echo $price?></h4>

  </div>
  <div class="box">
    <div class="input-group">
      <span>Name</span>
      <input type="text" class="inp" id="Name" name="Name" placeholder=" John" value="<?php echo $Name; ?>"
        disabled />
    </div>
 
    <!-- <div class="input-group">
               <span>Email</span>
               <input type="email" placeholder="Ex. jsmith123@xyz.com" name="user-email" class="inp"/>
           </div> -->
    <div class="input-group">
      <span>Billing Address</span>
      <input type="text" placeholder="Ex. 123 Markham Drive" name="Address" class="inp"
        value="<?php echo $billing_Address?>" disabled required/>
    </div>
    <div class="input-group">
      <span>Credit Card Number</span>
      <input type="number" placeholder="" name="credit-card" class="inp" value="<?php echo $credit_Card?>" disabled required/>
    </div>
    <div class="input-group">
      <span>Credit Card CVV</span>
      <input type="text" placeholder="" name="cvv" class="inp" value="<?php echo $cvv ?>" disabled required/>
    </div>

    <div class="input-group">        
        <input type="submit" value="Edit" class="inp submit-inp" onclick="window.location.href='edit-checkout.php?id=<?php echo $Id; ?>'"/>
        <input type="submit" value="Confirm" class="inp submit-inp" onclick="window.location.href='confirmation.php'"/>        
    </div>


  </div>


</body>

</html>


<?php 

} else {
  header("Location: home.php");

  // EOF

} 

?>