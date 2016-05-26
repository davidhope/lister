drop database if exists `tlg_v2`;
create database `tlg_v2`;
use `tlg_v2`;

CREATE TABLE `property` (
	`propertyId` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`propertyTypeId` smallint(3) unsigned default null,
	`neighborhoodId` int(11) unsigned default null,
	`zoningTypeId` smallint(3) unsigned default null,
	`areaCode` varchar(3) DEFAULT NULL,
	`subdivision` varchar(50) default null,
	`location` varchar(45) DEFAULT NULL,
	`latitude` DECIMAL(10,6) DEFAULT NULL,
	`longitude` DECIMAL(10,6) DEFAULT NULL,
	`elevation` smallint(3) DEFAULT NULL,
	`unit` varchar(10) DEFAULT NULL,
	`address` varchar(50) NOT NULL,
	`city` varchar(50) NOT NULL,
	`stateId` int(11) unsigned not null,
	`zip` varchar(5) NOT NULL,
	`county` varchar(15) DEFAULT NULL,
	`gated` tinyint(1) unsigned default null,
	`floor` smallint(3) unsigned not null,
	`bed` smallint(3) unsigned not null,
	`bath` smallint(3) unsigned not null,
	`stories` smallint(3) unsigned not null,
	`garage` smallint(3) unsigned not null,
	`pool` tinyint(1) unsigned default null,
	`spa` tinyint(1) unsigned default null,
	`yearBuilt` smallint(3) unsigned not null,
	`schoolElementary` varchar(45) DEFAULT NULL,
	`schoolMiddle` varchar(45) DEFAULT NULL,
	`schoolHigh` varchar(45) DEFAULT NULL,
	`sqFtLiving` decimal(13,2) DEFAULT NULL,
	`sqFtLot` decimal(13,2) DEFAULT NULL,
	`acres` decimal(13,2) DEFAULT NULL,
	`lastUpdateDate` datetime NOT NULL,
	`lastUpdateId` varchar(45) NOT NULL,
	PRIMARY KEY (`propertyId`),
	KEY `fk_property_propertyTypeId_idx` (`propertyTypeId`),
	KEY `fk_property_neighborhoodId_idx` (`neighborhoodId`),
	KEY `fk_property_zoningTypeId_idx` (`zoningTypeId`),
	KEY `fk_property_stateId_idx` (`stateId`),
    KEY `property_search_idx` (`address`,`location`,`neighborhoodId`)
);

CREATE TABLE `parcel` (
	`parcelId` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`parcelNumber` varchar(14) NOT NULL,
	`propertyId` int(11) unsigned NOT NULL,
	`lastUpdateDate` datetime NOT NULL,
	`lastUpdateId` varchar(45) NOT NULL,
	PRIMARY KEY (`parcelId`),
	KEY `fk_parcel_propertyId_idx` (`propertyId`)
);


CREATE TABLE IF NOT EXISTS `propertyType` (
	`propertyTypeId` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(45) NOT NULL,
	`lastUpdateDate` datetime NOT NULL,
	`lastUpdateId` varchar(45) NOT NULL,
	PRIMARY KEY (`propertyTypeId`)
);

insert into `propertyType`(`name`,`lastUpdateDate`,`lastUpdateId`)
values('House',now(),'dhope'),('Highrise',now(),'dhope'),('Land',now(),'dhope'),('Rental',now(),'dhope'),('Condo',now(),'dhope');

CREATE TABLE IF NOT EXISTS `neighborhood` (
	`neighborhoodId` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(50) NOT NULL,
	`active` tinyint(1) unsigned default null,
	`description` varchar(5000) NOT NULL,
	`propertyTypeId` smallint(3) unsigned default null,
	`lastUpdateDate` datetime NOT NULL,
	`lastUpdateId` varchar(45) NOT NULL,
	PRIMARY KEY (`neighborhoodId`),
	KEY `fk_neighborhood_propertyTypeId_idx` (`propertyTypeId`)
);

