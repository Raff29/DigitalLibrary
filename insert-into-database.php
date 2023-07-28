<?php

session_start();

if (isset($_SESSION["employee-username"])) {

// needs to connect to database
require_once "Include/db.php" ;


if (isset($_POST["Submit"])) {
    if (!empty($_POST["name"]) && !empty($_POST["author-dev-artist"]) && !empty($_POST["type"]) && !empty($_POST["isbn"]) &&
    !empty($_POST["available"]) && !empty($_POST["imageLink"]) && !empty($_POST["itemLink"])) {
        $Name = $_POST["name"];
        $author_dev_artist = $_POST["author-dev-artist"];
        $type = strtolower($_POST["type"]);
        $isbn = $_POST["isbn"];
        $available = $_POST["available"];
        $imageLink = $_POST["imageLink"];
        $itemLink = $_POST["itemLink"];

        global $ConnectingDB;
        $sql = "INSERT INTO catalog(name, author_dev_artist, isbn, available, image_link, item_link, type) VALUES(:namE, :authorDevArtisT, :isbN, :availablE, :imagelinK, :itemlinK, :typE)";
                $stmt = $ConnectingDB->prepare($sql);
                $stmt->bindValue(':namE', $Name);
                $stmt->bindValue(':authorDevArtisT', $author_dev_artist);
                $stmt->bindValue(':isbN', $isbn);
                $stmt->bindValue(':availablE', $available);
                $stmt->bindValue(':imagelinK', $imageLink);
                $stmt->bindValue(':itemlinK', $itemLink);
                $stmt->bindValue(':typE', $type);

        $Execute = $stmt->execute();
        if ($Execute) {
            echo '<span class="success">Record Has Added Successfully</span>';
        }
    } else {
        echo "<span class='FieldInfoHeading'> Please add Name and And other fields</span>";
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
</head>
<body>
    <!-- center the whole form using CSS -->
    <?php ?>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link" aria-current="page" href="home.php"><i class="fa fa-fw fa-home"></i> Home</a>
            <a class="nav-link active" href="insert-into-database.php"><i class="fa fa-fw fa-plus"></i> Insert</a>
            <a class="nav-link" href="view-catalog.php"><i class="fa fa-fw fa-search"></i> Catalog</a>
            <a class="nav-link" href="employee-profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>                     
            <a class="nav-link" href="logout.php"><i class="fa fa-fw fa-lock"></i> Log out</a>
          </div>
        </div>
      </div>
    </nav>

    <div class="">
        <form class="" action="insert-into-database.php" method="POST">
        <span class="FieldInfo">Name:</span>
                <br>
                <input type="text" name="name" value="">
                <br>
                <span class="FieldInfo">Author | Dev | Artist:</span>
                <br>
                <input type="text" name="author-dev-artist" value="">
                <br>
                <span class="FieldInfo">Type:</span>
                <br>
                <input type="text" name="type" value="">
                <br>
                <span class="FieldInfo">ISBN</span>
                <br>
                <input type="text" name="isbn" value="">
                <br>
                <span class="FieldInfo">Available</span>
                <br>
                <select name="available">
                    <option value = 1>Yes</option>
                    <option value = 0>No</option>
                </select>
                <br>     
                <span class="FieldInfo">Image Upload</span>
                <br>    
                <input type="file" name="imageLink" accept="image/*">
                <br>
                <span class="FieldInfo">Item Upload</span>
                <br>
                <input type="file" name="itemLink" accept=".pdf">
                <br>
                <input type="submit" name="Submit" value="Update your record">
            </fieldset>
        </form>
    </div>
</body>
</html>

<?php } else {
    header("Location: home.php");
} ?>

<!-- EOF -->
