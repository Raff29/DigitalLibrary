<?php
function createEmployeeAccountsTable($ConnectingDB) {
    $sqlEmployee = "CREATE TABLE IF NOT EXISTS employee_accounts (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL
    )";

    // use exec() because no results are returned
    $ConnectingDB->exec($sqlEmployee);
}
?>
