CREATE TABLE user_accounts (
	user_id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(255),
	first_name VARCHAR(255),
	last_name VARCHAR(255),
	password TEXT,
	date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);


CREATE TABLE Albums (
    AlbumID INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    AlbumName VARCHAR(255) NOT NULL,
    Description TEXT,
    DateCreated DATETIME DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE Photos (
    PhotoID INT AUTO_INCREMENT PRIMARY KEY,
    AlbumID INT NOT NULL, 
    PhotoURL VARCHAR(255) NOT NULL,
    Caption TEXT,
    DateUploaded DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_id INT,
    username VARCHAR(255)
);