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


CREATE TABLE UserTable (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(100) NOT NULL
);

CREATE TABLE Wishlist (
    user_id INT,
    book_id INT,
    date_added DATE NOT NULL,
    PRIMARY KEY (user_id, book_id),
    FOREIGN KEY (user_id) REFERENCES UserTable(id),
    FOREIGN KEY (book_id) REFERENCES Books(BookID)
);

CREATE TABLE Reviews (
    ReviewID INT AUTO_INCREMENT PRIMARY KEY,
    BookID INT NOT NULL,
    ReviewerName VARCHAR(255) NOT NULL,
    Rating INT NOT NULL,
    ReviewText TEXT,
    ReviewDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (BookID) REFERENCES Books(BookID)
);

INSERT INTO Reviews (BookID, ReviewerName, Rating, ReviewText) VALUES
(1, 'John Doe', 4, 'Great book! I loved the characters and the plot.'),
(2, 'Jane Smith', 5, 'An absolute masterpiece. This book is a must-read for everyone.'),
(3, 'Alice Johnson', 3, 'The book was okay, but it could have been better.'),
(4, 'Bob Wilson', 4, 'Enjoyed reading it. The author did a great job.'),
(5, 'Eva Brown', 5, 'One of the best books I have ever read. Highly recommended.');

CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cart_id VARCHAR(255) NOT NULL,
    book_id INT NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (book_id) REFERENCES Books(BookID)
);

CREATE TABLE IF NOT EXISTS Orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    orderNumber VARCHAR(255) NOT NULL,
    items TEXT NOT NULL,  
    totalAmount DECIMAL(10,2) NOT NULL,  
    orderDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS payment_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    card_number VARCHAR(16) NOT NULL,
    expiry VARCHAR(5) NOT NULL,  
    cvc VARCHAR(3) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES Orders(id)
);

CREATE TABLE shipment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED,
    country VARCHAR(255),
    city VARCHAR(255),
    postcode VARCHAR(255),
    street_address VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES usertable(user_id)
);
