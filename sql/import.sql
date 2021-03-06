use tlg_v2;

/*Insert into property*/

INSERT INTO `tlg_v2`.`property`
(`propertyTypeId`,`neighborhoodId`,`zoningTypeId`,`areaCode`,`subdivision`,`location`,`latitude`,`longitude`,
`elevation`,`unit`,`address`,`city`,`stateId`,`zip`,`county`,`gated`,`floor`,`bed`,`bath`,`stories`,`garage`,`pool`,
`spa`,`yearBuilt`,`schoolElementary`,`schoolMiddle`,`schoolHigh`,`sqFtLiving`,`sqFtLot`,`acres`,`parcelNumber`,`lastUpdateDate`,`lastUpdateId`)
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
    CAST(coalesce(mls.`bed`,0) as unsigned),
    CAST(coalesce(mls.`bath`,0) as unsigned),
    CAST(coalesce(mls.`stories`,0) as unsigned),
    CAST(coalesce(mls.`garage`,0) as unsigned),
    case mls.`pool`
		when 'N' then 0
        else 1
	end,
    case mls.`spa`
		when 'N' then 0
        else 1
	end,
    CAST(coalesce(mls.`year_built`,0) as unsigned),
    mls.`school_elementary`,
    mls.`school_middle`,
    mls.`school_high`,
    CAST(coalesce(mls.`sqft_live`,0.0) as  decimal(13,2)),
    CAST(coalesce(mls.`sqft_lot`,0.0) as  decimal(13,2)),
    CAST(coalesce(mls.`acres`,0.0) as  decimal(13,2)),
    coalesce(mls.parcel,''),
    now(),
    'dhope'
from `tlg`.`listings_mls` mls
inner join `tlg`.`listings` tlg on mls.mls = tlg.mls
inner join `tlg_v2`.`state` s on mls.`state` = s.abbreviation
left join `tlg_v2`.`property` p	on mls.parcel = p.parcelNumber
left join `tlg_v2`.`neighborhood` nbh on mls.`neighborhood` = nbh.name
left join `tlg_v2`.`zoningtype` z on mls.`zoning` = z.name
where p.propertyId is null;

/*Insert into listing*/
INSERT INTO `tlg_v2`.`listing`(`propertyId`,`agentId`,`saleId`,`mls`,`title`,`descriptionShort`,`descriptionLong`,
`publicRemarks`,`marketingId`,`youTubeId`,`shortSale`,`featured`,`frontPage`,`lastUpdateDate`,`lastUpdateId`)
SELECT 
    prop.propertyId,
    ag.agentId,
    null,
    tlg.mls,
    tlg.title,
    tlg.description_short,
    tlg.description_long,
    tlg.public_remarks,
    tlg.marketing_id,
    tlg.youtube_id,
    case tlg.shortSale
		when 'N' then 0
        else 1
	end,
    case tlg.featured
		when 'N' then 0
        else 1
	end,
    case tlg.front_page
		when 'N' then 0
        else 1
	end,
    now(),
    'dhope'
FROM `tlg_v2`.`property` prop
inner join `tlg`.`listings` tlg on prop.parcelNumber = tlg.parcel
inner join `tlg`.`listings_mls` mls on mls.mls = tlg.mls
inner join `tlg_v2`.`userInfo` us on us.email = mls.email
inner join `tlg_v2`.`agent` ag on ag.userId = us.userId;

/*insert listing status records*/
INSERT INTO `tlg_v2`.`listingstatus`
(`listingId`,`statusTypeId`,`lastUpdateDate`,`lastUpdateId`)
select l.listingId,st.statusTypeId,now(),'dhope'
from `tlg_v2`.`listing` l
inner join `tlg`.`listings` tlg on tlg.mls = l.mls
inner join `tlg_v2`.`statustype` st on st.name = tlg.status;


/*insert original listing prices */
INSERT INTO `tlg_v2`.`listingprice`(`listingId`,`price`,`lastUpdateDate`,`lastUpdateId`)
select l.listingId,tlg.price_original,now(),'dhope'
from `tlg_v2`.`listing` l
inner join `tlg`.`listings` tlg on tlg.mls = l.mls
where tlg.price_original is not null;

/*insert previous listing prices */
INSERT INTO `tlg_v2`.`listingprice`(`listingId`,`price`,`lastUpdateDate`,`lastUpdateId`)
select l.listingId,tlg.price_previous,now(),'dhope'
from `tlg_v2`.`listing` l
inner join `tlg`.`listings` tlg on tlg.mls = l.mls
where tlg.price_previous is not null
and tlg.price_original != tlg.price_previous;

/*insert previous listing prices */
INSERT INTO `tlg_v2`.`listingprice`(`listingId`,`price`,`lastUpdateDate`,`lastUpdateId`)
select l.listingId,tlg.price,now(),'dhope'
from `tlg_v2`.`listing` l
inner join `tlg`.`listings` tlg on tlg.mls = l.mls
where tlg.price is not null
and tlg.price != tlg.price_original
and tlg.price != tlg.price_previous;


