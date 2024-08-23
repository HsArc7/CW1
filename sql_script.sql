-- Creating the database
CREATE DATABASE car_rental;

-- Using the database
USE car_rental;

-- Creating table for cars
CREATE TABLE cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price INT NOT NULL
);

-- Inserting sample data into cars table
INSERT INTO cars (name, price) VALUES
('Nissan Navara Pro 4x', 12000),
('Toyota RAV4', 9500),
('Ford Figo', 7500),
('Hyundai Venue', 8500),
('TATA Safari', 10000),
('Mahindra Scorpio Camper', 8500);

-- Creating table for users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Creating table for bookings
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    car_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    total_amount INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (car_id) REFERENCES cars(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

