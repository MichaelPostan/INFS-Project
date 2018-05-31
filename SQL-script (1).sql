-- The following code is for the UQ solar Database made by Tom Clarkson and Michael Postan --
-- 22/05/18 -- 

drop table if exists maintenancelog cascade;
drop table if exists solaranalysed cascade;
drop table if exists batteryanalysed cascade;
drop table if exists solarreading cascade;
drop table if exists panel cascade;
drop table if exists batteryreading cascade;
drop table if exists battery cascade;
drop table if exists maintenance cascade;
drop table if exists researcher cascade;
drop table if exists staff cascade;
drop table if exists facility cascade;


-- below is the DDL required to create the tables

create table facility(
	fid int(8) primary key,
	fname varchar(30),
    address varchar(50),
    city varchar(30),
    state varchar(3),
    director varchar(30)
	);


create table staff(
	ID int(8) primary key,
	sname varchar(30),
	salary int,
    DOB varchar(10),
	gender enum('M','F'),
	title varchar(30),
    fid int(8),
    foreign key(fid) references facility(fid) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
	);
    
ALTER TABLE staff
ADD CONSTRAINT staff_salary_check
CHECK (salary >0);

create table researcher(
	ID int(8) primary key,
    foreign key(ID) references staff(ID) 
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    supervisor int(8),
    foreign key(supervisor) references researcher(ID) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE
	);

create table maintenance(
	ID int(8) primary key,
    foreign key(ID) references staff(ID) 
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    supervisor int(8),
    foreign key(supervisor) references maintenance(ID) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE
	);

create table panel(
	pid int(8) primary key,
	maxoutputw int,
    fid int(8),
    foreign key(fid) references facility(fid) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
	);
 
create table solarreading(
	stime varchar(10),
    sdate varchar(10),
    primary key(stime,sdate),
	powerw int,
    pid int(8),
	foreign key(pid) references panel(pid) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
	);
 
create table battery(
	bid int(8) primary key,
	capcitykwh int,
    fid int(8),
    foreign key(fid) references facility(fid) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
	);
 
create table batteryreading(
	btime varchar(10),
    bdate varchar(10),
    primary key(btime,bdate),
	charge int(3),
    currenta int(8),
    bid int(8),
	foreign key(bid) references battery(bid) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
	);
 
create table maintenancelog(
	mdate varchar(10) primary key,
    maintenanceid int(8),
	foreign key(maintenanceid) references maintenance(ID) 
    ON DELETE SET NULL
    ON UPDATE CASCADE,
    pid int(8),
	foreign key(pid) references panel(pid) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
	);

create table solaranalysed(
	ID int(8),
    stime varchar(10),
    sdate varchar(10),
    primary key(ID,stime,sdate),
    foreign key (ID) references researcher(ID) 
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    foreign key(stime,sdate) references solarreading(stime,sdate) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
	);

create table batteryanalysed(
	ID int(8),
    btime varchar(10),
    bdate varchar(10),
    primary key(ID,btime,bdate),
    foreign key (ID) references researcher(ID) 
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    foreign key(btime,bdate) references batteryreading(btime,bdate)
    ON DELETE CASCADE 
    ON UPDATE CASCADE
	);


-- below is the code required to fill all the tuples

insert into facility values(12345678,'UQ St Lucia','St Lucia','Brisbane', 'QLD', 'Peter Hoj');
insert into facility values(76854321,'UQ Gatton','Rainbird St','Gatton', 'QLD', 'Jack Daniels');
insert into facility values(99463785,'UQ Luggage Point','Luggage Point','Brisbane', 'QLD', 'Callan Morgan');
insert into facility values(47593758,'UQ City','CBD','Brisbane', 'QLD', 'Michelle Urser');
insert into facility values(19475736,'UQ The Gap','The Gap','Brisbane', 'QLD', 'Jacqui Meadows');

insert into staff values(42890050, 'Tom Clarkson', 1000000, '02/10/1994', 'M', 'Data Scientist, Inspiration', 12345678);
insert into staff values(43574919, 'Michael Postan', 999999, '19/01/1996', 'M', 'Data Scientist', 12345678);
insert into staff values(43290867, 'Betty White', 80000, '02/11/1981', 'F', 'Chemical Engineer', 76854321);
insert into staff values(46785666, 'Janice Slughorn', 120000, '29/02/1964', 'F', 'Mechanical Engineer', 99463785);
insert into staff values(49877654, 'Harry Potter', 60000, '11/03/1990', 'M', 'Statistician', 19475736);
insert into staff values(49878611, 'Freya Mcintyre', 97500, '01/03/1988', 'M', 'Statistician', 47593758);


insert into researcher values(42890050,null);
insert into researcher values(43574919,42890050);
insert into researcher values(43290867,42890050);
insert into researcher values(46785666,42890050);
insert into researcher values(49877654,42890050);

insert into maintenance values(43574919,null);
insert into maintenance values(42890050,43574919);
insert into maintenance values(43290867,43574919);
insert into maintenance values(46785666,43574919);
insert into maintenance values(49877654,43574919);

