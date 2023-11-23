#DROP SCHEMA STUDENTRENT;

CREATE DATABASE STUDENTRENT;

USE STUDENTRENT;

CREATE TABLE POST_SECONDARY(
	u_id INT,
    u_name VARCHAR (30) NOT NULL,
    address VARCHAR(50) NOT NULL,
	PRIMARY KEY (u_id)
);

CREATE TABLE STUDENT(
	s_id INT AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL,
    password VARCHAR(30) NOT NULL,
    fname VARCHAR(15) NOT NULL,
    lname VARCHAR(15) NOT NULL,
    date_of_birth VARCHAR(40) NOT NULL,
    phone_num VARCHAR(15) NOT NULL,
    address VARCHAR(50) NOT NULL,
    email VARCHAR(30) NOT NULL,
    program VARCHAR(40) NOT NULL,
    uni INT,
    PRIMARY KEY (s_id),
    FOREIGN KEY (uni) REFERENCES POST_SECONDARY(u_id)
);

CREATE TABLE LANDLORD(
	l_id INT AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL,
    password VARCHAR(30) NOT NULL,
    fname VARCHAR(15) NOT NULL,
    lname VARCHAR(15) NOT NULL,
	phone_num VARCHAR(15) NOT NULL,
    email VARCHAR(30) NOT NULL,
	PRIMARY KEY (l_id)
);

CREATE TABLE BUILDING(
	b_id INT AUTO_INCREMENT,
    uni INT,
    address VARCHAR(50) NOT NULL,
    date VARCHAR(50) NOT NULL,
    rent INT NOT NULL,
    floors VARCHAR(50) NOT NULL,
    description VARCHAR(300) NOT NULL,
    building_type VARCHAR(20) NOT NULL,
    basement VARCHAR(10) NOT NULL,
    kitchen VARCHAR(10) NOT NULL,
    num_of_bedrooms INT NOT NULL,
	num_of_washrooms INT NOT NULL,
    hydro VARCHAR(10) NOT NULL,
    electricity VARCHAR(10) NOT NULL,
    wifi VARCHAR(10) NOT NULL,
	public_transportation VARCHAR(200),
    thermostat VARCHAR(10) NOT NULL,
    parking VARCHAR(50) NOT NULL,
    l_id int, 
    PRIMARY KEY (b_id),
    FOREIGN KEY (uni) REFERENCES POST_SECONDARY(u_id),
    FOREIGN KEY (l_id) REFERENCES LANDLORD(l_id)
);



CREATE TABLE REVIEW(
	r_id INT AUTO_INCREMENT,
	rating_score INT NOT NULL,
	descriptions VARCHAR(100),
	s_id INT,
	b_id INT,
	PRIMARY KEY (r_id),
	FOREIGN KEY (s_id) REFERENCES STUDENT(s_id),
	FOREIGN KEY (b_id) REFERENCES BUILDING(b_id)
);

CREATE TABLE IMGS(
	img_bin VARCHAR(50),
	b_id INT,
	PRIMARY KEY (img_bin, b_id),
	FOREIGN KEY (b_id) REFERENCES BUILDING( b_id)
);

CREATE TABLE LIVED_IN(
	s_id INT,
    b_id INT,
    date_start VARCHAR(20),
    date_finish VARCHAR(20),
    PRIMARY KEY (s_id, b_id),
    FOREIGN KEY (s_id) REFERENCES STUDENT(s_id),
	FOREIGN KEY (b_id) REFERENCES BUILDING(b_id)
);

CREATE TABLE VIEWED(
	s_id INT,
    b_id INT,
	PRIMARY KEY (s_id, b_id),
    FOREIGN KEY (s_id) REFERENCES STUDENT(s_id),
	FOREIGN KEY (b_id) REFERENCES BUILDING(b_id)
);


