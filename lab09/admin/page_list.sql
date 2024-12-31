-- Tworzenie bazy danych 'moja_strona' jeśli nie istnieje
CREATE DATABASE IF NOT EXISTS moja_strona;

-- Wybór bazy danych do użycia
USE moja_strona;

-- Tworzenie tabeli 'page_list', jeśli nie istnieje
CREATE TABLE IF NOT EXISTS page_list (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Kolumna ID, która automatycznie inkrementuje się przy każdym nowym wierszu
    page_title VARCHAR(255) NOT NULL,  -- Tytuł strony, nie może być pusty
    page_content TEXT NOT NULL,  -- Treść strony, nie może być pusta
    status INT DEFAULT 1,  -- Status strony (domyślnie ustawiony na 1, czyli aktywny)
    alias VARCHAR(20) UNIQUE  -- Alias strony, musi być unikalny
);

-- Wstawianie przykładowych danych do tabeli 'page_list'
INSERT INTO page_list (page_title, page_content, status, alias)
VALUES
    ('Strona Główna', 'Zawartość strony głównej', 1, 'home'),
    ('Burj Khalifa', 'Zawartość strony Burj Khalifa', 1, 'burjkhalifa'),
    ('Kontakt', 'Zawartość strony Kontakt', 1, 'kontakt'),
    ('Filmy', 'Zawartość strony Filmy', 1, 'filmy'),
    ('Abradzalbajt', 'Zawartość strony Abradzalbajt', 1, 'abradzalbajt'),t
    ('Shanghai Tower', 'Zawartość strony Shanghai Tower', 1, 'shanghaitower'),
    ('Ping An Finance Center', 'Zawartość strony Ping An Finance Center', 1, 'pinganfinancecenter');
