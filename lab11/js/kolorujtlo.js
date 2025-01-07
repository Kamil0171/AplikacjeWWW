// Zmienna pomocnicza do przechowywania stanu obliczeń
var computed = false;

// Zmienna pomocnicza do przechowywania stanu przecinka dziesiętnego
var decimal = 0;

// Funkcja do konwersji jednostek
function convert(entryform, from, to) {
    // Pobranie indeksu wybranej jednostki 'from' i 'to'
    convertfrom = from.selectedIndex;
    convertto = to.selectedIndex;

    // Wykonanie konwersji jednostek i wyświetlenie wyniku
    entryfrom.display.value = (entryfrom.input.value * from[convertfrom].value / to[convertto].value);
}

// Funkcja do dodawania znaków (np. liczb, przecinków) do formularza
function addChar(input, character) {
    // Warunek, aby dodać tylko znak, jeśli nie jest to drugi przecinek dziesiętny
    if ((character == '.' && decimal == "0" || character != '.')) {
        // Jeśli pole jest puste lub ma wartość 0, przypisujemy znak, w przeciwnym przypadku dodajemy go na końcu
        (input.value == "" || input.value == "0") ? input.value = character : input.value += character;

        // Wywołanie funkcji konwersji jednostek
        convert(input.form, input.form.measure1, input.form.measure2);
        computed = true;

        // Jeśli wprowadzono przecinek dziesiętny, ustawiamy zmienną decimal na 1
        if (character == '.') {
            decimal = 1;
        }
    }
}

// Funkcja otwierająca okno pomocnicze
function openVothcom() {
    window.open("", "Display window", "toolbar=no,directories=no,menubar=no");
}

// Funkcja czyszcząca formularz
function clear(form) {
    // Ustawienie wartości pola wejściowego i wyświetlania na 0
    form.input.value = 0;
    form.display.value = 0;
    decimal = 0;  // Resetowanie zmiennej decimal
}

// Funkcja zmieniająca kolor tła strony
function changeBackground(bc) {
    document.body.style.backgroundColor = bc;  // Zmiana koloru tła
}