INSERT INTO POST_SECONDARY
VALUES (1,"Ontario Tech University","2000 Simcoe St N, Oshawa, ON L1G 0C5"), 
(2, "McMaster University", "1280 Main St W, Hamilton, ON L8S 4L8"),
(3, "Queen's University", "99 University Ave, Kingston, ON K7L 3N6"),
(4,"Western University", "1151 Richmond St, London, ON N6A 3K7"),
(5, "University of Waterloo", "200 University Ave W, Waterloo, ON N2L 3G1"),
(6, "University of Toronto", "27 King's College Cir, Toronto, ON M5S 1A1")
;

SELECT *
FROM STUDENT;

INSERT INTO STUDENT( username, password, fname, lname, date_of_birth, phone_num, address, email, program, uni)
VALUES ( "squirelLover", "password1", "Megan", "Stallion", "March 21, 2004", "1-647-546-1435", "22 Hemingway Crescent, Unionville, ON L3R 2A4", "meganthestallion@gmail.com", "music", 3),
( "lorax", "password2", "Gru", "Minion", "June 1, 1999", "1-905-541-6786", "20 Yonge St, Tara, ON N0H 2N0", "gru@gmail.com", "political science", 5),
( "nba", "password3", "Lebron", "James", "October 19, 2001", "1-416-500-6996", "35 Davison Dr, Guelph, ON N1E 0C1", "lebron@gmail.com", "computer science", 5),
( "jc", "password4", "Junior", "Chicken", "April 1, 2003", "1-905-355-5555", "445 Watson Pkwy N, Guelph, ON N1E 7C6", "jc@gmail.com", "culinary arts", 5),
( "wizard", "password5", "Harry", "Potter", "April 4, 2005", "1-416-777-7777", "1374 Avonbridge Dr, Mississauga, ON L5G 3G5", "wiz@gmail.com", "electrical engineering", 1),
( "frozen", "password6", "Elsa", "Anna", "February 2, 2005", "1-905-132-6087", "42 Carlin Ave, Timmins, ON P4N 4K7", "olaf@gmail.com", "nursing", 1),
( "cooker", "password7", "James", "Cook", "October 31, 2002", "1-647-543-1490", "265 Hidden Trail, North York, ON M2R 3S7", "cookJ@gmail.com", "software engineering", 1),
( "rizzlybear", "password8", "Bill", "Gates", "July 17, 2006", "1-416-308-4577", "11 Country Heights Dr, Richmond Hill, ON L4E 3M8", "rizzer@gmail.com", "automotive engineering", 2),
( "tetris", "password9", "Loki", "Smith", "October 5, 2000", "1-905-765-1056", "2 Maureen Ct, Richmond Hill, ON L4B 3H9", "mischevious@gmail.com", "philosophy", 2),
( "jack", "password10", "Jack", "Black", "May 4, 2000", "1-416-423-6857", "24 Haley Ct, Brampton, ON L6S 1N6", "gru@gmail.com", "phycology", 2),
( "nintendo", "password11", "Mario", "Switch", "December 7, 2000", "1-647-895-1000", "33 Franklin St, Uxbridge, ON L9P 1K3", "gru@gmail.com", "software engineering", 4),
( "gamer1", "password12", "Sandy", "Water", "November 25, 1999", "1-647-487-5086", "3535 Church St, Blackstock, ON L0B 1B0", "gru@gmail.com", "mechanical engineering", 4),
( "spidy", "password13", "Miles", "Morales", "March 13, 2003", "1-416-233-6555", "35 Queensplate Dr, Port Perry, ON L9L 0A2", "gru@gmail.com", "political science", 4),
( "popo", "password14", "Jacky", "Officer", "August 11, 2002", "1-647-581-0543", "31 Northwood Dr, North York, ON M2M 2J7", "gru@gmail.com", "linguistics", 3)
;


