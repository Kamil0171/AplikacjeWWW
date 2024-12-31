// Funkcja do pobierania aktualnej daty i jej formatowania
function gettheDate() {
    var today = new Date();  // Tworzymy obiekt reprezentujący bieżącą datę i godzinę
    var day = String(today.getDate()).padStart(2, '0');  // Pobieramy dzień i formatujemy go na 2 cyfry
    var month = String(today.getMonth() + 1).padStart(2, '0');  // Pobieramy miesiąc i formatujemy go na 2 cyfry
    var year = today.getFullYear();  // Pobieramy rok
    var formattedDate = day + "." + month + "." + year;  // Łączymy dzień, miesiąc i rok w odpowiedni format
    document.getElementById("data").innerHTML = formattedDate;  // Wyświetlamy sformatowaną datę w elemencie o id "data"
}

// Zmienna do przechowywania identyfikatora timera
var timerID = null;
// Zmienna do sprawdzania, czy zegar jest uruchomiony
var timerRunning = false;

// Funkcja do zatrzymania zegara
function stopclock() {
    if (timerRunning)
        clearTimeout(timerID);  // Zatrzymanie timera, jeśli zegar jest uruchomiony
    timerRunning = false;  // Ustawienie statusu zegara na zatrzymany
}

// Funkcja do rozpoczęcia zegara
function startclock() {
    stopclock();  // Zatrzymanie zegara przed rozpoczęciem nowego
    gettheDate();  // Pobranie i wyświetlenie bieżącej daty
    showtime();  // Rozpoczęcie pokazywania godziny
}

// Funkcja do wyświetlania aktualnej godziny
function showtime() {
    var now = new Date();  // Tworzymy obiekt reprezentujący bieżącą datę i godzinę
    var hours = String(now.getHours()).padStart(2, '0');  // Pobieramy godziny i formatujemy je na 2 cyfry
    var minutes = String(now.getMinutes()).padStart(2, '0');  // Pobieramy minuty i formatujemy je na 2 cyfry
    var seconds = String(now.getSeconds()).padStart(2, '0');  // Pobieramy sekundy i formatujemy je na 2 cyfry
    var timevalue = hours + ":" + minutes + ":" + seconds;  // Łączymy godziny, minuty i sekundy w jeden ciąg
    document.getElementById("zegarek").innerHTML = timevalue;  // Wyświetlamy czas w elemencie o id "zegarek"
    timerID = setTimeout("showtime()", 1000);  // Ustawiamy timer do ponownego wywołania funkcji za 1 sekundę
    timerRunning = true;  // Ustawiamy status zegara na uruchomiony
}
