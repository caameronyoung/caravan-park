/*question 1*/
select * from cabins;

/*question 2*/
select cabinType, priceNight from cabins where priceWeek = 1000;

/*question 3*/
select cabinType, photo from cabins where priceNight = 40;

/*question 4 real*/
SELECT COUNT(cabinID) FROM cabinInclusions WHERE incID = 12;

/*question 5*/
select cabins.cabinType, cabins.photo FROM cabins LEFT JOIN cabinInclusions ON cabins.cabinID = cabinInclusions.cabinID WHERE cabinInclusions.incID = 7;

/*question 6*/
select cabins.priceNight, cabins.cabinType, inclusions.incName from cabins left join cabinInclusions on cabins.cabinID = cabinInclusions.cabinID left join inclusions on cabinInclusions.incID = inclusions.incID  where cabinInclusions.cabinID = 5;

/*question 7*/
insert into cabins (cabinID, cabinType, cabDesc, priceNight, priceWeek, photo) values
(8, 'sample', 'sample type', 50, 500, 'cabAdded.jpg');

/*question 8*/
update cabins set cabDesc='updated description', photo='updatedPhoto.jpg' WHERE cabinID = 8;

/*question 9*/
delete from cabins where cabinID = 8;