INSERT INTO LANDLORD( username, password, fname, lname, phone_num, email)
VALUES ("javert","pass1","Javier","Chung","1-647-581-0543","jav@gmail.com"),
("kite","pass2","Bob","Builder","1-905-633-8881","builder@gmail.com"),
("owner","pass3","Yilon","Ma","1-647-543-4563","merny@gmail.com"),
("basketball","pass4","Jamal","Murry","1-647-103-3008","nuggets@gmail.com"),
("fishy","pass5","Nemo","Clown","1-416-789-5635","finding@gmail.com"),
("flying637","pass6","Derrek","Pilot","1-416-123-7821","pilot@gmail.com"),
("Swimmer","pass7","Micheal","Phelps","1-416-616-5544","olympic@gmail.com"),
("wrestler1","pass8","Dwayne","Johnson","1-905-333-3209","therock@gmail.com")
;

INSERT INTO BUILDING (uni, address, date, rent, floors, description, building_type, basement, kitchen, num_of_bedrooms, num_of_washrooms, hydro, electricity, wifi, public_transportation, thermostat, parking, l_id)
VALUES ( 5,"30 Laurel Street, Waterloo, Ontario", "Sept 2024 - Sept 2025" , 3500 , "2 floors", "shared washroom and kitchen", "house", "yes", "yes", 6, 6, "yes", "yes", "yes", "bus stop - 10 min walk", "yes", "4 car driveway", 6),
( 3, "52 Bayswater Pl, Kingston, Ontario", "Sept 2024 - Sept 2025", 3800, "4 floors", "shared kitchen among 4 people, 2 shared washrooms", "apartment", "no", "yes", 4, 2, "yes", "yes", "yes", "bus stop - 7 min walk", "yes", "parking lot", 4), 
( 2, "105 Meadowlands Blvd Hamilton, Ontario", "Sept 2024 - Sept 2025", 2950, "2 floors", "shared living room and kitchen", "house", "yes", "yes", 4, 3, "yes", "yes", "yes", "bus stop - 12 min walk", "yes", "2 car driveway", 3), 
( 1, "1700 Simcoe St N, Oshawa, Ontario", "Sept 2024 - Sept 2025", 3600, "6 floors", "shared kitchen and washrooms", "apartment", "no", "yes", 5, 2, "yes", "yes", "yes", "bus stop - 1 min walk", "yes", "parking lot", 2),
( 4, "15 Tallwood Cir, London, Ontario", "Sept 2024 - Sept 2025", 3300, "2 floors", "shared living room, 2 kitchens", "house", "yes", "yes", 5, 5, "yes", "yes", "yes", "bus stop - 10 min walk", "yes", "4 car driveway", 5), 
( 3, "397 Brock St, Kingston, Ontario", "Sept 2024 - Sept 2025", 2800, "2 floors", "shared washrooms and kitchen", "house", "yes", "yes", 3, 3, "yes", "yes", "yes", "bus stop - 6 min walk", "no", "2 car driveway", 4), 
( 4, "115 Orkney Crescent, London, Ontario", "Sept 2024 - Sept 2025", 3700, "2 floors", "kitchen and additional rented rooms in basement", "house", "yes", "yes", 6, 4, "yes", "yes", "yes", "bus stop - 4 min walk", "yes", "4 car driveway", 5), 
( 2, "6 Melbourne St, Hamilton, Ontario", "Sept 2024 - Sept 2025", 4400, "3 floors", "2 shared kitchens along with shared living room", "townhouse", "no", "yes", 7, 4, "yes", "yes", "yes", "bus stop - 15 min walk", "yes", "4 car driveway", 8), 
( 6, "219 College St. Toronto, Ontario", "Sept 2024 - Sept 2025", 4400, "2 floors", "shared washrooms and kitchen", "townhouse", "no", "yes", 5, 3, "yes", "yes", "yes", "bus stop - 14 min walk", "yes", "2 car driveway", 7), 
( 1, "1889 Dalhousie Crescent, Oshawa, Ontario", "Sept 2024 - Sept 2025", 4500, "3 floors", "2 shared kitchens", "house", "yes", "yes", 7, 7, "yes", "yes", "yes", "bus stop - 6 min walk", "yes", "4 car driveway", 2),
( 1, "10 Avenue of Champions, Oshawa, Ontario", "Sept 2024 - Sept 2025", 2775, "3 floors", "West Villiage", "Town house", "no", "yes", 3, 1, "yes", "yes", "yes", "bus stop - 2 min walk", "yes", "Paid parking", 2);

