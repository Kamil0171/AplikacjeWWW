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
    <h1 class="heading">Panel CMS</h1>
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

// Logowanie
$errorMessage = '';

if (isset($_POST['login_email']) && isset($_POST['login_pass'])) {
    $formLogin = $_POST['login_email'];
    $formPass = $_POST['login_pass'];

    if (strtolower($formLogin) === strtolower($login) && $formPass === $pass) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php");  // Przekierowanie po zalogowaniu
        exit;
    } else {
        $errorMessage = 'Błędny login lub hasło!';
    }
}

// Funkcja wyświetlająca listę podstron
function ListaPodstron()
{
    global $conn;

    // Nagłówek listy podstron
    $wynik = '<h3></h3>'.'<table class="tabela_akcji">'.'<tr><th>ID</th><th>Nazwa</th><th>Operacje</th></tr>';

    // Dodaj przycisk "Zarządzaj Kategoriami" pod "Dodaj podstronę"
    $wynik .= '<a href="'.$_SERVER['PHP_SELF'].'?action=zarzadzaj_kategoriami">Zarządzaj Kategoriami</a> <br /> <br />';
    $wynik .= '<a href="'.$_SERVER['PHP_SELF'].'?action=zarzadzaj_produktami">Zarządzaj Produktami</a> <br /> <br />';
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

    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'edytuj' && isset($_GET['id'])) {
            echo EdytujPodstrone();
        } else if ($_GET['action'] === 'usun' && isset($_GET['id'])) {
            echo UsunPodstrone();
        } else if ($_GET['action'] === 'dodaj') {
            echo DodajNowaPodstrone();
        }
    } else {
        echo $wynik;
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
        $wynik .= '<input class="zapisz" type="submit" name="zapisz" value="Zapisz">'.'</form>';
        $wynik .= '<br><a href="admin.php"><button>Powrót</button></a>';

        return $wynik;
    }
}

// Funkcja dodająca nową podstronę
function DodajNowaPodstrone()
{
    global $conn;

    // Formularz dodawania nowej podstrony
    $wynik = '<h3>Dodaj podstronę</h3>'.'<form method="POST" action="dodajNowaStrone.php">';
    $wynik .= 'Nazwa: <input class="tytul" type="text" name="page_title" value=""><br /> <br />';
    $wynik .= 'Treść: <textarea class="tresc" rows=20 cols=100 name="page_content"></textarea><br /> <br />';
    $wynik .= 'Aktywna: <input class="aktywna" type="checkbox" name="page_is_active" value="1"><br /> <br />';
    $wynik .= '<input class="zapisz" type="submit" value="Dodaj">'.'</form>';

    $wynik .= '<br><a href="admin.php"><button>Powrót</button></a>';

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

// Funkcja zarządzająca kategoriami
function ZarzadzajKategorie()
{
    echo "<h3>Zarządzaj kategoriami</h3>";
    echo '<a href="?action=dodaj_kategorie">Dodaj kategorię</a><br />';
    PokazKategorie();

    echo '<br><a href="admin.php"><button>Powrót</button></a>';
}

// Funkcja dodająca kategorię
function DodajKategorie()
{
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nazwa = mysqli_real_escape_string($conn, $_POST['nazwa']);
        $matka = $_POST['matka'] ? (int)$_POST['matka'] : 0;

        $query = "INSERT INTO categories (nazwa, matka) VALUES ('$nazwa', '$matka')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Kategoria została dodana.";
            header("Location: admin.php?action=pokaz_kategorie");
        } else {
            echo "Błąd przy dodawaniu kategorii.";
        }
    } else {
        echo '<h3>Dodaj nową kategorię</h3>';
        echo '<form method="POST">';
        echo 'Nazwa kategorii: <input type="text" name="nazwa" required><br />';
        echo 'Kategoria nadrzędna (ID): <input type="number" name="matka"><br />';
        echo '<input type="submit" value="Dodaj kategorię">';
        echo '</form>';
        echo '<br><a href="'.$_SERVER['HTTP_REFERER'].'"><button>Powrót</button></a>';
    }
}

// Funkcja wyświetlająca wszystkie kategorie
function PokazKategorie()
{
    global $conn;

    $query = "SELECT * FROM categories";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<h3>Lista kategorii</h3>';
        echo '<table>';
        echo '<tr><th>ID</th><th>Nazwa</th><th>Matka</th><th>Operacje</th></tr>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['nazwa'] . '</td>';
            echo '<td>' . ($row['matka'] ? $row['matka'] : 'Brak') . '</td>';
            echo '<td><a href="?action=edytuj_kategorie&id=' . $row['id'] . '">Edytuj</a> | <a href="?action=usun_kategorie&id=' . $row['id'] . '">Usuń</a></td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo "Brak kategorii w bazie danych.";
    }

}

