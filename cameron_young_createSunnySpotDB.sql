create database cyoung_sunnySpot;

CREATE TABLE cabins
(
    cabinID bigint primary key auto_increment not null,
    cabinType varchar(150) not null,
    cabDesc varchar(255) null,
    priceNight bigint(10) not null,
    priceWeek decimal(10,2) not null,
    photo varchar(50) null
);

CREATE TABLE inclusions
(
    incID  bigint auto_increment primary key not null,
    incName varchar(50) not null,
    incDetails varchar(255) null
);

CREATE TABLE cabinInclusions
(
    cabinIncID bigint auto_increment primary key not null, 
    cabinID bigint not null,
    incID bigint not null,
    foreign key (cabinID) references cabins(cabinID),
    foreign key (incID) references inclusions(incID)
);



CREATE TABLE admins
(
    staffID bigint auto_increment primary key not null,
    userName varchar(100) not null,
    password varchar(100) not null,
    firstName varchar(50) not null,
    lastName varchar(200) not null,
    address varchar(200) not null,
    mobile varchar(8) check (mobile between 10000000 AND 99999999)
);

CREATE TABLE logs
(
    logID bigint primary key auto_increment not null,
    staffID bigint not null,
    loginDateTime datetime not null,
    logoutDateTime datetime not null,
    foreign key (staffID) references admins(staffID)
);

/*populating the cabin table*/

insert into cabins(cabinID, cabinType, cabDesc, priceNight, priceWeek, photo) values 
(1, 'Standard cabin sleeps 4', 'a 2 bedroom cabin with double in main and either double or 2 singles in the second bedroom', 100, 500, 'images/stCabin.jpg'),
(2, 'Standard open plan cabin sleeps 4', 'An open plan cabin with double bed and set of bunks ', 120, 600, 'images/stOpenCabin.jpg'),
(3, 'Deluxe cabin sleeps 4', 'A 2 bedroom cabin with queen bed asnd 2 singles in the second bedroom', 140, 700, 'images/deluxCabin.jpg'),
(4, 'Villa sleeps 4', 'A 2 bedroom cabin with queen bed plus another bedroom with 2 single beds', 150, 750, 'images/villa.jpg'),
(5, 'Spa villa sleeps 4', 'A 2 bedroom cabin with queen bed plus another bedroom with 2 single beds and spa baths', 200, 1000, 'images/spaVilla.jpg'),
(6, 'Grass powered site', 'Powered sites on grass', 40, 200, 'images/grassPower.jpg'),
(7, 'Slab Powered', 'Powered sites with slab', 50, 250, 'images/slabPower.jpg');

insert into admins(staffID, userName, password, firstName, lastName, address, mobile) values
(1, 'administrator', 'password', 'cameron', 'young','4 test street', 11234567),
(2, 'testUser', 'testPassword', 'test', 'testSurname', 'testAddress', 10000001),
(3, 'admin', 'secure', 'test', 'test', 'test', '11111111');

insert into inclusions(incID, incName, incDetails) values
(1, '1 bathroom', ' '),
(2, '1 + bathroom', '1 bathroom and separate toilet'),
(3, '2 bathroom', ' '),
(4, '2 bathroom', ' '),
(5, 'Air Conditioner', 'Reverse Cycle'),
(6, 'Ceiling fans', ' '),
(7, 'Bunk Bed', ' '),
(8, '2 Single Beds', ' '),
(9, 'Double bed', ' '),
(10, 'Dishwasher', ' '),
(11, 'DVD Player', ' '),
(12, 'Hair Dryer', ' ');

insert into cabinInclusions(cabinID, incID) values /*cabin id -> inclusionID -> insert into values does not overwrite*/
(1, 1),(1,7),(1,9),
(2,2),(2,6),(2,7),(2,9),(2,12),
(3, 3),(3, 4),(3, 8),(3, 9),(3, 11),(3, 12),
(4, 3),(4, 4),(4, 8),(4, 9),(4, 10),(4, 11),(4, 12),
(5, 3),(5,4),(5,8),(5,9),(5,10),(5,11),(5, 12);

