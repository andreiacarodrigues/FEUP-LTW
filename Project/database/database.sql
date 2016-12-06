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
	description NVARCHAR2(200) NOT NULL,
	location NVARCHAR2(100) NOT NULL,
	contact INTEGER NOT NULL CHECK (contact > 0),
	avgPrice REAL CHECK (avgPrice > 0),
	schedule NVARCHAR2(200) NOT NULL,
	observation NVARCHAR2(200),
	menuId INTEGER, 
	photoId INTEGER NOT NULL,
	rating_sum REAL CHECK (rating_sum > 0),
	rating_total REAL CHECK (rating_total > 0),
	owner NVARCHAR2(100)
);

CREATE TABLE Review (
	reviewId INTEGER PRIMARY KEY AUTOINCREMENT,
	username NVARCHAR2(100),
	restaurantId INTEGER,
	rating INTEGER NOT NULL CHECK (rating > 0 AND rating < 5),
	text NVARCHAR(400),
	date Date,
	FOREIGN KEY(restaurantId) REFERENCES Restaurant(restaurantId) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(username) REFERENCES User(username) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE FoodType (
	foodTypeId INTEGER PRIMARY KEY AUTOINCREMENT,
	foodType NVARCHAR2(100)
);

CREATE TABLE RestaurantFoodType (
	restaurantId INTEGER,
	foodTypeId INTEGER,
	PRIMARY KEY(restaurantId, foodTypeId),
	FOREIGN KEY(restaurantId) REFERENCES Restaurant(restaurantId) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(foodTypeId) REFERENCES FoodType(foodTypeId) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Photo (
	photoId INTEGER PRIMARY KEY AUTOINCREMENT,
	filename NVARCHAR2(200) NOT NULL
);

CREATE TABLE RestaurantPhoto (
	photoId INTEGER,
	restaurantId INTEGER,
	PRIMARY KEY(restaurantId, photoId),
	FOREIGN KEY(restaurantId) REFERENCES Restaurant(restaurantId) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(photoId) REFERENCES Photo(photoId) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE ReviewPhoto (
	photoId INTEGER,
	restaurantId INTEGER,
	username NVARCHAR2(100),
	FOREIGN KEY(restaurantId) REFERENCES Restaurant(restaurantId) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(photoId) REFERENCES Photo(photoId) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(username) REFERENCES User(username) ON DELETE CASCADE ON UPDATE CASCADE
	
);

CREATE TABLE ReviewReply (
	restaurantId INTEGER,
	username NVARCHAR2(100),
	text NVARCHAR2(100),
	FOREIGN KEY(restaurantId) REFERENCES Restaurant(restaurantId) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(username) REFERENCES User(username) ON DELETE CASCADE ON UPDATE CASCADE
);
INSERT INTO Photo VALUES (1,'./css/Images/default.png');
INSERT INTO Photo VALUES (2,'./css/Images/teste1.gif');
INSERT INTO Photo VALUES (3,'./css/Images/testeMenu.jpg');

INSERT INTO User VALUES (NULL, 'ines','ola@a.com','01-01-2016','1234-123','ines','ines',1);
INSERT INTO User VALUES (NULL, 'andreia','ola@a.com','01-01-2016','1234-123','andreia','andreia',1);

INSERT INTO Restaurant VALUES (1,'montaditos','restaurante espanhol','Porto','123456789','5','24h',null,3,2,7,7,'ola');

INSERT INTO Review VALUES (1,'ines',1,4,'rapido e bom','2016-05-01');
INSERT INTO Review VALUES (2,'andreia',1,4,'foi fixe','2014-01-26');

INSERT INTO ReviewPhoto VALUES (1,1,'ines');
INSERT INTO ReviewPhoto VALUES (2,1,'andreia');
INSERT INTO ReviewPhoto VALUES (1,1,'andreia');
