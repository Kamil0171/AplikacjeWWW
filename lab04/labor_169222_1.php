<?php

echo "a) Metoda include(), require_once():";
echo "<br>";
echo "Przykład użycia include()";
echo "<br>";
include('zad1.php');
echo "<br>";

echo "Przykład użycia require_once()";
echo "<br>";
require_once('zad1.php');
echo "<br>";

echo "b) Warunki if, else, elseif, switch:";
echo "<br>";
$ocena = 69;
echo $ocena." punktow"; 
echo "<br><br>";
if ($ocena >= 60) {
    echo "Zdane";
    echo "<br>";
} else {
    echo "Niezdane";
    echo "<br>";
}

if ($ocena >= 90) {
    echo "Ocena 5";
    echo "<br>";
} elseif ($ocena <= 80 && $ocena >= 70) {
    echo "Ocena 4";
    echo "<br>";
} else {
    echo "Ocena 3";
    echo "<br>";
}
echo "<br>";
echo "swich: <br>";
$marka = "audi";

switch ($marka) {
    case "audi":
        echo "Twój samochod jest marki audi";
        break;
    case "bmw":
        echo "Twój samochod jest marki bmw";
        break;
    default:
        echo "Twój samochod jest marki innej niz znam";
}
echo "<br>";
echo "<br>";
echo "c) Pętla while() i for():";
echo "<br>";

$i = 1;
echo "Pętla while: ";
while ($i <= 5) {
    echo $i . " ";
    $i++;
}
echo "<br>";

echo "Pętla for: ";
for ($j = 1; $j <= 5; $j++) {
    echo $j . " ";
}
echo "<br>";
echo "<br>";
echo "Przykład korzystania z \$_GET:";
echo "<br>";
if (isset($_GET['name'])) {
    echo "Witaj, " . htmlspecialchars($_GET['name']) . "!";
    echo "<br>";
} else {
    echo "Nie podano imienia.";
    echo "<br>";
}
echo "<br>";
echo "Przykład korzystania z \$_POST:";
echo "<br>";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email'])) {
        echo "Podany email " . htmlspecialchars($_POST['email']);
    }
}
echo "<br>";
echo "Przykład korzystania z \$_SESSION:";
echo "<br>";
session_start();
if (!isset($_SESSION['views'])) {
    $_SESSION['views'] = 0;
}
$_SESSION['views']++;
echo "Liczba odsłon tej strony w sesji: " . $_SESSION['views'];
?>