// Funkcja edytująca kategorię
function EdytujKategorie()
{
    global $conn;

    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nazwa = mysqli_real_escape_string($conn, $_POST['nazwa']);
            $matka = $_POST['matka'] ? (int)$_POST['matka'] : 0;

            $query = "UPDATE categories SET nazwa = '$nazwa', matka = '$matka' WHERE id = $id";
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "Kategoria została zaktualizowana.";
                header("Location: admin.php?action=pokaz_kategorie");
            } else {
                echo "Błąd przy edytowaniu kategorii.";
            }
        } else {
            $query = "SELECT * FROM categories WHERE id = $id";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);

            echo '<h3>Edytuj kategorię</h3>';
            echo '<form method="POST">';
            echo 'Nazwa kategorii: <input type="text" name="nazwa" value="' . $row['nazwa'] . '" required><br />';
            echo 'Kategoria nadrzędna (ID): <input type="number" name="matka" value="' . $row['matka'] . '"><br />';
            echo '<input type="submit" value="Zaktualizuj kategorię">';
            echo '</form>';
        }
    } else {
        echo "Brak kategorii z podanym ID.";
    }
    echo '<br><a href="'.$_SERVER['HTTP_REFERER'].'"><button>Powrót</button></a>';
}

// Funkcja usuwająca kategorię
function UsunKategorie()
{
    global $conn;

    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];

        $query = "DELETE FROM categories WHERE id = $id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Kategoria została usunięta.";
            header("Location: admin.php?action=pokaz_kategorie");
        } else {
            echo "Błąd przy usuwaniu kategorii.";
        }
    } else {
        echo "Brak kategorii z podanym ID.";
    }
}

// Funkcja zarządzająca produktami
function ZarzadzajProduktami()
{
    echo "<h3>Zarządzaj produktami</h3>";
    echo '<a href="'.$_SERVER['PHP_SELF'].'?action=dodaj_produkt">Dodaj produkt</a><br />';
    PokazProdukty();

    echo '<br><a href="admin.php"><button>Powrót</button></a>';
}

// Funkcja dodająca produkt
function DodajProdukt()
{
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tytul = mysqli_real_escape_string($conn, $_POST['tytul']);
        $opis = mysqli_real_escape_string($conn, $_POST['opis']);
        $cena_netto = $_POST['cena_netto'];
        $podatek_vat = $_POST['podatek_vat'];
        $status_dostepnosci = $_POST['status_dostepnosci'];
        $gabaryt = $_POST['gabaryt'];
        $zdjecie = $_POST['zdjecie'];
        $category_id = $_POST['category_id'];

        $query = "INSERT INTO produkty (tytul, opis, cena_netto, podatek_vat, status_dostepnosci, gabaryt, zdjecie, category_id)
                  VALUES ('$tytul', '$opis', '$cena_netto', '$podatek_vat', '$status_dostepnosci', '$gabaryt', '$zdjecie', '$category_id')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Produkt został dodany.";
            header("Location: admin.php?action=pokaz_produkty");
        } else {
            echo "Błąd przy dodawaniu produktu.";
        }
    } else {
        echo '<h3>Dodaj nowy produkt</h3>';
        echo '<form method="POST">';
        echo 'Tytuł: <input type="text" name="tytul" required><br />';
        echo 'Opis: <textarea name="opis" required></textarea><br />';
        echo 'Cena netto: <input type="number" name="cena_netto" required><br />';
        echo 'Podatek VAT: <input type="number" name="podatek_vat" required><br />';
        echo 'Status dostępności: <input type="number" name="status_dostepnosci" required><br />';
        echo 'Gabaryt: <input type="text" name="gabaryt" required><br />';
        echo 'Zdjęcie URL: <input type="text" name="zdjecie"><br />';
        echo 'Kategoria: <select name="category_id" required>';
        $categories_query = "SELECT id, nazwa FROM categories";
        $categories_result = mysqli_query($conn, $categories_query);
        while ($category = mysqli_fetch_assoc($categories_result)) {
            echo '<option value="' . $category['id'] . '">' . $category['nazwa'] . '</option>';
        }
        echo '</select><br />';
        echo '<input type="submit" value="Dodaj produkt">';
        echo '</form>';
        echo '<br><a href="'.$_SERVER['HTTP_REFERER'].'"><button>Powrót</button></a>';
    }
}

// Funkcja wyświetlająca produkty
function PokazProdukty()
{
    global $conn;

    $query = "SELECT * FROM produkty";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<h3>Lista produktów</h3>';
        echo '<table>';
        echo '<tr><th>ID</th><th>Tytuł</th><th>Opis</th><th>Cena</th><th>Operacje</th></tr>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['tytul'] . '</td>';
            echo '<td>' . $row['opis'] . '</td>';
            echo '<td>' . $row['cena_netto'] . '</td>';
            echo '<td><a href="?action=edytuj_produkt&id=' . $row['id'] . '">Edytuj</a> | <a href="?action=usun_produkt&id=' . $row['id'] . '">Usuń</a></td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "Brak produktów w bazie danych.";
    }
}