INSERT INTO IMGS(img_bin, b_id)
VALUES ("laurel1.jpg",1), ("laurel2.jpeg",1), 
("bayswater1.jpg", 2), ("bayswater2.jpg", 2), 
("meadowlands1.jpg", 3), ("meadowlands2.jpeg", 3),
("simcoe1.png", 4), ("simcoe2.jpeg", 4), 
("tallwood1.jpeg", 5), ("tallwood2.jpeg", 5),
("brock1.jpg", 6), ("brock2.jpeg", 6), 
("orkney1.jpeg", 7), ("orkney2.jpg", 7),
("melbourne1.jpg", 8), ("melbourne2.webp", 8),
("college1.jpeg", 9), ("college2.jpeg", 9), 
("dalhousie1.jpeg", 10), ("dalhousie2.jpg", 10),
("champions1.jpeg", 11), ("champions2.jpeg", 11);

INSERT INTO LIVED_IN(s_id, b_id, date_start, date_finish)
VALUES (3,1,"Jan 2023","Apr 2023 "),(14,2,"Sept 2020"," Sept 2021"),(10,3,"Sept 2019"," Apr 2020"),
(10,5,"Sept 2021","Apr 2022"),(5,2,"Sept 2023","Jan 2024"),(6,10,"Sept 2023","Apr 2024"),
(7,4,"Sept 2022","Apr 2023"),(8,6,"Sept 2023","Apr 2024"),(9,4,"Sept 2019","Apr 2020"),
(10,9,"Sept 2022","Apr 2023"),(11,8,"Sept 2019","Apr 2020"),(12,9,"Sept 2018","Apr 2019");


INSERT INTO REVIEW( r_id, rating_score, descriptions, s_id, b_id)
VALUES (1, 9, "very nice house", 3, 1),
(2, 5, "bad house very loud at night", 14, 2),
(3, 7,"not a bad home", 10, 3),
(4, 8, "great amenities in this house", 5, 4),
(5, 2, "old and broken", 13, 5),
(6, 10, "really close to campus and has a great view", 1, 6),
(7, 4, "I've seen worse", 13, 7),
(8, 6, "I had shelter for the past year", 10, 8),
(9, 4, "meh", 7, 10),
(10, 9, "the bus stop is just right outside!", 6, 10),
(11, 8, "This house was very nice", 8, 3),
(12, 9, "the utilities provide are amazing", 1, 2)
;

INSERT INTO VIEWED(s_id, b_id)
VALUES (1,1),(4,2),(4,6),(7,3),(7,8),(8,4),(8,10),(11,5),(11,7),(12,9);


#View 1 - description of a building and the landlord it is registered to as well as the uni
##
CREATE VIEW BUILDING_DESCRIPTION
AS SELECT B.b_id, B.uni, B.address, B.date, B.rent, B.floors, B.description, B.building_type,
            B.basement, B.kitchen, B.num_of_bedrooms, B.num_of_washrooms, B.hydro, B.electricity, B.wifi,
            B.public_transportation, B.thermostat, B.parking, L.l_id, L.fname, L.lname, P.u_name
   FROM (POST_SECONDARY P JOIN BUILDING B ON P.u_id = B.uni) JOIN LANDLORD L ON B.l_id = L.l_id;

SELECT *
FROM BUILDING_DESCRIPTION;

