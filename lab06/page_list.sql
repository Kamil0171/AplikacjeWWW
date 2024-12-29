CREATE DATABASE IF NOT EXISTS moja_strona;

USE moja_strona;

CREATE TABLE IF NOT EXISTS page_list (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_title VARCHAR(255) NOT NULL,
    page_content TEXT NOT NULL,
    status INT DEFAULT 1,
    alias VARCHAR(20) UNIQUE
);

INSERT INTO page_list (page_title, page_content, status, alias)
VALUES
    ('Strona Główna', 'Zawartość strony głównej', 1, 'home'),
    ('Burj Khalifa', 'Zawartość strony Burj Khalifa', 1, 'burjkhalifa'),
    ('Kontakt', 'Zawartość strony Kontakt', 1, 'kontakt'),
    ('Filmy', 'Zawartość strony Filmy', 1, 'filmy'),
    ('Abradzalbajt', 'Zawartość strony Abradzalbajt', 1, 'abradzalbajt'),
    ('Shanghai Tower', 'Zawartość strony Shanghai Tower', 1, 'shanghaitower'),
    ('Ping An Finance Center', 'Zawartość strony Ping An Finance Center', 1, 'pinganfinancecenter');
