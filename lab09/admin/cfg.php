<?php

// Ustawienia połączenia z bazą danych
$host = "localhost";  // Adres hosta bazy danych
$username = "root";  // Nazwa użytkownika bazy danych
$password = "";  // Hasło użytkownika bazy danych
$database = "moja_strona";  // Nazwa bazy danych

// Nawiązanie połączenia z bazą danych
$conn = mysqli_connect($host, $username, $password, $database);

// Sprawdzenie, czy połączenie zostało nawiązane
if (!$conn) {
    // Jeśli połączenie nie powiodło się, wyświetl komunikat o błędzie i zakończ skrypt
    die("Błąd połączenia: " . mysqli_connect_error());
}

// Ustawienia loginu i hasła dla administratora
$login = 'admin';  // Login administratora
$pass = '169222';  // Hasło administratora

?>
