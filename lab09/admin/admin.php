<?php

// Rozpoczęcie sesji
session_start();

// Dołączenie pliku konfiguracyjnego
include('./cfg.php');

// Wyświetlanie głównego kontenera
echo "<div class='main'>";

// Funkcja wyświetlająca formularz logowania
function FormularzLogowania($errorMessage = '')
{
    // Tworzenie formularza logowania
    $wynik = '
    <h1 class="heading">Panel CMS:</h1>
    <a href="../index.php"> Strona główna </a><br>
    <form class="formularz_logowania" method="POST" name="LoginForm" enctype="multipart/form-data" action="'.$_SERVER['REQUEST_URI'].'">
    <table class="logowanie">
    <tr><td class="log4_t">login</td><td><input type="text" name="login_email" class="logowanie"/></td></tr>
    <tr><td class="log4_t">hasło</td><td><input type="password" name="login_pass" class="logowanie"/></td></tr>
    <tr><td><br/></td><td><input type="submit" name="xl_submit" class="logowanie" value="Zaloguj"/></td></tr>
    </table>
    </form>';

    // Jeśli podano wiadomość o błędzie, dodaj ją do formularza
    if ($errorMessage) {
        $wynik .= '<p class="error-message">' . $errorMessage . '</p>';
    }

    $wynik .= '</div>';
    return $wynik;
}

// Funkcja wyświetlająca listę podstron
function ListaPodstron()
{
    global $conn;

    // Nagłówek listy podstron
    $wynik = '<h3></h3>'.'<table class="tabela_akcji">'.'<tr><th>ID</th><th>Nazwa podstrony</th><th>Operacje</th></tr>';
    $wynik .= '<a href="'.$_SERVER['PHP_SELF'].'?action=dodaj">Dodaj podstronę</a> <br /> <br />';

    // Zapytanie do bazy danych w celu pobrania listy podstron
    $query = "SELECT id, page_title FROM page_list";
    $result = mysqli_query($conn, $query);

    // Jeśli zapytanie zwróciło wyniki, wyświetl je
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $page_title = $row['page_title'];

            // Wyświetlanie każdej podstrony z opcjami edycji i usunięcia
            $wynik .= '<tr>'.'<td>' . $id . '</td>'.'<td>' . $page_title . '</td>'.'<td><a href="'.$_SERVER['PHP_SELF'].'?action=edytuj&id='.$id.'">Edytuj</a> | <a href="'.$_SERVER['PHP_SELF'].'?action=usun&id='.$id.'">Usuń</a></td>'.'</tr>';
        }
    } else {
        // Jeśli brak podstron w bazie danych, wyświetl odpowiedni komunikat
        $wynik .= '<tr><td colspan="3">Brak podstron</td></tr>';
    }

    $wynik .= '</table>';

    // Wywołanie funkcji edycji, usuwania lub dodawania podstrony w zależności od akcji
    echo $wynik;

    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'edytuj' && isset($_GET['id'])) {
            echo EdytujPodstrone();
        } else if ($_GET['action'] === 'usun' && isset($_GET['id'])) {
            echo UsunPodstrone();
        } else if ($_GET['action'] === 'dodaj') {
            echo DodajNowaPodstrone();
        }
    }
}

// Funkcja edytująca podstronę
function EdytujPodstrone()
{
    global $conn;

    // Pobieranie ID podstrony do edytowania
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        echo "Brak podstrony z podanym ID";
        exit;
    }

    // Zapytanie do bazy danych w celu pobrania danych podstrony
    $query = "SELECT page_title, page_content, status FROM page_list WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0 && $result) {
        $row = mysqli_fetch_assoc($result);
        $page_title = $row['page_title'];
        $page_content = $row['page_content'];
        $page_is_active = $row['status'];

        // Formularz edycji podstrony
        $wynik = '<h3>Edycja Podstrony o id: '.$id.'</h3>'.'<form method="POST" action="edit.php?id='.$id.'">';
        $wynik .= '<input class="nazwa" type="text" name="page_title" value="'.$page_title.'"><br />';
        $wynik .= '<textarea class="tresc" rows=20 cols=100 name="page_content">'.$page_content.'</textarea><br />';
        $wynik .= 'Aktywna: <input class="aktywna" type="checkbox" name="page_is_active" value="1"'.($page_is_active == 1 ? 'checked="checked"' : '').'><br />';
        $wynik .= '<input class="zapisz" type="submit" name="zapisz" value="zapisz">'.'</form>';

        return $wynik;
    }
}

// Funkcja dodająca nową podstronę
function DodajNowaPodstrone()
{
    global $conn;

    // Formularz dodawania nowej podstrony
    $wynik = '<h3>Dodaj podstronę:</h3>'.'<form method="POST" action="dodajNowaStrone.php">';
    $wynik .= 'Nazwa: <input class="tytul" type="text" name="page_title" value=""><br /> <br />';
    $wynik .= 'Treść: <textarea class="tresc" rows=20 cols=100 name="page_content"></textarea><br /> <br />';
    $wynik .= 'Aktywna: <input class="aktywna" type="checkbox" name="page_is_active" value="1"><br /> <br />';
    $wynik .= '<input class="zapisz" type="submit" value="Dodaj">'.'</form>';

    return $wynik;
}

// Funkcja usuwająca podstronę
function UsunPodstrone()
{
    global $conn;

    // Pobieranie ID podstrony do usunięcia
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        echo "Brak podstrony z podanym ID";
        exit;
    }

    // Zapytanie do bazy danych w celu usunięcia podstrony
    $query = "DELETE FROM page_list WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Jeśli usunięcie zakończone powodzeniem, przekierowanie
        echo "Usunięto podstronę";
        header("Location: admin.php");
    } else {
        // Jeśli wystąpił błąd
        echo "Błąd usuwania";
        exit;
    }
}

// Sprawdzenie, czy administrator jest zalogowany
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    echo ListaPodstron();  // Wyświetlenie listy podstron
    echo '<a href="wylogujsie.php"> Wyloguj się </a>';  // Link do wylogowania
} else {
    // Jeśli użytkownik nie jest zalogowany, wyświetlenie formularza logowania
    $errorMessage = '';
    if (isset($_POST['login_email']) && isset($_POST['login_pass'])) {
        $formLogin = $_POST['login_email'];
        $formPass = $_POST['login_pass'];

        // Sprawdzenie poprawności loginu i hasła
        if ($formLogin === $login && $formPass === $pass) {
            $_SESSION['admin_logged_in'] = true;
            header("Refresh:0");  // Przeładowanie strony po zalogowaniu
        } else {
            $errorMessage = 'Błędny login lub hasło!';  // Komunikat o błędzie
        }
    }
    // Wyświetlenie formularza logowania z komunikatem o błędzie
    echo FormularzLogowania($errorMessage);
}

?>
