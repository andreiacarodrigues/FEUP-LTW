PRAGMA FOREIGN_KEYS = ON;

CREATE TABLE User (
	userId INTEGER PRIMARY KEY AUTOINCREMENT,
	name NVARCHAR2(100) NOT NULL,
	email NVARCHAR2(100) NOT NULL,
	birthdate DATE NOT NULL,
	postCode NVARCHAR2(8),
	username NVARCHAR2(100) UNIQUE NOT NULL,
	password  NVARCHAR2(100) NOT NULL,
	photoId INTEGER,
	FOREIGN KEY(photoId) REFERENCES Photo(photoId) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Restaurant (
	restaurantId INTEGER PRIMARY KEY AUTOINCREMENT,
	name NVARCHAR2(100) NOT NULL,
	description NVARCHAR2(200),
	location NVARCHAR2(100),
	postCode NVARCHAR2(8),
	contact INTEGER NOT NULL CHECK (contact > 0),
	avgPrice REAL CHECK (avgPrice > 0),
	schedule NVARCHAR2(200),
	observation NVARCHAR2(200),
	menuId INTEGER, 
	photoId INTEGER,
	rating_sum REAL CHECK (rating_sum >= 0),
	rating_total REAL CHECK (rating_total >= 0),
	owner NVARCHAR2(100)
);

CREATE TABLE Review (
	reviewId INTEGER PRIMARY KEY AUTOINCREMENT,
	username NVARCHAR2(100),
	restaurantId INTEGER,
	rating INTEGER NOT NULL CHECK (rating > 0 AND rating <= 5),
	text NVARCHAR(400),
	date Date,
	FOREIGN KEY(restaurantId) REFERENCES Restaurant(restaurantId) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(username) REFERENCES User(username) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Photo (
	photoId INTEGER PRIMARY KEY AUTOINCREMENT,
	filename NVARCHAR2(200)
);

CREATE TABLE RestaurantPhoto (
	photoId INTEGER,
	restaurantId INTEGER,
	PRIMARY KEY(restaurantId, photoId),
	FOREIGN KEY(restaurantId) REFERENCES Restaurant(restaurantId) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(photoId) REFERENCES Photo(photoId) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE ReviewPhoto (
	reviewId INTEGER,
	photoId INTEGER,
	FOREIGN KEY(photoId) REFERENCES Photo(photoId) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(reviewId) REFERENCES Review(reviewId) ON DELETE CASCADE ON UPDATE CASCADE
	
);

CREATE TABLE ReviewReply (
	reviewId INTEGER,
	username NVARCHAR2(100),
	text NVARCHAR2(100),
	FOREIGN KEY(reviewId) REFERENCES Review(reviewId) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(username) REFERENCES User(username) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Friend (
	username1 NVARCHAR2(100),
	username2 NVARCHAR2(100),
	FOREIGN KEY(username2) REFERENCES User(username) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(username1) REFERENCES User(username) ON DELETE CASCADE ON UPDATE CASCADE
);


INSERT INTO Photo VALUES (1,'1.jpg');
INSERT INTO Photo VALUES (2,'2.jpg');
INSERT INTO Photo VALUES (3,'3.jpg');

INSERT INTO User VALUES (NULL, 'ines','ola@a.com','01-01-2016','1234-123','ines','ines',1);
INSERT INTO User VALUES (NULL, 'andreia','ola@a.com','01-01-2016','1234-123','andreia','andreia',1);


INSERT INTO Restaurant VALUES (1,'montaditos','restaurante espanhol','Porto','1234-123','12345689','5','24h',null,3,2,4,4,'andre');
INSERT INTO Restaurant VALUES (2,'mcdonalds','restaurante amaricano','Lisboa','1234-123','123456789','4','12h',null,3,2,3,3,'andre');

INSERT INTO Review VALUES (1,'ines',1,4,'rapido e bom','2016-05-01');
INSERT INTO Review VALUES (2,'ines',2,3,'cheira muito a fritos','2016-05-01');
INSERT INTO Review VALUES (3,'andreia',2,4,'foi fixe','2014-01-26');
INSERT INTO Review VALUES (4,'andreia',1,4,'muito fixe','2016-05-01');

INSERT INTO ReviewPhoto VALUES (1,1);
INSERT INTO ReviewPhoto VALUES (2,1);
INSERT INTO ReviewPhoto VALUES (1,2);

INSERT INTO RestaurantPhoto VALUES (1,1);
INSERT INTO RestaurantPhoto VALUES (2,1);

INSERT INTO Friend VALUES ('ines','andreia');
INSERT INTO Friend VALUES ('andreia','ines');