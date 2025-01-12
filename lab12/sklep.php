<?php
// Rozpoczęcie sesji
session_start();

// Dołączenie pliku konfiguracyjnego
include('admin/cfg.php');

// Zmienna do przechowywania komunikatów o błędach
$error_message = "";

// Funkcja do pobrania rozmiaru produktu
function getProductSize($id_prod) {
    global $conn;
    $stmt = $conn->prepare('SELECT gabaryt FROM produkty WHERE id = ?');
    $stmt->bind_param('i', $id_prod);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    return $product ? $product['gabaryt'] : 'średni';
}

// Funkcja do dodania produktu do koszyka
function DodajDoKoszyka($id_prod, $ile_sztuk, $wielkosc) {
    global $conn, $error_message;

    // Jeśli koszyk jeszcze nie istnieje, tworzymy pustą tablicę
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Sprawdzenie dostępności produktu
    $stmt = $conn->prepare("SELECT id, tytul, ilosc, status_dostepnosci FROM produkty WHERE id = ?");
    $stmt->bind_param("i", $id_prod);
    $stmt->execute();
    $result = $stmt->get_result();
    $produkt = $result->fetch_assoc();

    // Jeśli produkt nie istnieje w bazie, zwrócimy komunikat o błędzie
    if (!$produkt) {
        $error_message = "Produkt nie istnieje.";
        return;
    }

    // Sprawdzenie, czy produkt jest dostępny w odpowiedniej ilości
    if ($produkt['status_dostepnosci'] == 0 || $produkt['ilosc'] < $ile_sztuk) {
        $error_message = "Produkt jest niedostępny w takiej ilości.";
        return;
    }

    // Sprawdzamy, czy produkt już istnieje w koszyku
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id_prod'] == $id_prod) {
            if ($item['ile_sztuk'] + $ile_sztuk <= $produkt['ilosc']) {
                $item['ile_sztuk'] += $ile_sztuk; // Zwiększamy ilość w koszyku
            } else {
                $error_message = "Nie możesz dodać więcej sztuk niż dostępnych!";
                return;
            }
            $found = true;
            break;
        }
    }

    // Jeśli produkt nie był w koszyku, dodajemy go
    if (!$found) {
        $_SESSION['cart'][] = [
            'id_prod' => $id_prod,
            'ile_sztuk' => $ile_sztuk,
            'wielkosc' => getProductSize($id_prod),
            'data' => time()
        ];
    }
}

// Funkcja do usunięcia produktu z koszyka
function UsunZKoszyka($id_prod) {
    global $conn;

    // Sprawdzamy, czy koszyk istnieje
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id_prod'] == $id_prod) {
                // Przywracamy dostępność produktu po usunięciu z koszyka
                $stmt = $conn->prepare("UPDATE produkty SET status_dostepnosci = 1 WHERE id = ?");
                $stmt->bind_param("i", $id_prod);
                $stmt->execute();

                // Usuwamy produkt z koszyka
                unset($_SESSION['cart'][$key]);
                break;
            }
        }
    }
}

// Funkcja do obliczania wartości koszyka (cena brutto + VAT)
function ObliczWartoscKoszyka() {
    global $conn;

    $suma = 0;

    // Iteracja po produktach w koszyku
    foreach ($_SESSION['cart'] as $item) {
        $stmt = $conn->prepare("SELECT cena_netto, podatek_vat FROM produkty WHERE id = ?");
        $stmt->bind_param("i", $item['id_prod']);
        $stmt->execute();
        $result = $stmt->get_result();
        $produkt = $result->fetch_assoc();

        if ($produkt) {
            // Obliczanie ceny brutto (netto + podatek_vat)
            $cena_brutto = $produkt['cena_netto'] + $produkt['podatek_vat'];
            $suma += $cena_brutto * $item['ile_sztuk']; // Dodanie do sumy całkowitej
        }
    }

    return $suma;
}

