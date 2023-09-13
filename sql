CREATE TABLE User (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255),
    Email VARCHAR(255)
);

CREATE TABLE Book (
    BookID INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(255) NOT NULL,
    Author VARCHAR(255) NOT NULL,
    Price DECIMAL(10, 2),
    ImageURL VARCHAR(255),
    Genre VARCHAR(255) NOT NULL,
    Description TEXT
);

CREATE TABLE Books (
    BookID INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(255) NOT NULL,
    Author VARCHAR(255) NOT NULL,
    Price DECIMAL(10, 2),
    ImageURL VARCHAR(255),
    Category VARCHAR(255) NOT NULL
);

CREATE TABLE Review (
    ReviewID INT AUTO_INCREMENT PRIMARY KEY,
    BookID INT,
    UserID INT,
    Rating INT,
    Comment TEXT,
    FOREIGN KEY (BookID) REFERENCES BookID,
    FOREIGN KEY (UserID) REFERENCES UserID
);

INSERT INTO Books (Title, Author, Price, ImageURL, Category) VALUES 
('Thinking in Java', 'Bruce Eckel', 99.00, './Image/Effective Java Programming.png', 'Programming'),
('The Marxification of Education', 'James Lindsay', 28.48, './Image/The Marxification of Education(Education).png', 'Education'),
('Reminders of Him', 'Colleen Hoover', 16.00, './Image/Reminders of Him(Novel).png', 'Novel'),
('The Complete Far Side', 'Gary Larson', 200.00, './Image/The Complete Far Side(Cartoon).png', 'Cartoon'),
('History of the World Map by Map', 'DK', 70.61, './Image/History of the World Map by Map.png', 'History');

INSERT INTO Book (Title, Author, Price, ImageURL, Genre, Description) VALUES
('The Metamorphosis', 'Franz Kafka', 12.99, '#', 'Fiction', 'A man wakes up one morning to find himself transformed into a giant insect.'),
('In Search of Lost Time', 'Marcel Proust', 24.99, '#', 'Fiction', 'A novel in seven volumes, exploring the themes of memory, time, and art.'),
('The Stranger', 'Albert Camus', 8.99, '#', 'Fiction', 'A man living in French Algiers kills an Arab and struggles with the consequences of his actions.');

INSERT INTO User (ID, Name, Email) VALUES
(1, 'Alice Smith', 'alice@example.com'),
(2, 'Bob Johnson', 'bob@example.com'),
(3, 'Charlie Brown', 'charlie@example.com');

INSERT INTO Review (BookID, UserID, Rating, Comment) VALUES
(1, 1, 4, "I really enjoyed this book! It was a bit strange, but in a good way."),
(1, 2, 3, "Not my favorite, but still worth a read."),
(2, 1, 5, "This book was amazing! I couldn't put it down."),
(2, 3, 4, "A bit long-winded, but very well-written."),
(3, 2, 2, "I didn't really connect with this book."),
(3, 3, 3, "An interesting read, but not my favorite.");