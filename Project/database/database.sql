PRAGMA FOREIGN_KEYS = ON;

CREATE TABLE User (
	userId INTEGER PRIMARY KEY AUTOINCREMENT,
	name NVARCHAR2(100) NOT NULL,
	email NVARCHAR2(100) NOT NULL,
	birthdate DATE NOT NULL,
	postCode NVARCHAR2(8),
	location NVARCHAR2(100),
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

INSERT INTO User VALUES (NULL, 'Andre', 'andre@gmail.com', '09-05-1970', '2140-065', 'Chamusca, Portugal', 'Andre', '$2y$12$sVZx8XCWyRbo0AVPUJGoA.0iRAiTfggPkWofIuFonqRz6iLuxvy6O', 1); /* pass = abcdefgh96 */
INSERT INTO User VALUES (NULL, 'Andreia Rodrigues', 'andreiacarodrigues@gmail.com', '13-03-1996', '2140-185', 'Chamusca, Portugal', 'Andreia', '$2y$12$KOke14wxqnpGCZ2Zb1jqAe/NwsTv/09pL3JyOcQjcRgU0iGzYAtUy', 1); /* pass = andreia0396 */
INSERT INTO User VALUES (NULL, 'Ines Gomes', 'ines@gmail.com', '08-08-1996', '5101-909', 'Lamego, Portugal', 'Ines','$2y$12$3que10ZnlZeQG97yWQRfB.tQAzGITNYc/8kUnvlrkpsEpDR0rp0Ku', 1); /* pass = ines123 */
INSERT INTO User VALUES (NULL, 'Eduardo Leite', 'edu@gmail.com', '20-01-1993', '4350-334', 'Porto, Portugal', 'Edu', '$2y$12$tBJEp7bEuP1UQusQuYpJB.l4PCF0mnh.XX35flB.nbr7.N.F2ZnJG', 1); /* pass = 123456 */

INSERT INTO Restaurant VALUES (1,'Montaditos - Porto','As famosas tapas espanholas a um preco acessivel.','Porto','5101-123','921425785','7.5','Todos os dias da semana, das  12:00 as 24:00','Tem take away, bar completo, wi-fi, opcoes vegetarianas, self service e vinho a copo.',2,1,4,4,'Andreia');
INSERT INTO Restaurant VALUES (2,'Mcdonalds - Lisboa','Com classicos desde o Happy Meal ao Big Mac, o McDonalds e um marco da Fast-Food frequentado por todas as idades.','Lisboa','1300-472 ','214418895','5','Todos os dias da semana, 24h por dia','Pequeno-almoco, tem take away, tem wifi e esplanada',2,1,3,3,'Andre');
INSERT INTO Restaurant VALUES (3,'Pizza Hut - Lisboa','As melhores pizzas de sempre!','Lisboa','1300-036','707221122','25','De segunda a domingo, das 12h as 24h. Encerra aos feriados.','Tem take away, bar completo, zona de fumadores, tem wifi',2,1,3,3,'Andreia');

INSERT INTO Review VALUES (1,'Ines',1,4,'rapido e bom','2016-05-01');
INSERT INTO Review VALUES (2,'Ines',2,3,'cheira muito a fritos','2016-05-01');
INSERT INTO Review VALUES (3,'Andreia',2,4,'foi fixe','2014-01-26');
INSERT INTO Review VALUES (4,'Andreia',1,4,'muito fixe','2016-05-01');

INSERT INTO ReviewPhoto VALUES (1,1);
INSERT INTO ReviewPhoto VALUES (2,1);
INSERT INTO ReviewPhoto VALUES (1,2);

INSERT INTO RestaurantPhoto VALUES (1,1);
INSERT INTO RestaurantPhoto VALUES (2,1);

INSERT INTO Friend VALUES ('Ines','Andreia');
INSERT INTO Friend VALUES ('Andreia','Ines');
INSERT INTO Friend VALUES ('Andreia','Edu');