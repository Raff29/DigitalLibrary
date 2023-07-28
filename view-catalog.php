<?php

session_start();
if (isset($_SESSION["employee-username"]) || isset($_SESSION["user-username"])) {

    require_once "Include/db.php";
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Catalog</title>
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

            .search-and-sort {
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 20px;
            }

            .sort-form {
                display: flex;
                align-items: center;
            }

            .search-form input[type="text"],
            .sort-form select {
                padding: 8px;
                font-size: 16px;
                border: 1px solid #ddd;
                border-radius: 5px;
            }

            .search-form input[type="submit"],
            .sort-form input[type="submit"] {
                padding: 8px 16px;
                font-size: 16px;
                border: none;
                border-radius: 5px;
                background-color: #007bff;
                color: #fff;
                cursor: pointer;
                margin-left: 15px;
            }

            .sort-form input[type="submit"] {
                margin-right: 15px;
            }

            .sort-form label {
                font-weight: bold;
            }

            .sort-form input[type="submit"]:hover {
                background-color: #0056b3;
            }
        </style>

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

        <div class="search-and-sort">
            <div class="sort-form">
                <label for="sort-type">Sort By: Type</label>
                <select name="sort-type" id="sort-type">
                    <option value="all">By All</option>
                    <option value="book">By Book</option>
                    <option value="game">By Game</option>
                </select>
                <input type="submit" name="sort-submit" value="Sort">
            </div>

            <div class="search-form">
                <fieldset>
                    <form action="view-catalog.php" method="GET">
                        <input type="text" name="search" value="" placeholder="Search by name or ISBN">
                        <input type="submit" name="searchBtn" value="Search Record">
                    </form>
                </fieldset>
            </div>
        </div>

        <?php


        if (isset($_GET["searchBtn"])) {
            global $ConnectingDB;
            $Search = $_GET["search"];
            $sql = "SELECT * FROM catalog WHERE (`name` LIKE '%" . $Search . "%') OR (`isbn`= '$Search')";
            $stmt = $ConnectingDB->prepare($sql);
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
                <div class="container">
                    <table width="1000" border="5" align="center">
                        <tr>
                            <th>Name</th>
                            <th>Author</th>
                            <th>Type</th>
                            <th>ISBN</th>
                            <th>View Item</th>
                            <th>Available</th>
                            <?php if (isset($_SESSION["employee-username"])) { ?>
                                <th>Edit</th>
                                <th>Delete</th>
                            <?php
                            } ?>
                            <th>Search Again</th>
                        </tr>
                        <tr>
                            <td><?php echo $Name; ?></td>
                            <td><?php echo $Author_dev_artist; ?></td>
                            <td><?php echo $Type; ?></td>
                            <td><?php echo $ISBN; ?></td>
                            <td><a href="view-item.php?id=<?php echo $Id ?>">link</a></td>
                            <td><?php echo $Available; ?></td>
                            <?php if (isset($_SESSION["employee-username"])) { ?>
                                <td><a href="edit.php?id=<?php echo $Id ?>">Edit</a></td>
                                <td><a href="delete.php?id=<?php echo $Id ?>">Delete</a></td>
                            <?php
                            } ?>
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
            <div class="container">
                <table width="1000" border="5" align="center">
                    <h3 align="center">View from Database</h3>
                    <tr>
                        <th>Name</th>
                        <th>Author</th>
                        <th>Type</th>
                        <th>ISBN</th>
                        <th>View Item</th>
                        <th>Available</th>
                        <?php if (isset($_SESSION["employee-username"])) {
                        ?>
                            <th>Edit</th>
                            <th>Delete</th>
                        <?php
                        } ?>
                    </tr>


                    <?php


                    global $ConnectingDB;

                    $sort_asc_dec = SORT_ASC;
                    if (isset($_POST["sort-submit"])) {
                        $sort_asc_dec = ($_POST["sort-name"] === 'SORT_DESC') ? SORT_DESC : SORT_ASC;
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

                        array_push($listOfList, array(
                            'id' => $Id,
                            'name' => $Name,
                            'author_dev_artist' => $Author_dev_artist,
                            'type' => $Type,
                            'isbn' => $ISBN,
                            'available' => $Available
                        ));
                    }

                    $allNames = array_column($listOfList, 'name');
                    if ($sort_asc_dec == SORT_DESC) {
                        array_multisort($allNames, SORT_DESC, $listOfList);
                    } else {
                        array_multisort($allNames, SORT_ASC, $listOfList);
                    }

                    $sortType = isset($_POST['sort-type']) ? $_POST['sort-type'] : 'all';


                    foreach ($listOfList as $value) {
                        $Id = $value['id'];
                        $Name = $value['name'];
                        $Author_dev_artist = $value['author_dev_artist'];
                        $Type = $value['type'];
                        $ISBN = $value['isbn'];
                        $Available = $value['available'];

                        if ($Type == $sortType || $sortType == 'all' || ($sortType == 'game' && $Type != 'book')) {
                    ?>
                            <tr>
                                <td><?php echo $Name; ?></td>
                                <td><?php echo $Author_dev_artist; ?></td>
                                <td><?php echo $Type; ?></td>
                                <td><?php echo $ISBN; ?></td>
                                <td><a href="view-item.php?id=<?php echo $Id ?>">link</a></td>
                                <td><?php echo $Available; ?></td>
                                <?php if (isset($_SESSION["employee-username"])) {
                                ?>
                                    <td><a href="edit.php?id=<?php echo $Id ?>">Edit</a></td>
                                    <td><a href="delete.php?id=<?php echo $Id ?>">Delete</a></td>
                                <?php
                                } ?>
                            </tr>
                    <?php
                        }
                    } ?>
                </table>
            </div>
    </body>

    </html>

<?php
        }
    } else {
        header("Location: home.php");
    } ?>

<!-- EOF -->