insert into `neighborhood`(`name`,`active`,`description`,`propertyTypeId`,`lastUpdateDate`,`lastUpdateId`)
select n.neighborhood,1,coalesce(n.text,''), pt.propertyTypeId,now(),'dhope'
from `tlg`.`neighborhoods` n
inner join `tlg_v2`.`propertyType` pt
	on n.type = pt.name
where n.force_on_menu = 'y';
    
CREATE TABLE IF NOT EXISTS `zoningType` (
	`zoningTypeId` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(45) NOT NULL,
	`lastUpdateDate` datetime NOT NULL,
	`lastUpdateId` varchar(45) NOT NULL,
	PRIMARY KEY (`zoningTypeId`)
);

insert into `zoningType`(`name`,`lastUpdateDate`,`lastUpdateId`)
values('Commercial',now(),'dhope'),('Multi',now(),'dhope'),('Residential',now(),'dhope'),('Single',now(),'dhope');

CREATE TABLE IF NOT EXISTS `listing` (
	`listingId` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`propertyId` int(11) unsigned NOT NULL,
	`mls` int(10) unsigned NOT NULL,
	`statusTypeId` smallint(3) unsigned NOT NULL,
	`title` varchar(45) NOT NULL,
	`descriptionShort` varchar(150) NOT NULL,
	`descriptionLong` varchar(5000) DEFAULT NULL,
	`publicRemarks` varchar(500) DEFAULT NULL,
	`marketingId` smallint(3) unsigned DEFAULT NULL,
	`youTubeId` varchar(15) DEFAULT NULL,
	`shortSale` tinyint(1) unsigned default null,
	`featured` tinyint(1) unsigned default null,
	`frontPage` tinyint(1) unsigned default null,
    `agendId` int(11) unsigned not null,
	`lastUpdateDate` datetime NOT NULL,
	`lastUpdateId` varchar(45) NOT NULL,
	PRIMARY KEY (`listingId`),
	KEY `fk_listing_propertyId_idx` (`propertyId`),
	KEY `fk_listing_statusTypeId_idx` (`statusTypeId`),
	KEY `listing_search_idx` (`statusTypeId`)
);

CREATE TABLE IF NOT EXISTS `listingPrice` (
	`listingPriceId` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`listingId` int(11) unsigned NOT NULL,
	`price` decimal(13,2) NOT NULL,
	`lastUpdateDate` datetime NOT NULL,
	`lastUpdateId` varchar(45) NOT NULL,
	PRIMARY KEY (`listingPriceId`),
	KEY `fk_openHouse_listingId_idx` (`listingId`)
);

CREATE TABLE IF NOT EXISTS `listingStatus` (
	`listingStatusId` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`listingId` int(11) unsigned NOT NULL,
	`statusTypeId` int(11) unsigned NOT NULL,
	`lastUpdateDate` datetime NOT NULL,
	`lastUpdateId` varchar(45) NOT NULL,
	PRIMARY KEY (`listingStatusId`)
);


CREATE TABLE IF NOT EXISTS `statusType` (
	`statusTypeId` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(45) NOT NULL,
	`lastUpdateDate` datetime NOT NULL,
	`lastUpdateId` varchar(45) NOT NULL,
	PRIMARY KEY (`statusTypeId`)
);

insert into `statusType`(`name`,`lastUpdateDate`,`lastUpdateId`)
values('For Sale',now(),'dhope'),('Inactive',now(),'dhope'),('Sold',now(),'dhope'),('Cancelled',now(),'dhope'),('Rented',now(),'dhope'),('Withdrawn',now(),'dhope');


CREATE TABLE IF NOT EXISTS `userInfo` (
	`userId` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`firstName` varchar(45) NOT NULL,
	`lastName` varchar(45) NOT NULL,
	`email` varchar(150) NOT NULL,
	`password` varchar(45) NOT NULL,
	`lastUpdateDate` datetime NOT NULL,
	`lastUpdateId` varchar(45) NOT NULL,
	PRIMARY KEY (`userId`)
);

