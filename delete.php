<?php

session_start();
if (isset($_SESSION["user-username"]) || isset($_SESSION["employee-username"])) {
    
require_once "Include/db.php";

// shows the existing data in the table
$SearchQuery = $_GET["id"]; 

    global $ConnectingDB;
    $sql = "DELETE FROM catalog WHERE id='$SearchQuery'";
    $Execute = $ConnectingDB->query($sql);
    if ($Execute) {
        /**
         * sends the user back to the table 
         * _self is so it won't open in a new window
         */
        echo '<script>window.open("view-catalog.php?id=Record Deleted Successfully","_self")</script>';
    }

?>

<?php 

} else {
    header("Location: index.php");

    // EOF

} ?>