<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$idp = isset($_GET['idp']) ? $_GET['idp'] : 'glowna';

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
</head>
<body onload="startclock()">
<?php
    if (file_exists($strona)) {
        include($strona);
    } else {
        echo 'Nie działa';
    }
?>
</body>
</html>
