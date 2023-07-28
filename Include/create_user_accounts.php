<?php
function createUserAccountsTable($ConnectingDB) {
    $sqlUser = "CREATE TABLE IF NOT EXISTS user_accounts (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    billing_address VARCHAR(50),
    email VARCHAR(50),
    credit_card_number VARCHAR(16),
    cvv VARCHAR(3),
    username VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    rented_catalog VARCHAR(255),
    subscribed BOOLEAN DEFAULT 0
    )";

    // use exec() because no results are returned
    $ConnectingDB->exec($sqlUser);
}
?>
