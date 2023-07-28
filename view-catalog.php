<?php

session_start();
if (isset($_SESSION["employee-username"]) || isset($_SESSION["user-username"])) {

// needs to connect to database
require_once "Include/db.php" ;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View from Database</title>
    <link rel="stylesheet" href="Include/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous" async>
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link" href="home.php"><i class="fa fa-fw fa-home"></i> Home</a> 
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
                <a class="nav-link active" href="view-catalog.php"><i class="fa fa-fw fa-search"></i> Catalog</a>
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

    <h2 class="success">
        <!-- @ - won't show error when there is no id -->
        <?php echo @$_GET["id"]; ?>
    </h2>

    <div class="">
        <fieldset>
            <form class="" action="view-catalog.php" method="GET">
                <input type="text" name="search" value="" placeholder="Search by name or isbn">
                <br>
                <input type="submit" name="searchBtn" value="Search record">
            </form>
        </fieldset>
    </div>
    
    <form class="" action="view-catalog.php" method="POST">
        <label>Sort By: Name</label>
        <select name="sort-name">
            <option value = 'SORT_ASC'>By Ascending Order</option>
            <option value = 'SORT_DESC'>By Decending Order</option>
        </select>

        <label>Sort By: Type</label>
        <select name="sort-type">
            <option value = "all">By All</option>
            <option value = "book">By Book </option>
            <option value = "game">By Game</option>
        </select>

        <input type="submit" name="sort-submit" value="Sort">
    </form>
    

    <?php


    if (isset($_GET["searchBtn"])) {
        global $ConnectingDB;
        $Search = $_GET["search"];
        $sql = "SELECT * FROM catalog WHERE (`name` LIKE '%". $Search . "%') OR (`isbn`= '$Search')";
        $stmt = $ConnectingDB->prepare($sql);
        // $stmt->bindValue(':searcH', );
        $stmt->execute();

        while ($DataRows = $stmt->fetch()) {
            $Id                 = $DataRows["id"];
            $Name               = $DataRows["name"];
            $Author_dev_artist  = $DataRows["author_dev_artist"];
            $ISBN               = $DataRows["isbn"];
            $Available          = "No";
            if ($DataRows["available"]) {
                    $Available = "Yes";
                }
            $Type               = $DataRows["type"];
            
        ?>
            <div>
                <table width="1000" border="5" align="center">
                    <!-- <h3 align="center">Search Result</h3> -->
                    <tr>
                        <th>Name</th>
                        <th>Author | Dev | Artist</th>
                        <th>Type</th>
                        <th>ISBN</th>
                        <th>View Item</th>
                        <th>Available</th>
                        <?php if (isset($_SESSION["employee-username"])) { ?>
                        <th>Edit</th>
                        <th>Delete</th>
                        <?php 
                        }?>
                        <th>Search Again</th>
                    </tr>
                    <tr>
                        <td><?php echo $Name; ?></td>
                        <td><?php echo $Author_dev_artist; ?></td>
                        <td><?php echo $Type; ?></td>
                        <td><?php echo $ISBN; ?></td>
                        <td><a href= "view-item.php?id=<?php echo $Id?>">link</a></td>
                        <td><?php echo $Available; ?></td>
                        <?php if (isset($_SESSION["employee-username"])) { ?>
                        <td><a href= "edit.php?id=<?php echo $Id?>">Edit</a></td>
                        <td><a href= "delete.php?id=<?php echo $Id?>">Delete</a></td>
                        <?php 
                        }?>
                        <td> <a href="view-catalog.php">Search Again</a> </td>
                    </tr>
                </table>
            </div>

    <?php }
        }
    ?>

    <?php
    if (!isset($_GET["searchBtn"])) {
        ?>
        <table width="1000" border="5" align="center">
            <h3 align="center">View from Database</h3>
            <tr>
                <th>Name</th>
                <th>Author | Dev | Artist</th>
                <th>Type</th>
                <th>ISBN</th>
                <th>View Item</th>
                <th>Available</th>
                <?php if (isset($_SESSION["employee-username"])) {
                ?>
                <th>Edit</th>
                <th>Delete</th>
                <?php 
                }?>
            </tr>
            

            <?php

    
            global $ConnectingDB;

            $sort_asc_dec = "SORT_ASC";
            $sortType = "all";
            if (isset($_POST["sort-submit"])) {
                $sort_asc_dec = $_POST["sort-name"];
                $sortType = $_POST["sort-type"];
            }
            
     
            $sql = "SELECT * From catalog";
            $stmt = $ConnectingDB->query($sql);
            $listOfList = array();
            while ($DataRows = $stmt->fetch()) {
                $Id                 = $DataRows["id"];
                $Name               = $DataRows["name"];
                $Author_dev_artist  = $DataRows["author_dev_artist"];
                $ISBN               = $DataRows["isbn"];
                $Available          = "No";
                if ($DataRows["available"]) {
                    $Available = "Yes";
                }
                $Type               = $DataRows["type"];

                array_push($listOfList, array('id'=>$Id, 'name'=>$Name, 'author_dev_artist'=>$Author_dev_artist, 'type'=>$Type, 'isbn'=>$ISBN, 'available'=>$Available));
            }

            $allNames = array_column($listOfList, 'name');
            if ($sort_asc_dec == "SORT_DESC") {
                array_multisort($allNames, SORT_DESC, $listOfList);
            }
            else {
                array_multisort($allNames, SORT_ASC, $listOfList);
            }

          
            foreach($listOfList as $value) {
                $Id = $value['id'];
                $Name = $value['name'];
                $Author_dev_artist = $value['author_dev_artist'];
                $Type = $value['type'];
                $ISBN = $value['isbn'];
                $Available = $value['available'];

                if ($Type == $sortType || $sortType == "all") {
                    
                ?>
                    <tr>
                        <td><?php echo $Name; ?></td>
                        <td><?php echo $Author_dev_artist; ?></td>
                        <td><?php echo $Type; ?></td>
                        <td><?php echo $ISBN; ?></td>
                        <td><a href= "view-item.php?id=<?php echo $Id?>">link</a></td>
                        <td><?php echo $Available; ?></td>
                        <?php if (isset($_SESSION["employee-username"])) {
                        ?>
                        <td><a href= "edit.php?id=<?php echo $Id?>">Edit</a></td>
                        <td><a href= "delete.php?id=<?php echo $Id?>">Delete</a></td>
                        <?php 
                        }?>
                    </tr>
            <?php 
                }
            } ?>
        </table>
    </body>
    </html>

<?php
    }
 } else {
    header("Location: home.php");
} ?>

<!-- EOF -->
