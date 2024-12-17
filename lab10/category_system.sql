
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    matka INT DEFAULT 0,
    nazwa VARCHAR(255) NOT NULL,
    FOREIGN KEY (matka) REFERENCES categories(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Sample categories for testing
INSERT INTO categories (matka, nazwa) VALUES (0, 'Electronics');
INSERT INTO categories (matka, nazwa) VALUES (0, 'Home Appliances');
INSERT INTO categories (matka, nazwa) VALUES (1, 'Mobile Phones');
INSERT INTO categories (matka, nazwa) VALUES (1, 'Laptops');
INSERT INTO categories (matka, nazwa) VALUES (3, 'Smartphones');
