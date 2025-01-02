$(document).ready(function() {
    // Animacja uruchamiana po kliknięciu na element o id 'animacjaTestowal'
    $("#animacjaTestowal").on("click", function(){
        $(this).animate({
            width: "500px",  // Zmiana szerokości
            opacity: 0.4,    // Zmiana przezroczystości
            fontSize: "3em", // Zmiana rozmiaru czcionki
            borderWidth: "10px"  // Zmiana szerokości obramowania
        }, 1500);  // Czas trwania animacji (1500ms)
    });

    // Animacja rozwijania i zwijania obrazków w 'image-container2'
    $(".image-container2").on("click", function() {
        const $image = $(this);  // Zapisanie odwołania do klikniętego obrazu
        const isExpanded = $image.data("expanded");  // Sprawdzenie, czy obrazek jest rozwinięty

        // Jeśli obrazek jest rozwinięty, zmniejszamy go
        if (isExpanded) {
            $image.animate({
                width: "200px",  // Przywrócenie szerokości
                opacity: 1       // Przywrócenie pełnej przezroczystości
            }, 1500);  // Czas trwania animacji
        } else {
            // Jeśli obrazek nie jest rozwinięty, powiększamy go
            $image.animate({
                width: "500px",  // Powiększenie szerokości
                opacity: 0.8     // Zmniejszenie przezroczystości
            }, 1500);  // Czas trwania animacji
        }

        // Zmieniamy stan rozwinięcia obrazu
        $image.data("expanded", !isExpanded);
    });

    // Animacja obrazków w 'image-container' po najechaniu myszką
    $(".image-container").on({
        "mouseover": function() {
            // Powiększenie obrazka po najechaniu myszką
            $(this).animate({
                width: 300,  // Zwiększenie szerokości
                height: 300  // Zwiększenie wysokości
            }, 800);  // Czas trwania animacji
        },
        "mouseout": function() {
            // Przywrócenie rozmiaru po opuszczeniu myszką
            $(this).animate({
                width: 200,  // Przywrócenie szerokości
                height: 200  // Przywrócenie wysokości
            }, 800);  // Czas trwania animacji
        }
    });

    // Animacja obrazków w 'image-container2' po najechaniu myszką
    $(".image-container2").on({
        "mouseover": function() {
            // Powiększenie obrazka po najechaniu myszką
            $(this).animate({
                width: 300,  // Zwiększenie szerokości
                height: 300  // Zwiększenie wysokości
            }, 800);  // Czas trwania animacji
        },
        "mouseout": function() {
            // Przywrócenie rozmiaru po opuszczeniu myszką
            $(this).animate({
                width: 200,  // Przywrócenie szerokości
                height: 200  // Przywrócenie wysokości
            }, 800);  // Czas trwania animacji
        }
    });

    let clickCounter = 0;  // Licznik kliknięć

    // Animacja powiększania obrazka po kliknięciu
    $(".image-container").on("click", function() {
        // Sprawdzenie, czy element nie jest aktualnie animowany
        if (!$(this).is(":animated")) {
            clickCounter++;  // Zwiększenie licznika kliknięć

            // Jeśli kliknięto mniej niż 5 razy, powiększamy obrazek
            if (clickCounter < 5) {
                $(this).animate({
                    width: "+=20",  // Powiększenie szerokości
                    height: "+=20",  // Powiększenie wysokości
                    opacity: "+=0.1"  // Zwiększenie przezroczystości
                }, {
                    duration: 500  // Czas trwania animacji
                });
            } else {
                // Jeśli kliknięto 5 razy, przywracamy oryginalny rozmiar
                $(this).animate({
                    width: "200px",  // Przywrócenie szerokości
                    height: "200px",  // Przywrócenie wysokości
                    opacity: 1  // Przywrócenie pełnej przezroczystości
                }, {
                    duration: 500  // Czas trwania animacji
                });

                clickCounter = 0;  // Resetowanie licznika kliknięć
            }
        }
    });

});
