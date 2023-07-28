<?php
session_start();

if (isset($_SESSION["employee-username"])) {

    // needs to connect to database
    require_once "Include/db.php";

    if (isset($_POST["Submit"])) {
        if (
            !empty($_POST["name"]) && !empty($_POST["author-dev-artist"]) && !empty($_POST["type"]) && !empty($_POST["isbn"]) &&
            isset($_POST["available"]) && !empty($_POST["imageLink"]) && !empty($_POST["itemLink"])
        ) {
            $Name = $_POST["name"];
            $author_dev_artist = $_POST["author-dev-artist"];
            $type = strtolower($_POST["type"]);
            $isbn = $_POST["isbn"];
            $available = $_POST["available"];
            $imageLink = $_POST["imageLink"];
            $itemLink = $_POST["itemLink"];

            global $ConnectingDB;
            $sql = "INSERT INTO catalog(name, author_dev_artist, isbn, available, image_link, item_link, type) 
                    VALUES(:name, :author_dev_artist, :isbn, :available, :imageLink, :itemLink, :type)";
            $stmt = $ConnectingDB->prepare($sql);
            $stmt->bindValue(':name', $Name);
            $stmt->bindValue(':author_dev_artist', $author_dev_artist);
            $stmt->bindValue(':isbn', $isbn);
            $stmt->bindValue(':available', $available);
            $stmt->bindValue(':imageLink', $imageLink);
            $stmt->bindValue(':itemLink', $itemLink);
            $stmt->bindValue(':type', $type);

            $Execute = $stmt->execute();
            if ($Execute) {
                echo '<span class="success">Record Has Added Successfully</span>';
            }
        } else {
            echo "<span class='FieldInfoHeading'> Please add Name and other fields</span>";
        }
    }

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Insert Data into Database</title>
        <link rel="stylesheet" href="Include/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous" async>
        </script>
        <style>
            body {
                background-color: #f8f9fa;
            }

            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background-color: #ffffff;
                border-radius: 5px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .form-group {
                margin-bottom: 20px;
            }

            .form-group label {
                font-weight: bold;
            }

            .form-group input[type="text"],
            .form-group select {
                width: 100%;
                padding: 10px;
                border: 1px solid #ced4da;
                border-radius: 5px;
                outline: none;
            }

            .form-group input[type="submit"] {
                background-color: #007bff;
                color: #fff;
                border: none;
                border-radius: 5px;
                padding: 10px 20px;
                cursor: pointer;
            }

            .form-group input[type="submit"]:hover {
                background-color: #0056b3;
            }

            .success {
                color: #28a745;
                font-weight: bold;
            }

            .error {
                color: #dc3545;
                font-weight: bold;
            }
        </style>
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

        <div class="container">
            <h2>Insert Data into Database</h2>
            <form action="insert-into-database.php" method="POST">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" required>
                </div>

                <div class="form-group">
                    <label for="author-dev-artist">Author | Dev | Artist:</label>
                    <input type="text" name="author-dev-artist" id="author-dev-artist" required>
                </div>

                <div class="form-group">
                    <label for="type">Type:</label>
                    <input type="text" name="type" id="type" required>
                </div>

                <div class="form-group">
                    <label for="isbn">ISBN:</label>
                    <input type="text" name="isbn" id="isbn" required>
                </div>

                <div class="form-group">
                    <label for="available">Available:</label>
                    <select name="available" id="available">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="imageLink">Image URL:</label>
                    <input type="text" name="imageLink" id="imageLink" required>
                </div>

                <div class="form-group">
                    <label for="itemLink">Item URL (PDF):</label>
                    <input type="text" name="itemLink" id="itemLink" required>
                </div>

                <input type="submit" name="Submit" value="Update your record">
            </form>
        </div>
    </body>

    </html>
<?php } else {
    header("Location: home.php");
} ?>

<!-- EOF -->