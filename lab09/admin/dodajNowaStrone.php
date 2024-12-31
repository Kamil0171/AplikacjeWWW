<?php

// Dołączenie pliku konfiguracyjnego, który zawiera ustawienia połączenia z bazą danych
include('./cfg.php');

// Sprawdzenie, czy formularz został wysłany i czy wymagane dane są dostępne
if (isset($_POST['page_title']) && isset($_POST['page_content'])) {
    // Przypisanie wartości z formularza do zmiennych
    $page_title = $_POST['page_title'];  // Tytuł strony
    $page_content = $_POST['page_content'];  // Treść strony
    $page_is_active = isset($_POST['page_is_active']) ? 1 : 0;  // Ustalenie, czy strona jest aktywna

    // Zapytanie SQL do dodania nowej podstrony do bazy danych
    $query = "INSERT INTO page_list (page_title, page_content, status) VALUES ('$page_title', '$page_content', '$page_is_active')";

    // Wykonanie zapytania
    $result = mysqli_query($conn, $query);

    // Przekierowanie do strony administracyjnej po dodaniu podstrony
    header('Location: ./admin.php');
}

?>