// Funkcja do wyświetlania produktów na stronie
function PokazProdukty() {
    global $conn;

    $stmt = $conn->prepare("SELECT id, tytul, opis, cena_netto, ilosc, zdjecie, status_dostepnosci FROM produkty");
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<div class="produkty-container">'; // Kontener na produkty w układzie flex

    while ($produkt = $result->fetch_assoc()) {
        $dostepnosc = $produkt['status_dostepnosci'] == 1 ? "Dostępnych: " . $produkt['ilosc'] . " sztuk" : "Produkt niedostępny";

        // Wyświetlanie informacji o produkcie
        echo '<div class="produkt">';
        echo '<h3>' . $produkt['tytul'] . '</h3>';
        echo '<p>' . $produkt['opis'] . '</p>';
        echo '<p>Cena: ' . $produkt['cena_netto'] . ' PLN</p>';
        echo '<p>' . $dostepnosc . '</p>';
        echo '<img src="' . $produkt['zdjecie'] . '" alt="' . $produkt['tytul'] . '" width="100" height="100">';

        // Formularz do dodania produktu do koszyka
        if ($produkt['status_dostepnosci'] == 1) {
            echo '<form action="sklep.php" method="POST" id="add-to-cart-form">';
            echo '<input type="number" name="ile_sztuk" value="1" min="1" max="' . $produkt['ilosc'] . '" required>';
            echo '<input type="hidden" name="id_prod" value="' . $produkt['id'] . '">';
            echo '<input type="submit" name="dodaj" value="Dodaj do koszyka">';
            echo '</form>';
        } else {
            echo '<p>Produkt niedostępny.</p>';
        }
        echo '</div>';
    }

    echo '</div>'; // Zamykanie kontenera na produkty
}

// Obsługa dodawania produktów do koszyka
if (isset($_POST['dodaj'])) {
    $id_prod = $_POST['id_prod'];
    $ile_sztuk = $_POST['ile_sztuk'];
    $wielkosc = getProductSize($id_prod);
    DodajDoKoszyka($id_prod, $ile_sztuk, $wielkosc);
}

// Obsługa usuwania produktu z koszyka
if (isset($_GET['usun'])) {
    UsunZKoszyka($_GET['usun']);
}

// Funkcja do wyświetlania zawartości koszyka z wartością
function PokazKoszyk() {
    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        echo '<table>';
        echo '<tr><th>Nazwa produktu</th><th>Ilość</th><th>Wielkość</th><th>Akcja</th></tr>';

        global $conn;

        // Iteracja po produktach w koszyku
        foreach ($_SESSION['cart'] as $item) {
            $stmt = $conn->prepare("SELECT tytul, cena_netto FROM produkty WHERE id = ?");
            $stmt->bind_param("i", $item['id_prod']);
            $stmt->execute();
            $result = $stmt->get_result();
            $produkt = $result->fetch_assoc();

            echo '<tr>';
            echo '<td>' . $produkt['tytul'] . '</td>';
            echo '<td>' . $item['ile_sztuk'] . '</td>';
            echo '<td>' . $item['wielkosc'] . '</td>';
            echo '<td><a href="sklep.php?usun=' . $item['id_prod'] . '" class="usun-btn">Usuń</a></td>';
            echo '</tr>';
        }

        // Wyświetlenie łącznej wartości koszyka
        $wartosc_koszyka = ObliczWartoscKoszyka();
        echo '<tr><td colspan="3" style="text-align: right;"><strong>Łączna wartość:</strong></td>';
        echo '<td><strong>' . number_format($wartosc_koszyka, 2) . ' PLN</strong></td></tr>';

        echo '</table>';
    } else {
        echo '<p class="empty-cart-message">Twój koszyk jest pusty!</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="Content-Language" content="pl"/>
    <meta name="Author" content="Kamil Amarasekara"/>
    <link rel="stylesheet" href="css/koszyk.css">
    <title>Sklep Internetowy</title>
</head>

<body>
<header>
    <a href="index.php" class="button" style="position: absolute; top: -10px; left: 10px; padding: 10px 20px; background-color: black; color: white; text-decoration: none; border-radius: 5px;">Strona Główna</a>
    <h1 style="margin-bottom: 20px;">Witamy w sklepie!</h1>
</header>

<main>
    <h2>Nasze produkty</h2>
    <?php PokazProdukty(); ?>

    <h2>Twój koszyk</h2>
    <?php PokazKoszyk(); ?>

    <?php if ($error_message): ?>
        <div class="error-message">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <a href="platnosc.php" class="button"
       style="position: absolute; top: -10px; right: 10px; padding: 10px 20px; background-color: black; color: white; text-decoration: none; border-radius: 5px;
       <?php echo (empty($_SESSION['cart']) ? 'pointer-events: none; opacity: 0.5;' : ''); ?>">
       Przejdź do kasy
    </a>
</main>

</body>
</html>
