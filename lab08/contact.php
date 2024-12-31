<?php

include ('PHPMailer/src/PHPMailer.php');
include ('PHPMailer/src/Exception.php');
include ('PHPMailer/src/SMTP.php');

ini_set('SMTP', 'smtp.gmail.com');
ini_set('smtp_port', '587');
ini_set('sendmail_from', 'testowek520@gmail.com');

function WyslijMailKontakt($odbiorca)
{
    if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message'])) {
        echo PokazKontakt();
    }
    else {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'testowek520@gmail.com';
            $mail->Password = 'uvhsuocempqqrcar';
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom($_POST['email'], $_POST['name']);
            $mail->addAddress($odbiorca);

            $mail->isHTML(false);
            $mail->Subject = 'Wiadomosc od ' . $_POST['name'];
            $mail->Body    = $_POST['message'];

            $mail->send();
            echo '[Wiadomosc zostala wyslana!]';
            echo '<br><a href="index.php">Wróć do Strony Głównej</a>';
        } catch (Exception $e) {
            echo "Błąd wysyłania wiadomości: {$mail->ErrorInfo}";
        }
    }
}

function PrzypomnijHaslo($odbiorca)
{
    if(empty($_POST['email_recov'])) {
        echo PokazHaslo();
    }
    else {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'testowek520@gmail.com';
            $mail->Password = 'uvhsuocempqqrcar';
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom($_POST['email_recov']);
            $mail->addAddress($odbiorca);

            $mail->isHTML(false);
            $mail->Subject = "Odzyskiwanie hasla";
            $mail->Body    = "Twoje hasło to: 169222";

            $mail->send();
            echo '[Nowe haslo zostalo wysnale!]';
            echo '<br><a href="index.php">Wróć do Strony Głównej</a>';
        } catch (Exception $e) {
            echo "Błąd wysyłania wiadomości: {$mail->ErrorInfo}";
        }
    }
}

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['action'] == 'Wyślij') {
        WyslijMailKontakt('testowek520@gmail.com');
    } elseif ($_POST['action'] == 'Przypomnij') {
        PrzypomnijHaslo('testowek520@gmail.com');
    }
}
?>
