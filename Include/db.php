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
  // set the PDO error mode to exception
  $ConnectingDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
      // Include the table creation scripts
      require_once __DIR__ . '/create_user_accounts.php';
      require_once __DIR__ . '/create_employee_accounts.php';
      require_once __DIR__ . '/create_catalog.php'; 
  try{
    // Call the functions to create the tables
      createUserAccountsTable($ConnectingDB);
      createEmployeeAccountsTable($ConnectingDB);
      createCatalogTable($ConnectingDB);
  
      echo "Tables created successfully";
  }
  catch(PDOException $e) {
      echo "Error creating tables: " . $e->getMessage();
  }

} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
