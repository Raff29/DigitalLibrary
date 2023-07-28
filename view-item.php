<?php
session_start();
if (isset($_SESSION["employee-username"])) {
    // Needs to connect to database
    require_once "Include/db.php";

    function renderLink($url) {
        return "<a href=\"$url\" target=\"_blank\">Link</a>";
    }

    function renderAvailable($available) {
        return $available ? "Yes" : "No";
    }

    function renderImage($imageLink) {
        return "<img src=\"$imageLink\" alt=\"Item Image\" width=\"100\">";
    }

    function renderType($type) {
        return ucfirst($type); // Capitalize the type for display
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add your head section if needed -->
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
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
    </nav>

    <!-- ... (existing code) -->

    <?php
        // Query the database and fetch items
        global $ConnectingDB;
        $sql = "SELECT * FROM catalog";
        $stmt = $ConnectingDB->query($sql);

        if ($stmt->rowCount() === 0) {
            echo "<p>No items found in the catalog.</p>";
        } else {
    ?>
        <table width="1000" border="5" align="center">
            <h3 align="center">View from Database</h3>
            <tr>
                <th>Name</th>
                <th>Author | Dev | Artist</th>
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
            
            <?php
                while ($DataRows = $stmt->fetch()) {
                    $Id = $DataRows["id"];
                    $Name = $DataRows["name"];
                    $Author_dev_artist = $DataRows["author_dev_artist"];
                    $Type = $DataRows["type"];
                    $ISBN = $DataRows["isbn"];
                    $Available = renderAvailable($DataRows["available"]);
                    $ImageLink = $DataRows["image_link"];
                    $ItemLink = $DataRows["item_link"];
            ?>
            
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

            <?php } ?>
        </table>
    <?php
        }
    ?>

</body>
</html>

<?php
} else {
    header("Location: home.php");
}
?>
