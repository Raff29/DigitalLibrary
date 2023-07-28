<?php 

/**
 * Logout page of the file.
 */

session_start();

session_unset();
session_destroy();

header("Location: index.php");

// EOF