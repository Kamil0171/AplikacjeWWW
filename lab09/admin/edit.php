<?php

// Dołączenie pliku konfiguracyjnego, który zawiera ustawienia połączenia z bazą danych
include('./cfg.php');

// Sprawdzenie, czy formularz został wysłany
if (isset($_POST['zapisz'])) {
    // Sprawdzenie, czy dane do edycji zostały przesłane
    if (isset($_POST['page_title']) && isset($_POST['page_content'])) {
        // Przypisanie wartości z formularza do zmiennych
        $page_title = $_POST['page_title'];  // Tytuł strony
        $page_content = $_POST['page_content'];  // Treść strony
        $page_is_active = isset($_POST['page_is_active']) ? 1 : 0;  // Ustalenie, czy strona jest aktywna
        $id = $_GET['id'];  // ID strony do edycji

        // Zapytanie SQL do aktualizacji danych w bazie danych
        $query = "UPDATE page_list SET page_title = '$page_title', page_content = '$page_content', status = '$page_is_active' WHERE id = '$id' LIMIT 1";

        // Wykonanie zapytania
        $result = mysqli_query($conn, $query);

        // Sprawdzenie, czy zapytanie zostało wykonane pomyślnie
        if ($result) {
            echo "Zaktualizowano podstronę";  // Komunikat o pomyślnej aktualizacji
            header("Location: ./admin.php");  // Przekierowanie do strony administracyjnej po aktualizacji
        } else {
            // Komunikat o błędzie podczas aktualizacji
            echo "Aktualizacja się nie powidodła";
        }
    }
} else {
    // Komunikat, jeśli dane nie zostały przesłane
    echo "Dane zostały nie przesłane";
}

?>
