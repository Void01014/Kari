CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(255) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,

  role ENUM('traveler','host','admin') NOT NULL DEFAULT 'traveler',
  status ENUM('active','disabled') NOT NULL DEFAULT 'active',

  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
) 

CREATE TABLE listings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hostID INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    price_per_night DECIMAL(10, 2) NOT NULL,
    description TEXT NOT NULL,
    image_url TEXT, 
    status ENUM('active', 'disabled') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (host_id) REFERENCES users(id) ON DELETE CASCADE
);