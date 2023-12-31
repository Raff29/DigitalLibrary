<?php

/**
 * Login page of the file 
 */

session_start();
require_once("Include/db.php");

function login($type)
{
    global $ConnectingDB;
    $inputUsername = strtolower($_POST["{$type}-username"]);
    $inputPassword = $_POST["{$type}-password"];

    if (empty($inputUsername) || empty($inputPassword)) {
        return "Please add Valid Username or Password";
    }

    $sql = "SELECT * FROM {$type}_accounts WHERE username=:usernamE";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':usernamE', $inputUsername);
    $stmt->execute();

    $userExists = false;
    while ($DataRows = $stmt->fetch()) {
        $DBusername             = $DataRows["username"];
        $DBpassword             = $DataRows["password"];
        if ($inputUsername == $DBusername) {
            $userExists = true;
            if (password_verify($inputPassword, $DBpassword)) {
                $_SESSION["{$type}-username"] = $DBusername;
                header("Location: view-catalog.php");
                exit;
            } else {
                return "Incorrect Password";
            }
        }
    }
    if (!$userExists) {  
        return "User does not exist";
    }
}

if (!isset($_SESSION["user-username"]) && !isset($_SESSION["employee-username"])) {

    if (isset($_POST["user-submit"])) {
        $errorMsg = login("user");
    }

    if (isset($_POST["employee-submit"])) {
        $errorMsg = login("employee");
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
            .toggle-btn:before {
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

            .toggle-btn:checked:before {
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
                        <input type="text" placeholder="Ex. abc123" name="user-username" class="inp" />
                    </div>
                    <div class="input-group">
                        <span>Password</span>
                        <input type="password" placeholder="******" name="user-password" class="inp" />
                    </div>
                    <div class="input-group" style="margin-top: 20px;">
                        <input type="submit" value="Login as User" name="user-submit" class="inp submit-inp" />
                    </div>
                    <div class="input-group" style="margin-top: 20px;">
                        <input type="button" value="Go to Sign Up" class="inp submit-inp" onclick="window.location.href='index.php'" />
                    </div>
                </form>

            </div>
            <div class="employee-form">
                <h2>Employee Login</h2>
                <form class="" action="login.php" method="POST">
                    <div class="input-group">
                        <span>Username</span>
                        <input type="text" placeholder="Ex. abc123" name="employee-username" class="inp" />
                    </div>
                    <div class="input-group">
                        <span>Password</span>
                        <input type="password" placeholder="******" name="employee-password" class="inp" />
                    </div>
                    <div class="input-group" style="margin-top: 20px;">
                        <input type="submit" value="Login as Employee" name="employee-submit" class="inp submit-inp" />
                    </div>
                    <div class="input-group" style="margin-top: 20px;">
                        <input type="button" value="Go to Sign Up" class="inp submit-inp" onclick="window.location.href='index.php'" />
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