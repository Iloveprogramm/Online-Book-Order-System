CREATE TABLE Books (
    BookID INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(255) NOT NULL,
    Author VARCHAR(255) NOT NULL,
    Price DECIMAL(10, 2),
    ImageURL VARCHAR(255),
    Category VARCHAR(255) NOT NULL
);

INSERT INTO Books (Title, Author, Price, ImageURL, Category) VALUES 
('Thinking in Java', 'Bruce Eckel', 99.00, './Image/Effective Java Programming.png', 'Programming'),
('The Marxification of Education', 'James Lindsay', 28.48, './Image/The Marxification of Education(Education).png', 'Education'),
('Reminders of Him', 'Colleen Hoover', 16.00, './Image/Reminders of Him(Novel).png', 'Novel'),
('The Complete Far Side', 'Gary Larson', 200.00, './Image/The Complete Far Side(Cartoon).png', 'Cartoon'),
('History of the World Map by Map', 'DK', 70.61, './Image/History of the World Map by Map.png', 'History');
