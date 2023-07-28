<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD']);

$servername = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_DATABASE'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];

try {
    $ConnectingDB = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $ConnectingDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Include the table creation scripts
    require_once __DIR__ . '/create_user_accounts.php';
    require_once __DIR__ . '/create_employee_accounts.php';
    require_once __DIR__ . '/create_catalog.php';

    try {
        // Call the functions to create the tables
        createUserAccountsTable($ConnectingDB);
        createEmployeeAccountsTable($ConnectingDB);
        createCatalogTable($ConnectingDB);

    } catch (PDOException $e) {
        // Display error and redirect to error page
        echo "Error creating tables: " . $e->getMessage();
        header("Location: error_page.php");
        exit;
    }
} catch (PDOException $e) {
    // Display error and redirect to error page
    echo "Connection failed: " . $e->getMessage();
    header("Location: error_page.php");
    exit;
}
?>
