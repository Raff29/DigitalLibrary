<?php

/**
 * Login page of the file 
*/

session_start(); 
require_once("Include/db.php");

// if user or employee is logged in.
if (!isset($_SESSION["user-username"]) || !isset($_SESSION["employee-username"])) {

    // checks if the user submits the button
    if (isset($_POST["user-submit"])) {
        $inputUsername = $_POST["user-username"];
        $inputPassword = $_POST["user-password"];

        // checks if the input field is not empty
        if (!empty($inputUsername) && !empty($inputPassword)) {

            $accountFound = 0;

            // $ConnectingDB from Include/DB.php
            global $ConnectingDB;
            $sql = "SELECT * FROM user_accounts WHERE username=:usernamE";
            $stmt = $ConnectingDB->prepare($sql);
            $stmt->bindValue(':usernamE', $inputUsername);
            $stmt->execute();

            // Loops through the database
            while ($DataRows = $stmt->fetch()) {
                $DBusername             = $DataRows["username"];
                $DBpassword             = $DataRows["password"];

                // Checks if the username and password verifies with the database
                if (($inputUsername == $DBusername) && password_verify($inputPassword, $DBpassword)) {
                    $_SESSION['user-username'] = $DBusername;
                    echo '<script>window.open("view-catalog.php","_self")</script>';
                    $accountFound = 1;
                }
            }

            // checks if the account found and print on html
            if ($accountFound == 0) {
                echo "<span class='FieldInfoHeading'>Sorry, Please Try Again</span>";
            }
        // print invalid statement.
        } else {
            echo "<span class='FieldInfoHeading'>Please add Valid Username or Password</span>";
        }
    }

    // checks if the employee submits the button
    if (isset($_POST["employee-submit"])) {
        $inputUsername = $_POST["employee-username"];
        $inputPassword = $_POST["employee-password"];

        // checks if the input field is not empty
        if (!empty($inputUsername) && !empty($inputPassword)) {

            $accountFound = 0;

            // $ConnectingDB from Include/DB.php
            global $ConnectingDB;
            $sql = "SELECT * FROM employee_accounts WHERE username=:usernamE";
            $stmt = $ConnectingDB->prepare($sql);
            $stmt->bindValue(':usernamE', $inputUsername);
            $stmt->execute();

            // Loops through the database
            while ($DataRows = $stmt->fetch()) {
                $DBusername             = $DataRows["username"];
                $DBpassword             = $DataRows["password"];

                // Checks if the username and password verifies with the database
                if (($inputUsername == $DBusername) && password_verify($inputPassword, $DBpassword)) {
                    $_SESSION['employee-username'] = $DBusername;
                    echo '<script>window.open("view-catalog.php","_self")</script>';
                    $accountFound = 1;
                }
            }

            // checks if the account found and print on html
            if ($accountFound == 0) {
                echo "<span class='FieldInfoHeading'>Sorry, Please Try Again</span>";
            }
        // print invalid statement.
        } else {
            echo "<span class='FieldInfoHeading'>Please add Valid Username or Password</span>";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log-in</title>
    <link rel="stylesheet" href="Include/style.css">
    <link rel="stylesheet" href="styletest.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous" async>
    </script>
    <style>
        
        .toggle-btn:before{
            content: 'Switch to Employee Login';
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
            content: 'Switch to Customer Login';
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
            <a class="nav-link active" href="login.php"><i class="fa fa-fw fa-user"></i> Login</a>
            <a class="nav-link" href="index.php"><i class="fa fa-fw fa-user"></i> Signup</a>
          </div>
        </div>
      </div>
    </nav>

    <div class="box">
    
       <input type="checkbox" class="toggle-btn" name="" />
       <div class="user-form">
       <h2>Customer Login</h2>
        <form class="" action="login.php" method="POST">
           <div class="input-group">
               <span>Username</span>
               <input type="text" placeholder="Ex. abc123" name="user-username" class="inp"/>
           </div>
           <div class="input-group">
               <span>Password</span>
               <input type="password" placeholder="******" name="user-password" class="inp"/>
           </div>
           <div class="input-group" style="margin-top: 20px;">
               <input type="submit" value="Login as User" name="user-submit" class="inp submit-inp" />
           </div>
           <div class="input-group" style="margin-top: 20px;">               
               <input type="button" value="Go to Sign Up" class="inp submit-inp" onclick="window.location.href='index.php'"/>
           </div>
        </form>
           
       </div>
       <div class="employee-form">
           <h2>Employee Login</h2>
            <form class="" action="login.php" method="POST">
                <div class="input-group">
                    <span>Username</span>
                    <input type="text" placeholder="Ex. abc123" name="employee-username" class="inp"/>
                </div>
                <div class="input-group">
                    <span>Password</span>
                    <input type="password" placeholder="******" name="employee-password" class="inp"/>
                </div>
                <div class="input-group" style="margin-top: 20px;">
                    <input type="submit" value="Login as Employee" name="employee-submit" class="inp submit-inp"/>
                </div>
                <div class="input-group" style="margin-top: 20px;">                    
                    <input type="button" value="Go to Sign Up" class="inp submit-inp" onclick="window.location.href='index.php'"/>
                </div>
           </form>
       </div>
    </div>
</body>

</html>

<?php 
 
// if not logged in
} else {
    header("Location: home.php"); // !---------- change
} 

// EOF

?>