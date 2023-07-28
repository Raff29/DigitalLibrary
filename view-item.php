<?php
session_start();
if (isset($_SESSION["employee-username"])) {
  // Needs to connect to database
  require_once "Include/db.php";

  function renderLink($url)
  {
    return "<a href=\"$url\" target=\"_blank\">Link</a>";
  }

  function renderAvailable($available)
  {
    return $available ? "Yes" : "No";
  }

  function renderImage($imageLink)
  {
    return "<img src=\"$imageLink\" alt=\"Item Image\" width=\"100\">";
  }

  function renderType($type)
  {
    return ucfirst($type); 
  }
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Catalog</title>
    <link rel="stylesheet" href="Include/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <style>
      body {
        background-color: #f8f9fa;
      }

      .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
      }

      table {
        width: 100%;
        border-collapse: collapse;
      }

      th,
      td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #ddd;
      }

      th {
        background-color: #f2f2f2;
      }

      tr {
        text-align: center;
      }

      tr:hover {
        background-color: #f2f2f2;
      }

      .edit-link,
      .delete-link {
        color: #007bff;
        text-decoration: none;
        margin-right: 8px;
      }

      .edit-link:hover,
      .delete-link:hover {
        text-decoration: underline;
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
    <h3 align="center">View from Database</h3>
    <?php
    global $ConnectingDB;
    // Check if the ID is provided in the query string
    if (isset($_GET['id'])) {
      $itemId = $_GET['id'];
      $sql = "SELECT * FROM catalog WHERE id = :itemId";
      $stmt = $ConnectingDB->prepare($sql);
      $stmt->bindValue(':itemId', $itemId);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        echo "<p>No item found with the provided ID.</p>";
      } else {
        $DataRows = $stmt->fetch();
        $Id = $DataRows["id"];
        $Name = $DataRows["name"];
        $Author_dev_artist = $DataRows["author_dev_artist"];
        $Type = $DataRows["type"];
        $ISBN = $DataRows["isbn"];
        $Available = renderAvailable($DataRows["available"]);
        $ImageLink = $DataRows["image_link"];
        $ItemLink = $DataRows["item_link"];
    ?>
        <table width="" border="5" align="center">
          <tr>
            <th>Name</th>
            <th>Author</th>
            <th>Type</th>
            <th>ISBN</th>
            <th>Item Link</th>
            <th>Available</th>
            <th>Image</th>
            <?php if (isset($_SESSION["employee-username"])) { ?>
              <th>Edit</th>
              <th>Delete</th>
            <?php } ?>
          </tr>
          <tr>
            <td><?php echo $Name; ?></td>
            <td><?php echo $Author_dev_artist; ?></td>
            <td><?php echo renderType($Type); ?></td>
            <td><?php echo $ISBN; ?></td>
            <td><?php echo renderLink($ItemLink); ?></td>
            <td><?php echo $Available; ?></td>
            <td><?php echo renderImage($ImageLink); ?></td>
            <?php if (isset($_SESSION["employee-username"])) { ?>
              <td><a href="edit.php?id=<?php echo $Id; ?>">Edit</a></td>
              <td><a href="delete.php?id=<?php echo $Id; ?>">Delete</a></td>
            <?php } ?>
          </tr>
        </table>
    <?php
      }
    } else {
      echo "<p>No item ID provided. Please provide an ID to view a specific item.</p>";
    }
    ?>
  </div>
</body>

</html>

<?php
} else {
  header("Location: home.php");
}
?>