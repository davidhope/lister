use tlg_v2;

select * from neighborhood;
select * from zoningtype;
select * from state;
select * from statustype;
select * from propertyType;


use tlg;

select count(*),pool from listings_mls group by pool;
select count(*),spa from listings_mls group by spa;
select distinct parcel from listings_mls;
select distinct parcel from listings;
select * from listings where zoning is null and status = 'For Sale';
select * from listings_mls where zoning is null and status = 'For Sale';

/*Insert into property*/
/*
INSERT INTO `tlg_v2`.`property`
(`propertyTypeId`,`neighborhoodId`,`zoningTypeId`,`areaCode`,`subdivision`,`location`,`latitude`,`longitude`,
`elevation`,`unit`,`address`,`city`,`stateId`,`zip`,`county`,`gated`,`floor`,`bed`,`bath`,`stories`,`garage`,`pool`,
`spa`,`yearBuilt`,`schoolElementary`,`schoolMiddle`,`schoolHigh`,`sqFtLiving`,`sqFtLot`,`acres`,`parcelNumber`,`lastUpdateDate`,`lastUpdateId`)
*/
SELECT 
    case mls.`type` 
		when 'House' then 1
        when 'Highrise' then 2
        when 'Land' then 3
        when 'Rental' then 4
        when 'Condo' then 5
        else null
	end,
    nbh.neighborhoodId,
    z.zoningTypeId,
    mls.`area`,
    mls.`subdiv`,
    mls.`location`,
    mls.`latitude`,
    CAST(mls.`latitude` as  decimal(13,6)),
    CAST(mls.`longitude` as  decimal(13,6)),
    CAST(mls.`elevation` as unsigned),
    mls.`unit`,
    mls.`address`,
    mls.`city`,
    s.stateId,
    mls.`zip`,
    mls.`county`,
    case mls.`gated`
		when 'Y' then 1
        else 0
	end,
    CAST(mls.`floor` as unsigned),
    CAST(mls.`bed` as unsigned),
    CAST(mls.`bath` as unsigned),
    CAST(mls.`stories` as unsigned),
    CAST(mls.`garage` as unsigned),
    case mls.`pool`
		when 'N' then 0
        else 1
	end,
    case mls.`spa`
		when 'N' then 0
        else 1
	end,
    CAST(mls.`year_built` as unsigned),
    mls.`school_elementary`,
    mls.`school_middle`,
    mls.`school_high`,
    CAST(mls.`sqft_live` as  decimal(13,2)),
    CAST(mls.`sqft_lot` as  decimal(13,2)),
    CAST(mls.`acres` as  decimal(13,2)),
    mls.parcel,
    now(),
    'dhope'
from `tlg`.`listings_mls` mls
left join `tlg_v2`.`property` p	on mls.parcel = p.parcelNumber
left join `tlg_v2`.`neighborhood` nbh on mls.`neighborhood` = nbh.name
left join `tlg_v2`.`zoningtype` z on mls.`zoning` = z.name
left join `tlg_v2`.`state` s on mls.`state` = s.name
where p.propertyId is null;

/*Insert into property*/
/*Not using since trying to add parcel to property table
INSERT INTO `tlg_v2`.`property`
(`propertyTypeId`,`neighborhoodId`,`zoningTypeId`,`areaCode`,`subdivision`,`location`,`latitude`,`longitude`,
`elevation`,`unit`,`address`,`city`,`stateId`,`zip`,`county`,`gated`,`floor`,`bed`,`bath`,`stories`,`garage`,`pool`,
`spa`,`yearBuilt`,`schoolElementary`,`schoolMiddle`,`schoolHigh`,`sqFtLiving`,`sqFtLot`,`acres`,`lastUpdateDate`,`lastUpdateId`)

SELECT
    `propertystaging`.`propertyTypeId`,
    `propertystaging`.`neighborhoodId`,
    `propertystaging`.`zoningTypeId`,
    `propertystaging`.`areaCode`,
    `propertystaging`.`subdivision`,
    `propertystaging`.`location`,
    `propertystaging`.`latitude`,
    `propertystaging`.`longitude`,
    `propertystaging`.`elevation`,
    `propertystaging`.`unit`,
    `propertystaging`.`address`,
    `propertystaging`.`city`,
    `propertystaging`.`stateId`,
    `propertystaging`.`zip`,
    `propertystaging`.`county`,
    `propertystaging`.`gated`,
    `propertystaging`.`floor`,
    `propertystaging`.`bed`,
    `propertystaging`.`bath`,
    `propertystaging`.`stories`,
    `propertystaging`.`garage`,
    `propertystaging`.`pool`,
    `propertystaging`.`spa`,
    `propertystaging`.`yearBuilt`,
    `propertystaging`.`schoolElementary`,
    `propertystaging`.`schoolMiddle`,
    `propertystaging`.`schoolHigh`,
    `propertystaging`.`sqFtLiving`,
    `propertystaging`.`sqFtLot`,
    `propertystaging`.`acres`,
    now(),
    'dhope'
FROM `tlg_v2`.`propertystaging` prop
left join `tlg_v2`.`parcel` pcl	on prop.parcelNumber = pcl.parcelNumber
where pcl.parcelId is null;
*/

/*Insert into parcel*/
/*
INSERT INTO `tlg_v2`.`parcel`
(`parcelNumber`,
`propertyId`,
`lastUpdateDate`,
`lastUpdateId`)

select
	mls.parcel,
	prop.propertyId,
	now(),
    'dhope'
from `tlg_v2`.`propertystaging` prop
left join `tlg_v2`.`parcel` pcl	on prop.parcelNumber = pcl.parcelNumber
where pcl.parcelId is null
*/

/*
`listings_mls`.`mls`,
    `listings_mls`.`glvar_id`,
    `listings_mls`.`view_count`,
    `listings_mls`.`images`,
    `listings_mls`.`images_optimized`,
    `listings_mls`.`date_added`,
    `listings_mls`.`dom`,
    `listings_mls`.`date_updated`,
    `listings_mls`.`last_image_trans`,
    `listings_mls`.`last_image_update`,
    `listings_mls`.`price`,
    `listings_mls`.`price_reduced`,
    `listings_mls`.`date_listed`,
    `listings_mls`.`date_sold`,
    `listings_mls`.`status`,
    `listings_mls`.`shortsale`,
    `listings_mls`.`title`,
    `listings_mls`.`description_short`,
    `listings_mls`.`description_long`,
    `listings_mls`.`public_remarks`,
    `listings_mls`.`featured`,
    `listings_mls`.`front_page`,
    `listings_mls`.`open_house_date`,
    `listings_mls`.`open_house_time`,
    `listings_mls`.`listing_agent`,
    `listings_mls`.`brokerage`,
    `listings_mls`.`parcel`,
    `listings_mls`.`email`
FROM `tlg`.`listings_mls`;

*/