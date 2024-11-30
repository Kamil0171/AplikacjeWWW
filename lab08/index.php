<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

if($_GET['idp'] == 'filmy') $strona = '/lab05/html/filmy.html';

if(empty($_GET['idp'])) $strona = '/lab05/html/glowna.html';
if($_GET['idp'] == 'podstrona1') $strona = '/lab05/html/abradzalbajt.html';
if($_GET['idp'] == 'podstrona2') $strona = '/lab05/html/burjkhalifa.html';

if (file_exists(__DIR__ . $strona)) {
    include(__DIR__ . $strona);
} else {
    echo 'Requested page not found.';
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="Content-Language" content="pl">
    <meta name="Author" content="Kamil Amarasekara">
    <title>Największe budynki świata</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="js/kolorujtlo.js" type="text/javascript"></script>
    <script src="js/timedate.js" type="text/javascript"></script>
</head>
<body onload="startclock()">
    <header>
        <h1>Największe budynki świata</h1>
        <nav>
            <ul>
                <li><a href="index.html">Strona główna</a></li>
                <li><a href="index.php?idp=podstrona2">Burj Khalifa</a></li>
                <li><a href="html/shanghaitower.html">Shanghai Tower</a></li>
                <li><a href="index.php?idp=podstrona1">Abradż al-Bajt</a></li>
                <li><a href="index.php?idp=pinganfinancecenter">Ping An Finance Center</a></li>
				<li><a href="index.php?idp=filmy">Filmy</a></li>
                <li><a href="html/kontakt.html">Kontakt</a></li>
            </ul>
        </nav>

        <div class="time-date">
            <div id="zegarek"></div>
            <div id="data"></div>
        </div>

        <div class="background-options">
            <INPUT TYPE="button" VALUE="Szary" ONCLICK="changeBackground('#808080')">
            <INPUT TYPE="button" VALUE="Biały" ONCLICK="changeBackground('#FFFFFF')">
        </div>
    </header>

    <section>
        <p>Oto 4 najwyższe budynki na świecie</p>
        <ul class="buildings-list">
            <li>Burj Khalifa</li>
            <li>Shanghai Tower</li>
            <li>Abradż al-Bajt</li>
            <li>Ping An Finance Center</li>
        </ul>

        <div class="gallery gallery-home">
            <img src="img/bud1.jpg" class="gallery-img" id="animacjaImg1" alt="Zdjęcie budynku 1">
            <img src="img/bud2.jpg" class="gallery-img" id="animacjaImg2" alt="Zdjęcie budynku 2">
        </div>
    </section>
    
    <footer>
        <p>Kamil Amarasekara ISI1, 169222</p>
    </footer>

    <script>

        $("#animacjaImg1").on("click", function(){
            $(this).animate({
                width: "500px",
                opacity: 0.6
            }, 1500);
        });

        $("#animacjaImg2").on({
            "mouseover": function(){
                $(this).animate({ width: "300px" }, 800);
            },
            "mouseout": function(){
                $(this).animate({ width: "200px" }, 800);
            }
        });
    </script>


<?php
$nr_indeksu = '169222';
$nrGrupy = '1';
echo 'Autor: Kamil Amarasekara ' . $nr_indeksu . ' grupa ' . $nrGrupy . '<br />';
?>

</body>
</html>