insert into panel values(52719465,1200,12345678);
insert into panel values(34562837,1200,76854321);
insert into panel values(38595736,1400,12345678);
insert into panel values(91840382,1400,12345678);
insert into panel values(11047849,1400,12345678);

insert into solarreading values('12:12:12pm','20/04/2018',1023,52719465);
insert into solarreading values('12:13:12pm','20/04/2018',976,34562837);
insert into solarreading values('12:14:12pm','20/04/2018',1138,52719465);
insert into solarreading values('12:15:12pm','20/04/2018',1146,34562837);
insert into solarreading values('12:16:12pm','20/04/2018',1203,52719465);
insert into solarreading values('12:12:12pm','21/04/2018',1023,52719465);
insert into solarreading values('12:13:12pm','21/04/2018',186,34562837);
insert into solarreading values('12:14:12pm','21/04/2018',908,52719465);
insert into solarreading values('12:15:12pm','21/04/2018',1185,34562837);
insert into solarreading values('12:16:12pm','21/04/2018',1003,52719465);
insert into solarreading values('12:12:12pm','22/04/2018',1023,52719465);
insert into solarreading values('12:13:12pm','22/04/2018',1816,34562837);
insert into solarreading values('12:14:12pm','22/04/2018',908,52719465);
insert into solarreading values('12:15:12pm','22/04/2018',1385,34562837);
insert into solarreading values('12:16:12pm','22/04/2018',1003,52719465);

insert into battery values(19475633,535,12345678);
insert into battery values(19475634,800,12345678);
insert into battery values(48594637,650,76854321);
insert into battery values(12475957,535,12345678);
insert into battery values(44444444,650,76854321);
insert into battery values(34758474,450,12345678);

insert into batteryreading values('4:13:56pm','19/03/2018',76,1000,19475633);
insert into batteryreading values('4:14:56pm','19/03/2018',77,1000,19475633);
insert into batteryreading values('4:15:56pm','19/03/2018',77,1000,19475633);
insert into batteryreading values('4:16:56pm','19/03/2018',78,1000,19475633);
insert into batteryreading values('4:17:56pm','19/03/2018',79,1000,19475633);

insert into maintenancelog values('03/09/2017',43290867,52719465);
insert into maintenancelog values('18/05/2016',43290867,34562837);
insert into maintenancelog values('13/09/2018',43290867,38595736);
insert into maintenancelog values('03/12/2017',43290867,91840382);
insert into maintenancelog values('11/09/2017',43290867,11047849);

insert into solaranalysed values(42890050,'12:12:12pm','20/04/2018'); 
insert into solaranalysed values(42890050,'12:13:12pm','20/04/2018');
insert into solaranalysed values(42890050,'12:14:12pm','20/04/2018');
insert into solaranalysed values(42890050,'12:15:12pm','20/04/2018');
insert into solaranalysed values(42890050,'12:16:12pm','20/04/2018');

insert into batteryanalysed values(42890050,'4:13:56pm','19/03/2018');
insert into batteryanalysed values(42890050,'4:14:56pm','19/03/2018');
insert into batteryanalysed values(42890050,'4:15:56pm','19/03/2018');
insert into batteryanalysed values(42890050,'4:16:56pm','19/03/2018');
insert into batteryanalysed values(42890050,'4:17:56pm','19/03/2018');


-- the code below is the query, it works in MySQL Workbench with the database --
-- It returns the name and salary of all worker whose salray is 5 times greater than the lowest salaried staff-- 
#SELECT DISTINCT S1.sname,
#	S1.salary
#FROM staff S1, staff S2
#WHERE S1.salary> 5*S2.salary	


#SELECT AVG(powerw) 
#FROM solarreading, panel, facility
#WHERE sdate = '22/04/2018' AND solarreading.pid = panel.pid AND panel.fid = facility.fid AND facility.fname = 'UQ St Lucia'

#creates the average 
#SELECT sdate, AVG(powerw)
#FROM solarreading 
#GROUP BY sdate

#creates the average 
#SELECT DISTINCT S1.sdate, S1.powerw
#FROM solarreading S1, solarreading S2 
#WHERE S1.powerw>S2.powerw

#SELECT DISTINCT S1.sdate, AVG(S1.powerw)
#FROM solarreading S1, solarreading S2 
#WHERE S1.powerw>S2.powerw
#GROUP BY S1.sdate, S2.sdate
#HAVING AVG(S1.powerw)>AVG(S2.powerw)


#SELECT sdate, MIN(powerw)
#FROM solarreading
#GROUP BY sdate 
#HAVING AVG(powerw)> ANY (SELECT MAX(powerw) FROM solarreading GROUP BY sdate)

#SELECT S1.sname, S1.ID
#FROM staff S1

#SELECT S1.sname, S1.ID
#FROM staff S1
#WHERE NOT EXISTS (SELECT M1.supervisor FROM maintenance M1 WHERE NOT EXISTS (SELECT M2.supervisor FROM maintenance M2 WHERE M2.supervisor = S1.ID))

#SELECT P.pid, P.maxoutputw, R.powerw, R.sdate, R.stime
#FROM panel P, solarreading R
#Where P.pid = R.pid

