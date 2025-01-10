-- Tworzenie bazy danych 'moja_strona' jeśli nie istnieje
CREATE DATABASE IF NOT EXISTS moja_strona;

-- Wybór bazy danych do użycia
USE moja_strona;

-- Tworzenie tabeli 'categories', jeśli nie istnieje
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Kolumna ID, która automatycznie inkrementuje się przy każdym nowym wierszu
    matka INT DEFAULT 0,                -- ID kategorii nadrzędnej (NULL dla kategorii głównych)
    nazwa VARCHAR(255) NOT NULL         -- Nazwa kategorii
);

-- Wstawianie przykładowych kategorii do tabeli 'categories'
INSERT INTO categories (nazwa, matka)
VALUES
    ('Wieżowce', 0),
    ('Informacje', 0),
    ('Filmy', 0);

-- AUTO_INCREMENT dla tabeli 'categories'
ALTER TABLE categories
  MODIFY id INT AUTO_INCREMENT, AUTO_INCREMENT=4;

-- Tworzenie tabeli 'page_list', jeśli nie istnieje
CREATE TABLE IF NOT EXISTS page_list (
    id INT AUTO_INCREMENT PRIMARY KEY,   -- Kolumna ID, która automatycznie inkrementuje się przy każdym nowym wierszu
    page_title VARCHAR(255) NOT NULL,     -- Tytuł strony, nie może być pusty
    page_content TEXT NOT NULL,           -- Treść strony, nie może być pusta
    status INT DEFAULT 1,                 -- Status strony (domyślnie ustawiony na 1, czyli aktywny)
    alias VARCHAR(20) UNIQUE,             -- Alias strony, musi być unikalny
    category_id INT,                      -- Kolumna do przypisania kategorii do strony
    FOREIGN KEY (category_id) REFERENCES categories(id)  -- Klucz obcy wskazujący na kategorię
);

-- Wstawianie przykładowych danych do tabeli 'page_list'
INSERT INTO page_list (page_title, page_content, status, alias, category_id)
VALUES
    ('Strona Główna', 'Zawartość strony głównej', 1, 'home', 2),         -- Przypisanie do kategorii "Informacje" (ID 2)
    ('Burj Khalifa', 'Zawartość strony Burj Khalifa', 1, 'burjkhalifa', 1),  -- Przypisanie do kategorii "Wieżowce" (ID 1)
    ('Kontakt', 'Zawartość strony Kontakt', 1, 'kontakt', 2),         -- Przypisanie do kategorii "Informacje" (ID 2)
    ('Filmy', 'Zawartość strony Filmy', 1, 'filmy', 3),               -- Przypisanie do kategorii "Filmy" (ID 3)
    ('Abradzalbajt', 'Zawartość strony Abradzalbajt', 1, 'abradzalbajt', 1), -- Przypisanie do k2ategorii "Wieżowce" (ID 1)
    ('Shanghai Tower', 'Zawartość strony Shanghai Tower', 1, 'shanghaitower', 1), -- Przypisanie do kategorii "Wieżowce" (ID 1)
    ('Ping An Finance Center', 'Zawartość strony Ping An Finance Center', 1, 'pinganfinancecenter', 1);  -- Przypisanie do kategorii "Wieżowce" (ID 1)

-- Tworzenie tabeli 'produkty'
CREATE TABLE IF NOT EXISTS produkty (
    id INT(11) NOT NULL AUTO_INCREMENT,     -- Kolumna ID, która automatycznie inkrementuje się
    tytul VARCHAR(255) NOT NULL,            -- Tytuł produktu
    opis TEXT DEFAULT NULL,                 -- Opis produktu
    data_utworzenia DATE NOT NULL DEFAULT CURRENT_TIMESTAMP(),   -- Data utworzenia
    data_modyfikacji DATE DEFAULT CURRENT_TIMESTAMP(),         -- Data modyfikacji
    data_wygasniecia DATE DEFAULT NULL,     -- Data wygasnięcia
    cena_netto DECIMAL(10,2) NOT NULL,      -- Cena netto
    podatek_vat DECIMAL(4,2) NOT NULL,      -- Podatek VAT
    ilosc INT(11) NOT NULL DEFAULT 0,       -- Ilość dostępnych sztuk
    status_dostepnosci TINYINT(1) NOT NULL DEFAULT 1,  -- Status dostępności
    gabaryt ENUM('mały', 'średni', 'duży', 'transport') DEFAULT 'mały',  -- Gabaryt produktu
    zdjecie VARCHAR(255) DEFAULT NULL,      -- Link do zdjęcia produktu
    category_id INT(11) NOT NULL,           -- ID kategorii
    PRIMARY KEY (id),                      -- Klucz główny
    FOREIGN KEY (category_id) REFERENCES categories(id)  -- Klucz obcy wskazujący na kategorię
);

-- Wstawianie przykładowych danych do tabeli 'produkty'
INSERT INTO produkty (tytul, opis, data_utworzenia, data_modyfikacji, data_wygasniecia, cena_netto, podatek_vat, ilosc, status_dostepnosci, gabaryt, zdjecie, category_id)
VALUES
    ('Statuetka', 'Statuetka jednego z największych budynków na świecie Burj Khalifa', '2025-01-01', '2025-01-06', '2025-01-31', 139.00, 32.00, 10, 2, 'mały', 'https://img.fruugo.com/product/5/29/1672195295_max.jpg', 1),
    ('Lego', 'Lego Burj Khalifa', '2025-01-01', '2025-01-06', '2025-01-31', 720.00, 165.00, 7, 1, 'średni', 'https://ecsmedia.pl/cdn-cgi/image/format=webp,width=544,height=544,/c/lego-architecture-21055-burj-khalifa-b-iext143627251.jpg', 2),
    ('Pejzaż', 'Szanghajski pejzaż Chin', '2025-01-01', '2025-01-06', '2025-01-31', 73.00, 7.00, 3, 1, 'duży', 'https://i.etsystatic.com/13960986/r/il/fb6473/5582065270/il_794xN.5582065270_96js.jpg', 3);

-- Dodawanie indeksów dla tabeli 'produkty'
ALTER TABLE produkty
    ADD KEY category_id (category_id);

-- AUTO_INCREMENT dla tabeli 'produkty'
ALTER TABLE produkty
    MODIFY id INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
