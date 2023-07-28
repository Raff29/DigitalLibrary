<?php
// needs to connet to database
require_once __DIR__ . "/Include/db.php";


if (isset($_POST["employee-submit"])) {
    if (!empty($_POST["employee-name"]) && !empty($_POST["employee-username"]) && !empty($_POST["employee-password"])) {
        $name = $_POST["employee-name"];
        $username = $_POST["employee-username"];
        $password = $_POST["employee-password"];


        global $ConnectingDB;

        // checks if the username exists in the database if it exists then <span> add unique username</span>
        $mySql = "SELECT * FROM employee_accounts WHERE username=:user";
        $search = $ConnectingDB->prepare($mySql);
        $search->bindValue(':user', $username);
        $search->execute();
        $DBusername = "";
        while ($DataRows = $search->fetch()) {
           $DBusername             = $DataRows["username"];
        }
        // ------------------------------------------------------------------------------------------

        if (strtolower($DBusername) != strtolower($username)) {
            $sql = "INSERT INTO employee_accounts(name, username, password) VALUES(:namE, :usernamE, :passworD)";
                    $stmt = $ConnectingDB->prepare($sql);
                    $stmt->bindValue(':namE', $name);
                    $stmt->bindValue(':usernamE', $username);
                    $stmt->bindValue(':passworD', password_hash($password, PASSWORD_DEFAULT));
            
            $Execute = $stmt->execute();
            if ($Execute) {
                echo '<span class="success">Account has been Created Successfully</span>';
                echo '<script>window.open("login.php","_self")</script>';
            }
        }
        else {
            echo "<span class='FieldInfoHeading'>Username Already Exists</span>";
        }
    } else {
        echo "<span class='FieldInfoHeading'>Please add Username and Password. OR have a Unique Username</span>";
    }
}


if (isset($_POST["user-submit"])) {
    if (!empty($_POST["user-name"]) && !empty($_POST["user-email"]) && !empty($_POST["user-username"]) && !empty($_POST["user-password"])) {
        $name = $_POST["user-name"];
        // $address = $_POST["user-address"];
        $email = $_POST["user-email"];
        // $creditCard = $_POST["user-creditCard"];
        // $cvv = $_POST["user-cvv"];
        $username = $_POST["user-username"];
        $password = $_POST["user-password"];


        global $ConnectingDB;

        // checks if the username exists in the database if it exists then <span> add unique username</span>
        $mySql = "SELECT * FROM user_accounts WHERE username=:user";
        $search = $ConnectingDB->prepare($mySql);
        $search->bindValue(':user', $username);
        $search->execute();
        $DBusername = "";
        while ($DataRows = $search->fetch()) {
           $DBusername             = $DataRows["username"];
        }
        // ------------------------------------------------------------------------------------------

        if (strtolower($DBusername) != strtolower($username)) {
            $sql = "INSERT INTO user_accounts(name, email, username, password) VALUES(:namE, :emaiL, :usernamE, :passworD)";
                    $stmt = $ConnectingDB->prepare($sql);
                    $stmt->bindValue(':namE', $name);
                    // $stmt->bindValue(':addresS', $address);
                    $stmt->bindValue(':emaiL', $email);
                    // $stmt->bindValue(':creditcarD', $creditCard);
                    // $stmt->bindValue(':cvV', $cvv);
                    $stmt->bindValue(':usernamE', $username);
                    $stmt->bindValue(':passworD', password_hash($password, PASSWORD_DEFAULT));
            
            $Execute = $stmt->execute();
            if ($Execute) {
                echo '<span class="success">Account has been Created Successfully</span>';
                echo '<script>window.open("login.php","_self")</script>';
            }
        }
        else {
            echo "<span class='FieldInfoHeading'>Username Already Exists</span>";
        }
    } else {
        echo "<span class='FieldInfoHeading'>Please add Username and Password. OR have a Unique Username</span>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-up</title>
    <link rel="stylesheet" href="Include/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous" async>
    </script>
    <style>
        .toggle-btn:before{
            content: 'Switch to Employee Signup';
            font-weight: bolder;
            position: absolute;
            top: 0;
            left: 25%;            
            height: 100%;
            border-radius: 100px;
            display: grid;
            place-items: center;
            transition: 0.5s;
        }

        .toggle-btn:checked:before{
            content: 'Switch to Customer Signup';
            left: 25%;
        }
    </style>
</head>

<body>    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link" href="home.php"><i class="fa fa-fw fa-home"></i> Home</a> 
            <a class="nav-link" href="login.php"><i class="fa fa-fw fa-user"></i> Login</a>
            <a class="nav-link active" href="index.php"><i class="fa fa-fw fa-user"></i> Signup</a>
          </div>
        </div>
      </div>
    </nav>

    <div class="box">
    
       <input type="checkbox" class="toggle-btn" name="" />
       <div class="user-form">
       <h2>Customer Signup</h2>
        <form class="" action="index.php" method="POST">
            <div class="input-group">
               <span>Name</span>
               <input type="text" placeholder="Ex. John Smith" name="user-name" class="inp"/>
           </div>
           <div class="input-group">
               <span>Email</span>
               <input type="email" placeholder="Ex. jsmith123@xyz.com" name="user-email" class="inp"/>
           </div>
           <!--
           <div class="input-group">
               <span>Billing Address</span>
               <input type="text" placeholder="Ex. 123 Markham Drive" name="user-address" class="inp"/>
           </div>
           <div class="input-group">
               <span>Credit Card Number</span>
               <input type="number" placeholder="" name="user-creditCard" class="inp"/>
           </div>
           <div class="input-group">
               <span>Credit Card CVV</span>
               <input type="text" placeholder="" name="user-cvv" class="inp"/>
           </div>
    -->
           <div class="input-group">
               <span>Username</span>
               <input type="text" placeholder="Ex. jsmith123" name="user-username" class="inp"/>
           </div>
           <div class="input-group">
               <span>Password</span>
               <input type="password" placeholder="******" name="user-password" class="inp"/>
           </div>
           <div class="input-group" style="margin-top: 20px;">
               <input type="submit" value="Signup as User" name="user-submit" class="inp submit-inp"/>
           </div>
           <div class="input-group" style="margin: 20px 0;">                    
                    <input type="button" value="Go to Login" class="inp submit-inp" onclick="window.location.href='login.php'"/>
                </div>
        </form>
           
       </div>
       <div class="employee-form">
           <h2>Employee Signup</h2>
            <form class="" action="index.php" method="POST">
                <div class="input-group">
                    <span>Name</span>
                    <input type="text" placeholder="Ex. Harry Potter" name="employee-name" class="inp"/>
                </div>
                <div class="input-group">
                    <span>Username</span>
                    <input type="text" placeholder="Ex. abc123" name="employee-username" class="inp"/>
                </div>
                <div class="input-group">
                    <span>Password</span>
                    <input type="password" placeholder="******" name="employee-password" class="inp"/>
                </div>
                <div class="input-group" style="margin-top: 20px;"> 
                    <input type="submit" value="Signup as Employee" name="employee-submit" class="inp submit-inp"/>
                </div>
                <div class="input-group" style="margin: 20px 0;">                    
                    <input type="button" value="Go to Login" class="inp submit-inp" onclick="window.location.href='login.php'"/>
                </div>
           </form>
       </div>
    </div>
</body>

</html>

<?php

//EOF 

?>
