<?php

// Rozpoczęcie sesji
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany jako administrator
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    // Zakończenie sesji, jeśli użytkownik jest zalogowany
    session_destroy();  // Zniszczenie wszystkich danych sesji
    header('Location: ./admin.php');  // Przekierowanie na stronę administracyjną po wylogowaniu
} else {
    // Jeśli użytkownik nie jest zalogowany, przekierowanie na stronę administracyjną
    header('Location: ./admin.php');
}

?>
