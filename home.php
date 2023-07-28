<?php

/**
 * The home Screen of the page.
 */

session_start();

// if user or employee is logged in
if (isset($_SESSION["user-username"]) || isset($_SESSION["employee-username"])) {

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Include/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous" async>
    </script>
    <title>Digi Lib</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link active" href="home.php"><i class="fa fa-fw fa-home"></i> Home</a> 
            <?php 
        
            // if employee logged in
            if (isset($_SESSION["employee-username"])) {

            ?>
                <a class="nav-link" href="insert-into-database.php"><i class="fa fa-fw fa-plus"></i> Insert</a>
                <a class="nav-link" href="view-catalog.php"><i class="fa fa-fw fa-search"></i> Catalog</a>
                <a class="nav-link" href="employee-profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
            <?php 

            // if customer logged in
            } else {

            ?>
                <a class="nav-link" href="view-catalog.php"><i class="fa fa-fw fa-search"></i> Catalog</a>
                <a class="nav-link" href="user-profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                <a class="nav-link" href="subscribe.php"><i class="fa fa-fw fa-check"></i> Subscribe</a>
            <?php

            }

            ?>
            <a class="nav-link" href="logout.php"><i class="fa fa-fw fa-lock"></i> Log out</a> 
          </div>
        </div>
      </div>
    </nav>

    <div class="name" align="center">
        <h1>Digi Lib</h1>
        <tagline>OTT for Libraries</tagline>
    </div>
    <br>

    <div class="pageButtons" align="center">
        <!-- <button><a href="Part_D/login.php"></a>Log-in</button>
        <button><a href="Part_D/index.php"></a>Sign-up</button> -->
        <!-- <button onclick="window.location.href='index.php'">Create an Account</button> -->
        <button onclick="window.location.href='logout.php'">Log-out</button>
    </div>
    
</body>
</html>


<?php 

// if not logged in
} else {

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Include/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous" async>
    </script>
    <title>Digi Lib</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link active" href="home.php"><i class="fa fa-fw fa-home"></i> Home</a> 
            <a class="nav-link" href="login.php"><i class="fa fa-fw fa-user"></i> Login</a>
            <a class="nav-link" href="index.php"><i class="fa fa-fw fa-user"></i> Signup</a>
          </div>
        </div>
      </div>
    </nav>

    <div class="name" align="center">
        <h1>Digi Lib</h1>
        <tagline>OTT for Libraries</tagline>
    </div>
    <br>

    <div class="pageButtons" align="center">
        <!-- <button><a href="Part_D/login.php"></a>Log-in</button>
        <button><a href="Part_D/index.php"></a>Sign-up</button> -->
        <!-- <button onclick="window.location.href='index.php'">Create an Account</button> -->
        <button onclick="window.location.href='login.php'">Log-in</button>
        <button onclick="window.location.href='index.php'">Sign-Up</button>
    </div>

</body>
</html>


<?php 

}

// EOF

?>

