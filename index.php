<?php

require_once __DIR__ . "/Include/db.php";

session_start();

function createUser($name, $username, $password, $email, $tableName)
{
    global $ConnectingDB;

    $searchQuery = "SELECT * FROM $tableName WHERE username=:user";
    $search = $ConnectingDB->prepare($searchQuery);
    $search->bindValue(':user', $username);
    $search->execute();
    $DBusername = "";
    while ($DataRows = $search->fetch()) {
        $DBusername = $DataRows["username"];
    }

    if (strtolower($DBusername) != strtolower($username)) {
        $sql = "INSERT INTO $tableName(name, username, password, email) VALUES(:namE, :usernamE, :passworD, :emaiL)";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':namE', $name);
        $stmt->bindValue(':usernamE', $username);
        $stmt->bindValue(':passworD', password_hash($password, PASSWORD_ARGON2ID));
        $stmt->bindValue(':emaiL', $email);

        $Execute = $stmt->execute();
        if ($Execute) {
            $_SESSION['success'] = 'Account has been Created Successfully';
            header("Location: login.php");
            exit;
        }
    } else {
        echo "<span class='FieldInfoHeading'>Username Already Exists</span>";
    }
}

if (isset($_POST["employee-submit"])) {

    // Initialize error messages
    $_SESSION['name_error'] = '';
    $_SESSION['username_error'] = '';
    $_SESSION['password_error'] = '';
    $_SESSION['email_error'] = '';

    if (empty($_POST["employee-name"])) {
        $_SESSION['name_error'] = 'Name field is required';
    } else {
        $name = $_POST["employee-name"];
    }

    if (empty($_POST["employee-username"])) {
        $_SESSION['username_error'] = 'Username field is required';
    } else if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST["employee-username"])) {
        $_SESSION['username_error'] = 'Invalid username: Only letters and numbers allowed';
    } else {
        $username = $_POST["employee-username"];
    }

    if (empty($_POST["employee-password"])) {
        $_SESSION['password_error'] = 'Password field is required';
    } else if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $_POST["employee-password"])) {
        $_SESSION['password_error'] = 'Invalid password: Minimum eight characters, at least one letter and one number';
    } else {
        $password = $_POST["employee-password"];
    }

    if (empty($_POST["employee-email"])) {
        $_SESSION['email_error'] = 'Email field is required';
    } else if (!filter_var($_POST["employee-email"], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['email_error'] = 'Invalid email format';
    } else {
        $email = $_POST["employee-email"];
    }

    // If no error messages were set, create the user
    if (empty($_SESSION['name_error']) && empty($_SESSION['username_error']) && empty($_SESSION['password_error']) && empty($_SESSION['email_error'])) {
        createUser($name, $username, $password, $email, 'employee_accounts');
    }
}



if (isset($_POST["user-submit"])) {

    $_SESSION['name_error'] = '';
    $_SESSION['username_error'] = '';
    $_SESSION['password_error'] = '';
    $_SESSION['email_error'] = '';

    if (empty($_POST["user-name"])) {
        $_SESSION['name_error'] = 'Name field is required';
    } else {
        $name = $_POST["user-name"];
    }

    if (empty($_POST["user-username"])) {
        $_SESSION['username_error'] = 'Username field is required';
    } else if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST["user-username"])) {
        $_SESSION['username_error'] = 'Invalid username: Only letters and numbers allowed';
    } else {
        $username = $_POST["user-username"];
    }

    if (empty($_POST["user-password"])) {
        $_SESSION['password_error'] = 'Password field is required';
    } else if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $_POST["user-password"])) {
        $_SESSION['password_error'] = 'Invalid password: Minimum eight characters, at least one letter and one number';
    } else {
        $password = $_POST["user-password"];
    }

    if (empty($_POST["user-email"])) {
        $_SESSION['email_error'] = 'Email field is required';
    } else if (!filter_var($_POST["user-email"], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['email_error'] = 'Invalid email format';
    } else {
        $email = $_POST["user-email"];
    }

    // If no error messages were set, create the user
    if (empty($_SESSION['name_error']) && empty($_SESSION['username_error']) && empty($_SESSION['password_error']) && empty($_SESSION['email_error'])) {
        createUser($name, $username, $password, $email, 'user_accounts');
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
        .error {
            color: red;
        }

        .toggle-btn:before {
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

        .toggle-btn:checked:before {
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
                    <input type="text" placeholder="Ex. John Smith" name="user-name" class="inp" />
                </div>
                <div class="input-group">
                    <span>Email</span>
                    <input type="email" placeholder="Ex. jsmith123@xyz.com" name="user-email" class="inp" />
                    <?php
                    if (isset($_SESSION['email_error'])) {
                        echo "<div class='error'>{$_SESSION['email_error']}</div>";
                        unset($_SESSION['email_error']);
                    }
                    ?>
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
                    <input type="text" placeholder="Ex. jsmith123" name="user-username" class="inp" />
                    <?php
                    if (isset($_SESSION['username_error'])) {
                        echo "<div class='error'>{$_SESSION['username_error']}</div>";
                        unset($_SESSION['username_error']);
                    }
                    ?>
                </div>
                <div class="input-group">
                    <span>Password</span>
                    <input type="password" placeholder="******" name="user-password" class="inp" />
                    <?php
                    if (isset($_SESSION['password_error'])) {
                        echo "<div class='error'>{$_SESSION['password_error']}</div>";
                        unset($_SESSION['password_error']);
                    }
                    ?>
                </div>
                <div class="input-group" style="margin-top: 20px;">
                    <input type="submit" value="Signup as User" name="user-submit" class="inp submit-inp" />
                </div>
                <div class="input-group" style="margin: 20px 0;">
                    <input type="button" value="Go to Login" class="inp submit-inp" onclick="window.location.href='login.php'" />
                </div>
            </form>

        </div>
        <div class="employee-form">
            <h2>Employee Signup</h2>
            <form class="" action="index.php" method="POST">
                <div class="input-group">
                    <span>Name</span>
                    <input type="text" placeholder="Ex. Harry Potter" name="employee-name" class="inp" />

                </div>
                <div class="input-group">
                    <span>Email</span>
                    <input type="email" placeholder="Ex. hpotter@hogwarts.com" name="employee-email" class="inp" />
                    <?php
                    if (isset($_SESSION['email_error'])) {
                        echo "<div class='error'>{$_SESSION['email_error']}</div>";
                        unset($_SESSION['email_error']);
                    }
                    ?>
                </div>
                <div class="input-group">
                    <span>Username</span>
                    <input type="text" placeholder="Ex. abc123" name="employee-username" class="inp" />
                    <?php
                    if (isset($_SESSION['username_error'])) {
                        echo "<div class='error'>{$_SESSION['username_error']}</div>";
                        unset($_SESSION['username_error']);
                    }
                    ?>
                </div>
                <div class="input-group">
                    <span>Password</span>
                    <input type="password" placeholder="******" name="employee-password" class="inp" />
                    <?php
                    if (isset($_SESSION['password_error'])) {
                        echo "<div class='error'>{$_SESSION['password_error']}</div>";
                        unset($_SESSION['password_error']);
                    }
                    ?>
                </div>
                <div class="input-group" style="margin-top: 20px;">
                    <input type="submit" value="Signup as Employee" name="employee-submit" class="inp submit-inp" />
                </div>
                <div class="input-group" style="margin: 20px 0;">
                    <input type="button" value="Go to Login" class="inp submit-inp" onclick="window.location.href='login.php'" />
                </div>
            </form>
        </div>
    </div>
</body>

</html>

<?php

//EOF 

?>