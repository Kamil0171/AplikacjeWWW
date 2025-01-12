<?php
// Definicja zmiennych z komunikatami o statusie płatności i zamówienia
$status_message = "Płatność została sfinalizowana!";
$order_message = "Twoje zamówienie zostało pomyślnie złożone";
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <!-- Meta tagi ustawiające język, kodowanie znaków i autora strony -->
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="Content-Language" content="pl"/>
    <meta name="Author" content="Kamil Amarasekara"/>

    <!-- Dołączenie zewnętrznego arkusza stylów CSS -->
    <link rel="stylesheet" href="css/koszyk.css">

    <title>Płatność</title>  <!-- Tytuł strony -->
</head>

<body>
    <!-- Kontener na komunikat o płatności -->
    <div class="payment-container">
        <div class="payment-message">
            <!-- Wyświetlanie komunikatu o statusie płatności -->
            <h1><?php echo $status_message; ?></h1>
            <!-- Wyświetlanie komunikatu o zamówieniu -->
            <p><?php echo $order_message; ?></p>
            <!-- Przycisk przekierowujący do strony głównej -->
            <a href="index.php" class="button">Powrót do Strony Głównej</a>
        </div>
    </div>
</body>
</html>
