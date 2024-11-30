
<?php

function PokazKontakt() {
    echo '<form method="POST" action="">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="temat">Temat:</label>
            <input type="text" name="temat" id="temat" required>
            <label for="tresc">Treść:</label>
            <textarea name="tresc" id="tresc" required></textarea>
            <button type="submit" name="submit">Wyślij</button>
          </form>';
}

function WyslijMailKontakt($odbiorca) {
    if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email'])) {
        echo '[Nie wypełniłeś pola]';
        PokazKontakt();
    } else {
        $mail['subject'] = $_POST['temat'];
        $mail['body'] = $_POST['tresc'];
        $mail['sender'] = $_POST['email'];
        $mail['recipient'] = $odbiorca;

        $header = "From: Formularz kontaktowy <" . $mail['sender'] . ">
";
        $header .= "Content-Type: text/plain; charset=utf-8
";

        mail($mail['recipient'], $mail['subject'], $mail['body'], $header);

        echo '[Wiadomość wysłana]';
    }
}

function PrzypomnijHaslo($admin_email) {
    $new_password = "TymczasoweHaslo123";
    $subject = "Resetowanie hasła";
    $body = "Twoje tymczasowe hasło to: " . $new_password;
    $header = "From: System <no-reply@system.com>
";

    mail($admin_email, $subject, $body, $header);

    echo '[Hasło zostało wysłane]';
}

?>
