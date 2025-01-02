<?php

// Funkcja do wyświetlania treści podstrony na podstawie aliasu
function PokazPodstrone($id, $link)
{
    // Zabezpieczenie przed atakami XSS poprzez oczyszczenie zmiennej 'id'
    $id_clear = htmlspecialchars($id);

    // Przygotowanie zapytania SQL, które wybiera dane z tabeli 'page_list' na podstawie aliasu
    $query = "SELECT * FROM page_list WHERE alias = ? LIMIT 1";
    $stmt = mysqli_prepare($link, $query);  // Przygotowanie zapytania

    // Sprawdzenie, czy zapytanie zostało poprawnie przygotowane
    if (!$stmt) {
        die("Błąd przygotowania zapytania: " . mysqli_error($link));  // Jeśli zapytanie nie zostało przygotowane, zakończenie skryptu
    }

    // Powiązanie parametru zapytania z wartością $id_clear (alias strony)
    mysqli_stmt_bind_param($stmt, 's', $id_clear);

    // Wykonanie zapytania
    mysqli_stmt_execute($stmt);

    // Pobranie wyników zapytania
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);

    // Sprawdzenie, czy strona o podanym aliasie została znaleziona
    if (empty($row['id'])) {
        return '[nie_znaleziono_strony]';  // Zwrócenie komunikatu, jeśli strona nie została znaleziona
    }

    // Zwrócenie treści strony
    return $row['page_content'];
}

?>
