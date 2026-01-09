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

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    listing_id INT NOT NULL,
    user_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    guests INT,
    total_price DECIMAL(10, 2),
    status ENUM('confirmed', 'cancelled', 'completed') DEFAULT 'confirmed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (listing_id) REFERENCES listing(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE (
id INT AUTO_INCREMENT PRIMARY KEY,
    traveler_id INT NOT NULL,
    listing_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_fav (user_id, listing_id),
    FOREIGN KEY (traveler_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (listing_id) REFERENCES listing(id) ON DELETE CASCADE   
)