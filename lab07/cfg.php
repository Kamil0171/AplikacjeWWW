<?php

$conn = mysqli_connect("localhost", "root", "", "moja_strona");
$login = 'admin';
$pass = '169222';

if (!$conn) {
    die("Błąd połączenia: " . mysqli_connect_error());
}

?>