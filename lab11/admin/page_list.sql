-- Tworzenie bazy danych 'moja_strona' jeśli nie istnieje
CREATE DATABASE IF NOT EXISTS moja_strona;

-- Wybór bazy danych do użycia
USE moja_strona;

-- Tworzenie tabeli 'categories', jeśli nie istnieje
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Kolumna ID, która automatycznie inkrementuje się przy każdym nowym wierszu
    matka INT DEFAULT 0,  -- ID kategorii nadrzędnej (NULL dla kategorii głównych)
    nazwa VARCHAR(255) NOT NULL  -- Nazwa kategorii
);

-- Wstawianie przykładowych kategorii do tabeli 'categories'
INSERT INTO categories (nazwa, matka)
VALUES
    ('Wieżowce', 0),  -- Kategoria główna
    ('Informacje', 0),  -- Kategoria główna
    ('Filmy', 0);  -- Kategoria główna

-- Dodawanie indeksów dla tabeli 'categories'
ALTER TABLE categories
  ADD PRIMARY KEY (id);

-- AUTO_INCREMENT dla tabeli 'categories'
ALTER TABLE categories
  MODIFY id INT AUTO_INCREMENT, AUTO_INCREMENT=4;

-- Tworzenie tabeli 'page_list', jeśli nie istnieje
CREATE TABLE IF NOT EXISTS page_list (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Kolumna ID, która automatycznie inkrementuje się przy każdym nowym wierszu
    page_title VARCHAR(255) NOT NULL,  -- Tytuł strony, nie może być pusty
    page_content TEXT NOT NULL,  -- Treść strony, nie może być pusta
    status INT DEFAULT 1,  -- Status strony (domyślnie ustawiony na 1, czyli aktywny)
    alias VARCHAR(20) UNIQUE,  -- Alias strony, musi być unikalny
    category_id INT,  -- Kolumna do przypisania kategorii do strony
    FOREIGN KEY (category_id) REFERENCES categories(id)  -- Klucz obcy wskazujący na kategorię
);

-- Wstawianie przykładowych danych do tabeli 'page_list'
INSERT INTO page_list (page_title, page_content, status, alias, category_id)
VALUES
    ('Strona Główna', 'Zawartość strony głównej', 1, 'home', 2),  -- Przypisanie do kategorii "Informacje" (ID 2)
    ('Burj Khalifa', 'Zawartość strony Burj Khalifa', 1, 'burjkhalifa', 1),  -- Przypisanie do kategorii "Wieżowce" (ID 1)
    ('Kontakt', 'Zawartość strony Kontakt', 1, 'kontakt', 2),  -- Przypisanie do kategorii "Informacje" (ID 2)
    ('Filmy', 'Zawartość strony Filmy', 1, 'filmy', 3),  -- Przypisanie do kategorii "Filmy" (ID 3)
    ('Abradzalbajt', 'Zawartość strony Abradzalbajt', 1, 'abradzalbajt', 1),  -- Przypisanie do kategorii "Wieżowce" (ID 1)
    ('Shanghai Tower', 'Zawartość strony Shanghai Tower', 1, 'shanghaitower', 1),  -- Przypisanie do kategorii "Wieżowce" (ID 1)
    ('Ping An Finance Center', 'Zawartość strony Ping An Finance Center', 1, 'pinganfinancecenter', 1);  -- Przypisanie do kategorii "Wieżowce" (ID 1)
