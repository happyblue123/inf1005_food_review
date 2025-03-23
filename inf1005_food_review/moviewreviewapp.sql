CREATE TABLE users (
    userid INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE movies (
    movieid INT PRIMARY KEY,
    moviename VARCHAR(255) NOT NULL
);

CREATE TABLE reviews (
    reviewid INT AUTO_INCREMENT PRIMARY KEY,
    userid INT NOT NULL,
    movieid INT NOT NULL,
    rating INT CHECK (rating BETWEEN 1 AND 10),
    review_text TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userid) REFERENCES users(userid) ON DELETE CASCADE,
    FOREIGN KEY (movieid) REFERENCES movies(movieid) ON DELETE CASCADE
);

USE your_database_name;

CREATE TABLE IF NOT EXISTS reviews (
    reviewid INT AUTO_INCREMENT PRIMARY KEY,
    userid INT NOT NULL,
    movieid INT NOT NULL,
    moviename VARCHAR(255) NOT NULL,
    rating INT NOT NULL,
    review_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userid) REFERENCES users(userid),
    FOREIGN KEY (movieid) REFERENCES movies(movieid)
);

-- If the table already exists, you can add the missing columns
ALTER TABLE reviews ADD COLUMN IF NOT EXISTS moviename VARCHAR(255) NOT NULL;