// Funkcja edytująca produkt
function EdytujProdukt()
{
    global $conn;

    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tytul = mysqli_real_escape_string($conn, $_POST['tytul']);
            $opis = mysqli_real_escape_string($conn, $_POST['opis']);
            $cena_netto = $_POST['cena_netto'];
            $podatek_vat = $_POST['podatek_vat'];
            $status_dostepnosci = $_POST['status_dostepnosci'];
            $gabaryt = $_POST['gabaryt'];
            $zdjecie = $_POST['zdjecie'];
            $category_id = $_POST['category_id'];

            $query = "UPDATE produkty SET tytul = '$tytul', opis = '$opis', cena_netto = '$cena_netto',
                      podatek_vat = '$podatek_vat', status_dostepnosci = '$status_dostepnosci', gabaryt = '$gabaryt',
                      zdjecie = '$zdjecie', category_id = '$category_id' WHERE id = $id";
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "Produkt został zaktualizowany.";
                header("Location: admin.php?action=pokaz_produkty");
            } else {
                echo "Błąd przy edytowaniu produktu.";
            }
        } else {
            $query = "SELECT * FROM produkty WHERE id = $id";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);

            echo '<h3>Edytuj produkt</h3>';
            echo '<form method="POST">';
            echo 'Tytuł: <input type="text" name="tytul" value="' . $row['tytul'] . '" required><br />';
            echo 'Opis: <textarea name="opis" required>' . $row['opis'] . '</textarea><br />';
            echo 'Cena netto: <input type="number" name="cena_netto" value="' . $row['cena_netto'] . '" required><br />';
            echo 'Podatek VAT: <input type="number" name="podatek_vat" value="' . $row['podatek_vat'] . '" required><br />';
            echo 'Status dostępności: <input type="number" name="status_dostepnosci" value="' . $row['status_dostepnosci'] . '" required><br />';
            echo 'Gabaryt: <input type="text" name="gabaryt" value="' . $row['gabaryt'] . '" required><br />';
            echo 'Zdjęcie URL: <input type="text" name="zdjecie" value="' . $row['zdjecie'] . '"><br />';
            echo 'Kategoria: <select name="category_id" required>';
            $categories_query = "SELECT id, nazwa FROM categories";
            $categories_result = mysqli_query($conn, $categories_query);
            while ($category = mysqli_fetch_assoc($categories_result)) {
                echo '<option value="' . $category['id'] . '" ' . ($category['id'] == $row['category_id'] ? 'selected' : '') . '>' . $category['nazwa'] . '</option>';
            }
            echo '</select><br />';
            echo '<input type="submit" value="Zaktualizuj produkt">';
            echo '</form>';
            echo '<br><a href="'.$_SERVER['HTTP_REFERER'].'"><button>Powrót</button></a>';
        }
    } else {
        echo "Brak produktu z podanym ID.";
    }

}

// Funkcja usuwająca produkt
function UsunProdukt()
{
    global $conn;

    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];

        $query = "DELETE FROM produkty WHERE id = $id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Produkt został usunięty.";
            header("Location: admin.php?action=pokaz_produkty");
        } else {
            echo "Błąd przy usuwaniu produktu.";
        }
    } else {
        echo "Brak produktu z podanym ID.";
    }
}

// Sprawdzenie, czy administrator jest zalogowany
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'dodaj_kategorie':
                DodajKategorie();
                break;
            case 'pokaz_kategorie':
                PokazKategorie();
                break;
            case 'edytuj_kategorie':
                EdytujKategorie();
                break;
            case 'usun_kategorie':
                UsunKategorie();
                break;
            case 'zarzadzaj_kategoriami':
                ZarzadzajKategorie();
                break;
            case 'zarzadzaj_produktami':
                ZarzadzajProduktami();
                break;
            case 'dodaj_produkt';
                DodajProdukt();
                break;
            case 'edytuj_produkt':
                EdytujProdukt();
                break;
            case 'usun_produkt':
                UsunProdukt();
                break;
            case 'pokaz_produkty':
                PokazProdukty();
                break;
            default:
                ListaPodstron();
                break;
        }
    } else {
        ListaPodstron();
    }
    echo '<br><a href="wylogujsie.php">Wyloguj się</a>';
} else {
    // Wyświetlenie formularza logowania, jeśli użytkownik nie jest zalogowany
    echo FormularzLogowania($errorMessage);
}
    echo '<link rel="stylesheet" type="text/css" href="../css/panel.css">';
?>