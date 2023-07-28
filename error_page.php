<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if (isset($_GET['error'])) {
            $errorMessage = $_GET['error'];
            if ($errorMessage === 'connection') {
                echo "<h1>Connection Failed</h1>";
                echo "<p>There was an error connecting to the database. Please try again later.</p>";
            } elseif ($errorMessage === 'table_creation') {
                echo "<h1>Table Creation Failed</h1>";
                echo "<p>There was an error creating the database tables. Please try again later.</p>";
            } else {
                echo "<h1>Error</h1>";
                echo "<p>An unexpected error occurred. Please try again later.</p>";
            }
        } else {
            echo "<h1>Error</h1>";
            echo "<p>An unexpected error occurred. Please try again later.</p>";
        }
        ?>
    </div>
</body>
</html>
