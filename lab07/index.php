<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$idp = isset($_GET['idp']) ? $_GET['idp'] : 'glowna';

include('cfg.php');
include('showpage.php');

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
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="Content-Language" content="pl"/>
    <meta name="Author" content="Kamil Amarasekara"/>
    <link rel="stylesheet" href="css/style.css">
</head>
<body onload="startclock()">
    <div class="content-wrapper" style="min-height: 100vh; display: flex; flex-direction: column;">

        <div class="content" style="flex-grow: 1;">
            <?php
                if (file_exists($strona)) {
                    include($strona);
                } else {
                    echo 'Strona nie została znaleziona.';
                }
            ?>
        </div>

        <footer style="background-color: #333; color: white; text-align: center; padding: 10px 0;">
            <?php
                $nr_indeksu = '169222';
                $nrGrupy = '1';
                echo 'Autor: Kamil Amarasekara ' . $nr_indeksu . ' grupa ' . $nrGrupy . '<br /><br />';
            ?>
        </footer>

        <div style="position: absolute; bottom: 20px; left: 20px;">
            <a href="admin" class="button" style="padding: 10px 20px; background-color: black; color: white; text-decoration: none; border-radius: 5px;">
                Admin
            </a>
        </div>
    </div>
</body>
</html>
