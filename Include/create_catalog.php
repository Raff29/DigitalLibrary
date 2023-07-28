<?php
function createCatalogTable($ConnectingDB)
{
    $sqlCatalog = "CREATE TABLE IF NOT EXISTS catalog (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        author_dev_artist VARCHAR(255) NOT NULL,
        isbn VARCHAR(20) NOT NULL,
        available BOOLEAN DEFAULT 0,
        type VARCHAR(50) NOT NULL,
        image_link VARCHAR(255),
        item_link VARCHAR(255)
    )";
    
    // use exec() because no results are returned
    $ConnectingDB->exec($sqlCatalog);
}
?>