CREATE TABLE `agent` (
	`agentId` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`userId` int(11) unsigned NOT NULL,
	`bio` varchar(5000) DEFAULT NULL,
	`twitter` varchar(45) DEFAULT NULL,
	`facebook` varchar(45) DEFAULT NULL,
	`linkedIn` varchar(45) DEFAULT NULL,
	`lastUpdateDate` datetime NOT NULL,
	`lastUpdateId` varchar(45) NOT NULL,
	PRIMARY KEY (`agentId`),
	KEY `fk_agent_userId_idx` (`userId`)
);

CREATE TABLE IF NOT EXISTS `openHouse` (
	`openHouseId` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`listingId` int(11) unsigned NOT NULL,
	`title` varchar(45) NOT NULL,
	`description` varchar(150) NOT NULL,
	`startTime` varchar(10) NOT NULL,
	`endTime` varchar(10) NOT NULL,
	`startDate` datetime NOT NULL,
	`endDate` datetime NOT NULL,
	`lastUpdateDate` datetime NOT NULL,
	`lastUpdateId` varchar(45) NOT NULL,
	PRIMARY KEY (`openHouseId`),
	KEY `fk_openHouse_listingId_idx` (`listingId`)
);

CREATE TABLE IF NOT EXISTS `sale` (
	`saleId` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`listingId` int(11) unsigned NOT NULL,
	`price` decimal(13,2) NOT NULL,
	`saleDate` datetime NOT NULL,
	`notes` varchar(150) NOT NULL,
	`lastUpdateDate` datetime NOT NULL,
	`lastUpdateId` varchar(45) NOT NULL,
	PRIMARY KEY (`saleId`),
	KEY `fk_sale_listingId_idx` (`listingId`)
);

CREATE TABLE `state` (
	`stateId` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(45) NOT NULL,
	`abbreviation` varchar(45) NOT NULL,
	`lastUpdateDate` datetime NOT NULL,
	`lastUpdateId` varchar(45) NOT NULL,
	PRIMARY KEY (`stateId`)
);

insert into `state`(`name`,`abbreviation`,`lastUpdateDate`,`lastUpdateId`)
select `name`,`abbreviation`,now(),'dhope'
from `dhope_acadnav`.`states`;

alter table `parcel`
add constraint `fk_parcel_propertyId` FOREIGN KEY (`propertyId`) REFERENCES `property` (`propertyId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

alter table `agent`
add constraint `fk_agent_userId` FOREIGN KEY (`userId`) REFERENCES `userInfo` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION;


alter table `listing`
add constraint `fk_listing_statusTypeId` FOREIGN KEY (`statusTypeId`) REFERENCES `statusType` (`statusTypeId`) ON DELETE NO ACTION ON UPDATE NO ACTION, -- works
add constraint `fk_listing_propertyId` FOREIGN KEY (`propertyId`) REFERENCES `property` (`propertyId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

alter table `neighborhood`
add constraint `fk_neighborhood_propertyTypeId` FOREIGN KEY (`propertyTypeId`) REFERENCES `propertyType` (`propertyTypeId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

alter table `property`
add constraint `fk_property_propertyTypeId` FOREIGN KEY (`propertyTypeId`) REFERENCES `propertyType` (`propertyTypeId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
add constraint `fk_property_neighborhoodId` FOREIGN KEY (`neighborhoodId`) REFERENCES `neighborhood` (`neighborhoodId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
add constraint `fk_property_zoningTypeId` FOREIGN KEY (`zoningTypeId`) REFERENCES `zoningType` (`zoningTypeId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
add constraint `fk_property_stateId` FOREIGN KEY (`stateId`) REFERENCES `state` (`stateId`) ON DELETE NO ACTION ON UPDATE NO ACTION;


/*insert into property*/

/*insert into parcel*/

/*insert into listing*/

/*insert into listingPrice*/

/*insert into listingStatus*/

/*insert into userInfo*/

/*insert into agent*/

/*insert into open house*/

/*insert into sale*/

