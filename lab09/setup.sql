CREATE DATABASE IF NOT EXISTS moja_strona;

USE moja_strona;

CREATE TABLE IF NOT EXISTS page_list (
id INT AUTO_INCREMENT PRIMARY KEY,
page_title VARCHAR(255),
page_content TEXT,
status INT DEFAULT 1
);

INSERT INTO page_list (page_title, page_content, status) VALUES
('Home', 'Welcome to the home page.', 1),
('About', 'This is the about page.', 1),
('Contact', 'Get in touch through this page.', 1);
