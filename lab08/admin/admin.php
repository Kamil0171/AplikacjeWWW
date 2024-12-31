<?php

session_start();
include('../cfg.php');
echo "<div class='main'>";

function FormularzLogowania($errorMessage = '')
{
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

    if ($errorMessage) {
        $wynik .= '<p class="error-message">' . $errorMessage . '</p>';
    }

    $wynik .= '</div>';
    return $wynik;
}

function ListaPodstron()
{
    global $conn;

    $wynik = '<h3>Podstrony</h3>'.'<table class="tabela_akcji">'.'<tr><th>ID</th><th>Nazwa podstrony</th><th>Operacje</th></tr>';
    $wynik .= '<a href="'.$_SERVER['PHP_SELF'].'?action=dodaj">Dodaj podstronę</a> <br /> <br />';

    $query = "SELECT id, page_title FROM page_list";
    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $page_title = $row['page_title'];

            $wynik .= '<tr>'.'<td>' . $id . '</td>'.'<td>' . $page_title . '</td>'.'<td><a href="'.$_SERVER['PHP_SELF'].'?action=edytuj&id='.$id.'">Edytuj</a> | <a href="'.$_SERVER['PHP_SELF'].'?action=usun&id='.$id.'">Usuń</a></td>'.'</tr>';
        }
    } else {
        $wynik .= '<tr><td colspan="3">Brak podstron</td></tr>';
    }

    $wynik .= '</table>';

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

function EdytujPodstrone()
{
    global $conn;

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        echo "Brak podstrony z podanym ID";
        exit;
    }

    $query = "SELECT page_title, page_content, status FROM page_list WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0 && $result) {
        $row = mysqli_fetch_assoc($result);
        $page_title = $row['page_title'];
        $page_content = $row['page_content'];
        $page_is_active = $row['status'];

        $wynik = '<h3>Edycja Podstrony o id: '.$id.'</h3>'.'<form method="POST" action="edit.php?id='.$id.'">';
        $wynik .= '<input class="nazwa" type="text" name="page_title" value="'.$page_title.'"><br />';
        $wynik .= '<textarea class="tresc" rows=20 cols=100 name="page_content">'.$page_content.'</textarea><br />';
        $wynik .= 'Aktywna: <input class="aktywna" type="checkbox" name="page_is_active" value="1"'.($page_is_active == 1 ? 'checked="checked"' : '').'><br />';
        $wynik .= '<input class="zapisz" type="submit" name="zapisz" value="zapisz">'.'</form>';

        return $wynik;
    }
}

function DodajNowaPodstrone()
{
    global $conn;

    $wynik = '<h3>Dodaj podstronę:</h3>'.'<form method="POST" action="dodajNowaStrone.php">';
    $wynik .= 'Nazwa: <input class="tytul" type="text" name="page_title" value=""><br /> <br />';
    $wynik .= 'Treść: <textarea class="tresc" rows=20 cols=100 name="page_content"></textarea><br /> <br />';
    $wynik .= 'Aktywna: <input class="aktywna" type="checkbox" name="page_is_active" value="1"><br /> <br />';
    $wynik .= '<input class="zapisz" type="submit" value="Dodaj">'.'</form>';

    return $wynik;
}

function UsunPodstrone()
{
    global $conn;

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        echo "Brak podstrony z podanym ID";
        exit;
    }

    $query = "DELETE FROM page_list WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Usunięto podstronę";
        header("Location: admin.php");
    } else {
        echo "Błąd usuwania";
        exit;
    }
}

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    echo ListaPodstron();
    echo '<a href="wylogujsie.php"> Wyloguj się </a>';
} else {
    $errorMessage = '';
    if (isset($_POST['login_email']) && isset($_POST['login_pass'])) {
        $formLogin = $_POST['login_email'];
        $formPass = $_POST['login_pass'];

        if ($formLogin === $login && $formPass === $pass) {
            $_SESSION['admin_logged_in'] = true;
            header("Refresh:0");
        } else {
            $errorMessage = 'Błędny login lub hasło!';
        }
    }
    echo FormularzLogowania($errorMessage);
}

?>