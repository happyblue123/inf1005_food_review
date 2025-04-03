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
    moviename VARCHAR(255) NOT NULL,
    rating INT NOT NULL,
    review_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userid) REFERENCES users(userid),
    FOREIGN KEY (movieid) REFERENCES movies(movieid)
);

CREATE TABLE watchlist (
    userid INT NOT NULL,
    movieid INT NOT NULL,
    moviename VARCHAR(255) NOT NULL,
    PRIMARY KEY (userid, movieid),
    FOREIGN KEY (userid) REFERENCES users(userid) ON DELETE CASCADE,
    FOREIGN KEY (movieid) REFERENCES movies(movieid) ON DELETE CASCADE
);

CREATE TABLE `watchhistory` (
    `userid` INT(11) NOT NULL,
    `movieid` INT(11) NOT NULL,
    `moviename` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`userid`, `movieid`),
    FOREIGN KEY (`userid`) REFERENCES users(`userid`) ON DELETE CASCADE,
    FOREIGN KEY (`movieid`) REFERENCES movies(`movieid`) ON DELETE CASCADE
);


CREATE TABLE chatrooms (
    chatroomid INT AUTO_INCREMENT PRIMARY KEY,
    chatroom_name VARCHAR(255) NOT NULL,
    userid INT NOT NULL,
    FOREIGN KEY (userid) REFERENCES users(userid) ON DELETE CASCADE
);
