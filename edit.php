<?php

session_start();

if (isset($_SESSION["user-username"]) || isset($_SESSION["employee-username"])) {

  require_once "Include/db.php";

  // shows the existing data in the table
  $SearchQuery = $_GET["id"];

  if (isset($_POST["Submit"])) {
    if (
      !empty($_POST["name"]) && !empty($_POST["author-dev-artist"]) && !empty($_POST["type"]) && !empty($_POST["isbn"]) &&
      !empty($_POST["available"]) && !empty($_POST["imageLink"]) && !empty($_POST["itemLink"])
    ) {
      $Name = $_POST["name"];
      $author_dev_artist = $_POST["author-dev-artist"];
      $type = $_POST["type"];
      $isbn = $_POST["isbn"];
      $available = $_POST["available"];
      $imageLink = $_POST["imageLink"];
      $itemLink = $_POST["itemLink"];

      global $ConnectingDB;
      $sql = "UPDATE catalog SET name='$Name', author_dev_artist='$author_dev_artist', isbn='$isbn', available='$available', image_link='$imageLink', item_link='$itemLink', type='$type' WHERE id='$SearchQuery'";
      $Execute = $ConnectingDB->query($sql);
      if ($Execute) {
        /**
         * sends the user back to the table 
         * self is so it won't open in a new window
         */
        echo '<script>window.open("view-catalog.php?id=Record Updated Successfully","_self")</script>';
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
    <title>Update Data into Database</title>
    <link rel="stylesheet" href="Include/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous" async></script>
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
            <a class="nav-link" aria-current="page" href="index.php"><i class="fa fa-fw fa-home"></i> Home</a>
            <a class="nav-link active" href="insert-into-database.php"><i class="fa fa-fw fa-plus"></i> Insert</a>
            <a class="nav-link" href="view-catalog.php"><i class="fa fa-fw fa-search"></i> Catalog</a>
            <a class="nav-link" href="employee-profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
            <a class="nav-link" href="logout.php"><i class="fa fa-fw fa-lock"></i> Log out</a>
          </div>
        </div>
      </div>
    </nav>

    <?php

    global $ConnectingDB;
    $sql = "SELECT * FROM catalog WHERE id='$SearchQuery'";
    $stmt = $ConnectingDB->query($sql);
    while ($DataRows = $stmt->fetch()) {
      $Name = $DataRows["name"];
      $author_dev_artist = $DataRows["author_dev_artist"];
      $type = $DataRows["type"];
      $isbn = $DataRows["isbn"];
      $available = $DataRows["available"];
      $imageLink = $DataRows["image_link"];
      $itemLink = $DataRows["item_link"];
    }

    ?>

    <div class="container">
      <h2>Edit Entry</h2>
      <form action="edit.php?id=<?php echo $SearchQuery; ?>" method="POST">
        <div class="form-group">
          <label for="name">Name:</label>
          <input type="text" name="name" id="name" required value="<?php echo $Name ?>">
        </div>

        <div class="form-group">
          <label for="author-dev-artist">Author:</label>
          <input type="text" name="author-dev-artist" id="author-dev-artist" required value="<?php echo $author_dev_artist ?>">
        </div>

        <div class="form-group">
          <label for="type">Type:</label>
          <input type="text" name="type" id="type" required value="<?php echo $type ?>">
        </div>
        <div class="form-group">
          <label for="isbn">ISBN:</label>
          <input type="text" name="isbn" id="isbn" required value="<?php echo $isbn ?>">
        </div>

        <div class="form-group">
          <label for="available">Available:</label>
          <select name="available" id="available">
            <option value=<?php echo $available ?>>Default</option>
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

<?php

} else {
  header("Location: index.php");

  // EOF

}

?>