<?php
// Ustawienie raportowania błędów, ukrywając powiadomienia i ostrzeżenia
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

// Sprawdzanie, czy parametr 'idp' jest ustawiony w zapytaniu URL, domyślnie ustawiamy na 'glowna'
$idp = isset($_GET['idp']) ? $_GET['idp'] : 'glowna';

// Dołączenie plików konfiguracyjnych oraz obsługi strony
include('admin/cfg.php');
include('admin/showpage.php');

// Instrukcja switch do obsługi różnych stron na podstawie wartości 'idp' z zapytania URL
switch ($idp) {
    case 'abradzalbajt':
        $strona = 'html/abradzalbajt.html';
        break;
    case 'burjkhalifa':
        $strona = 'html/burjkhalifa.html';
        break;
    case 'kontakt':
        $strona = 'html/kontakt.html';
        break;
    case 'pinganfinancecenter':
        $strona = 'html/pinganfinancecenter.html';
        break;
    case 'shanghaitower':
        $strona = 'html/shanghaitower.html';
        break;
    case 'filmy':
        $strona = 'html/filmy.html';
        break;
    case 'glowna':
    default:
        $strona = 'html/glowna.html';
        break;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <!-- Metatagi do ustawienia języka i kodowania znaków -->
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="Content-Language" content="pl"/>
    <meta name="Author" content="Kamil Amarasekara"/>

    <!-- Link do zewnętrznego pliku stylu -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body onload="startclock()"> <!-- Wywołanie funkcji JavaScript 'startclock' podczas ładowania strony -->
    <div class="content-wrapper" style="min-height: 100vh; display: flex; flex-direction: column;">
        <!-- Główny kontener treści z elastycznym układem -->
        <div class="content" style="flex-grow: 1;">
            <?php
            // Sprawdzenie, czy wybrana strona istnieje i jej dołączenie
            if (file_exists($strona)) {
                include($strona);
            } else {
                // Jeśli strona nie istnieje, wyświetl komunikat o błędzie
                echo 'Strona nie została znaleziona.';
            }
            ?>
        </div>

        <footer style="background-color: #333; color: white; text-align: center; padding: 10px 0;">
            <?php
            // Wyświetlenie informacji o autorze w stopce
            $nr_indeksu = '169222';
            $nrGrupy = '1';
            echo 'Autor: Kamil Amarasekara ' . $nr_indeksu . ' grupa ' . $nrGrupy . '<br /><br />';
            ?>
            <!-- Przycisk do panelu administracyjnego -->
            <div style="position: absolute; bottom: 20px; left: 20px;">
                <a href="./admin/admin.php" class="button" style="padding: 10px 20px; background-color: black; color: white; text-decoration: none; border-radius: 5px;">
                    Admin
                </a>
            </div>
        </footer>
    </div>
</body>
</html>