#View 2 - Shows the the amount of buildings with rent below the average rent
#
CREATE VIEW BELOW_AVG_RENT_NUM
AS SELECT P.u_id, count(*) AS rent_under_AVG
   FROM BUILDING B, POST_SECONDARY P
   WHERE P.u_id = B.uni AND B.rent <ALL (SELECT AVG(B.rent)
									     FROM BUILDING B
									     WHERE P.u_id = B.uni)
   GROUP BY P.u_id
;


SELECT *
FROM BELOW_AVG_RENT_NUM;

#View 3 - shows the images that are linked to a building
#
CREATE VIEW BUILDING_IMGS
AS SELECT DISTINCT I.img_bin, I.b_id
   FROM IMGS I
   WHERE I.b_id IN (SELECT B.b_id
				    FROM BUILDING B
                    WHERE B.b_id = I.b_id)
   ORDER BY I.b_id ASC
;

SELECT *
FROM BUILDING_IMGS;

#View 4 - shows all the reviews for every building
#
CREATE VIEW BUILDING_REVIEWS
AS (SELECT B.b_id, R.rating_score, R.descriptions
   FROM BUILDING B LEFT JOIN REVIEW R ON B.b_id = R.b_id)
   UNION 
   (SELECT B.b_id, R.rating_score, R.descriptions
   FROM BUILDING B RIGHT JOIN REVIEW R ON B.b_id = R.b_id)
; 

SELECT *
FROM BUILDING_REVIEWS;


#View 5 - Prints out the building without any reviews
#
CREATE VIEW NO_REVIEW
AS SELECT B.b_id, B.address
   FROM BUILDING B
   WHERE B.b_id NOT IN (SELECT DISTINCT R.b_id FROM REVIEW R)
   UNION 
   SELECT NULL AS b_id, NULL AS address
   WHERE NOT EXISTS (SELECT NULL FROM REVIEW);

SELECT *
FROM NO_REVIEW;


#View 6 - avg rating of each building
#
CREATE VIEW AVG_RATING
AS SELECT B.address, L.fname, L.lname, AVG(R.rating_score) AS avg_Rate
   FROM BUILDING B, REVIEW R, LANDLORD L
   WHERE B.b_id = R.b_id AND L.l_id = B.l_id
   GROUP BY B.address, L.fname, L.lname
   ORDER BY L.fname
;

SELECT *
FROM AVG_RATING;

#View 7 - Shows the buildings with rent below the average rent for their university
#
CREATE VIEW BUILDINGS_BELOW_AVG
AS SELECT B.address, B.rent, P.u_name
   FROM BUILDING B, POST_SECONDARY P
   WHERE P.u_id = B.uni AND B.rent <ALL (SELECT AVG(B.rent)
									     FROM BUILDING B
									     WHERE P.u_id = B.uni)
;

SELECT *
FROM BUILDINGS_BELOW_AVG;

#View 8 - counts how many views a building has had
#
CREATE VIEW BUILDING_VIEWS
AS SELECT B.address, COUNT(*) AS number_of_visits
   FROM BUILDING B JOIN VIEWED V ON B.b_id = V.b_id
   GROUP BY B.address
;

SELECT *
FROM BUILDING_VIEWS;

#view 9 - shows all the reviews a student has made on a building
#
CREATE VIEW STUDENT_REVIEW
AS SELECT S.s_id ,S.fname, S.lname, B.address, R.descriptions
   FROM (STUDENT S JOIN REVIEW R ON S.s_id = R.s_id) JOIN BUILDING B ON B.b_id = R.b_id
   ORDER BY S.fname ASC
;

SELECT *
FROM STUDENT_REVIEW;


#View 10 - shows the amount of buildings for rent to the university they are registered to
#
CREATE VIEW BUILDINGS_FOR_RENT
AS SELECT P.u_id, COUNT(*) AS num_of_buildings
   FROM BUILDING B JOIN POST_SECONDARY P ON B.uni = P.u_id
   GROUP BY P.u_id
;

SELECT *
FROM BUILDINGS_FOR_RENT;
