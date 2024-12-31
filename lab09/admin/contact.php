<?php

// Dołączenie plików PHPMailer, które umożliwiają wysyłanie wiadomości email
include ('../PHPMailer/src/PHPMailer.php');
include ('../PHPMailer/src/Exception.php');
include ('../PHPMailer/src/SMTP.php');

// Konfiguracja serwera SMTP do wysyłania wiadomości
ini_set('SMTP', 'smtp.gmail.com');
ini_set('smtp_port', '587');
ini_set('sendmail_from', 'testowek520@gmail.com');

// Funkcja wysyłająca wiadomość kontaktową
function WyslijMailKontakt($odbiorca)
{
    // Sprawdzanie, czy wszystkie wymagane pola zostały wypełnione
    if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message'])) {
        echo PokazKontakt();  // Jeśli brak danych, wyświetl formularz kontaktowy
    }
    else {
        // Utworzenie obiektu PHPMailer
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            // Konfiguracja PHPMailer do wysyłania przez SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'testowek520@gmail.com';  // Adres email nadawcy
            $mail->Password = 'uvhsuocempqqrcar';  // Hasło aplikacji do Gmaila
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Ustawienie nadawcy i odbiorcy wiadomości
            $mail->setFrom($_POST['email'], $_POST['name']);
            $mail->addAddress($odbiorca);

            // Ustawienia wiadomości
            $mail->isHTML(false);  // Wiadomość w formacie tekstowym
            $mail->Subject = 'Wiadomosc od ' . $_POST['name'];  // Temat wiadomości
            $mail->Body    = $_POST['message'];  // Treść wiadomości

            // Wysłanie wiadomości
            $mail->send();
            echo '[Wiadomosc zostala wyslana!]<br><br>';
            echo '<a href="../index.php">Strona główna</a>';
        } catch (Exception $e) {
            // Obsługa błędów podczas wysyłania
            echo "Błąd wysyłania wiadomości: {$mail->ErrorInfo}";
        }
    }
}

// Funkcja przypominająca hasło
function PrzypomnijHaslo($odbiorca)
{
    // Sprawdzanie, czy pole z emailem zostało wypełnione
    if(empty($_POST['email_recov'])) {
        echo PokazHaslo();  // Jeśli brak emaila, wyświetl formularz przypomnienia hasła
    }
    else {
        // Utworzenie obiektu PHPMailer
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            // Konfiguracja PHPMailer do wysyłania przez SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'testowek520@gmail.com';  // Adres email nadawcy
            $mail->Password = 'uvhsuocempqqrcar';  // Hasło aplikacji do Gmaila
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Ustawienie nadawcy i odbiorcy wiadomości
            $mail->setFrom($_POST['email_recov']);
            $mail->addAddress($odbiorca);

            // Ustawienia wiadomości
            $mail->isHTML(false);  // Wiadomość w formacie tekstowym
            $mail->Subject = "Odzyskiwanie hasla";  // Temat wiadomości
            $mail->Body    = "Twoje hasło to: 169222";  // Treść wiadomości

            // Wysłanie wiadomości
            $mail->send();
            echo '[Nowe haslo zostalo wyslane!]<br><br>';
            echo '<a href="../index.php">Strona główna</a>';
        } catch (Exception $e) {
            // Obsługa błędów podczas wysyłania
            echo "Błąd wysyłania wiadomości: {$mail->ErrorInfo}";
        }
    }
}

// Funkcja wyświetlająca formularz kontaktowy
function PokazKontakt()
{
    $wynik = '
    <div class="main">
        <div class="form_email">
            <form method="post" action="contact.php">
                <table class="form_email">
                    <tr><td class="log4_t">Imię: </td><td><input type="text" name="name" class="form_email" required /></td></tr>
                    <tr><td class="log4_t">Email: </td><td><input type="email" name="email" class="form_email" required /></td></tr>
                    <tr><td class="log4_t">Wiadomość: </td><td><textarea name="message" class="form_email" required></textarea></td></tr>
                    <tr><td></td><td><input type="submit" name="action" class="form_email" value="Wyślij" /></td></tr>
                </table>
            </form>
        </div>
    </div>
    ';
    return $wynik;
}

// Funkcja wyświetlająca formularz przypomnienia hasła
function PokazHaslo()
{
    $wynik = '
    <div class="main">
        <div class="form_passrecov">
            <form method="post" action="contact.php">
                <table class="form_passrecov">
                    <tr><td class="log4_t">Email: </td><td><input type="email" name="email_recov" class="form_passrecov" required /></td></tr>
                    <tr><td></td><td><input type="submit" name="action" class="form_passrecov" value="Odzyskaj hasło" /></td></tr>
                </table>
            </form>
        </div>
    </div>
    ';
    return $wynik;
}

// Sprawdzenie, czy formularz został wysłany
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sprawdzenie, która akcja została wybrana i wywołanie odpowiedniej funkcji
    if ($_POST['action'] == 'Wyślij') {
        WyslijMailKontakt('testowek520@gmail.com');  // Wysyłanie wiadomości kontaktowej
    } elseif ($_POST['action'] == 'Przypomnij') {
        PrzypomnijHaslo('testowek520@gmail.com');  // Wysyłanie przypomnienia hasła
    }
}
?>
