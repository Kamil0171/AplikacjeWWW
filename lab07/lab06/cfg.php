<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'moja_strona';

$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$link) {
    die('Connection failed: ' . mysqli_connect_error());
}
?>
