CREATE USER 'testuser'@'localhost' IDENTIFIED BY 'TestPass123!';

GRANT ALL PRIVILEGES ON bookonlineorder.* TO 'testuser'@'localhost';

FLUSH PRIVILEGES;


CREATE TABLE Books (
    BookID INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(255) NOT NULL,
    Author VARCHAR(255) NOT NULL,
    Price DECIMAL(10, 2),
    ImageURL VARCHAR(255),
    Category VARCHAR(255) NOT NULL,
    Description TEXT
);

INSERT INTO Books (Title, Author, Price, ImageURL, Category, Description) VALUES
('Thinking in Java', 'Bruce Eckel', 99.00, './Image/Effective Java Programming.png', 'Programming', 'A classic book for learning Java programming with various examples and exercises.'),
('The Marxification of Education', 'James Lindsay', 28.48, './Image/The Marxification of Education(Education).png', 'Education', 'An exploration of the influence of Marxism in shaping current educational policies.'),
('Reminders of Him', 'Colleen Hoover', 16.00, './Image/Reminders of Him(Novel).png', 'Novel', 'A heartfelt novel about love, loss, and redemption.'),
('The Complete Far Side', 'Gary Larson', 200.00, './Image/The Complete Far Side(Cartoon).png', 'Cartoon', 'A collection of iconic comics from The Far Side.'),
('History of the World Map by Map', 'DK', 70.61, './Image/History of the World Map by Map.png', 'History', 'A visual representation of global history, told through maps.');



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

CREATE TABLE shipping_Companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(255) NOT NULL,
    date_added DATE NOT NULL,
    cost_per_Kilo DECIMAL(10, 2) NOT NULL,
    phone_number VARCHAR(255) NOT NULL,
    email_address VARCHAR(255) NOT NULL,
    average_shipping_time INT NOT NULL
);

INSERT INTO shipping_Companies (company_name, date_added, cost_per_Kilo, phone_number, email_address, average_shipping_time) VALUES
('Fastway Shipping', '2012-08-18', 13.50, '0487653132', 'FastwayShipping@email.com', 2),
('Medium Transport group', '2017-01-09', 10.00, '0439146232', 'MedTranspG@email.com', 5),
('Scenic couriers', '2016-06-07', 7.50, '0429099142', 'Scenic@email.com', 8);

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
    user_id VARCHAR(100) NOT NULL,
    country VARCHAR(255),
    city VARCHAR(255),
    postcode VARCHAR(255),
    street_address VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES UserTable(user_id)
) ENGINE=InnoDB;


CREATE TABLE book_edit_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    old_value TEXT NOT NULL,
    new_value TEXT NOT NULL,
    edited_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
