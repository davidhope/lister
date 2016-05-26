<?php
Class Listing extends JsonDataObject
{
	public $mls;
	public $marketing_id;
	public $address;
	public $price;
	public $date_listed;
	public $date_sold;
	public $type;
	public $status;
	public $shortsale;
	public $price_original;
	public $price_previous;
	public $price_reduced;
	public $price_sold;
	public $sold_notes;
	public $sqft_live;
	public $sqft_lot;
	public $acres;
	public $title;
	public $description_short;
	public $description_long;
	public $public_remarks;
	public $featured;
	public $front_page;
	public $area;
	public $subdiv;
	public $neighborhood;
	public $location;
	public $latitude;
	public $longitude;
	public $elevation;
	public $unit;
	public $city;
	public $state;
	public $zip;
	public $county;
	public $gated;
	public $floor;
	public $bed;
	public $bath;
	public $stories;
	public $garage;
	public $pool;
	public $spa;
	public $year_built;
	public $zoning;
	public $parcel;
	public $open_house_date;
	public $open_house_time;
	public $school_elementary;
	public $school_middle;
	public $school_high;
	public $youtube_id;
}
Class ListingController{

  public function GetAll(){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select mls,marketing_id,address,price,date_listed,date_sold,type,status,shortsale,price_original,price_previous,price_reduced,price_sold,sold_notes,sqft_live,sqft_lot,acres,title,description_short,description_long,public_remarks,featured,front_page,area,subdiv,neighborhood,location,latitude,longitude,elevation,unit,city,state,zip,county,gated,floor,bed,bath,stories,garage,pool,spa,year_built,zoning,parcel,open_house_date,open_house_time,school_elementary,school_middle,school_high,youtube_id from listings;");
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function Get($mls){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select mls,marketing_id,address,price,date_listed,date_sold,type,status,shortsale,price_original,price_previous,price_reduced,price_sold,sold_notes,sqft_live,sqft_lot,acres,title,description_short,description_long,public_remarks,featured,front_page,area,subdiv,neighborhood,location,latitude,longitude,elevation,unit,city,state,zip,county,gated,floor,bed,bath,stories,garage,pool,spa,year_built,zoning,parcel,open_house_date,open_house_time,school_elementary,school_middle,school_high,youtube_id from listings where mls = :mls;");
			$stmt->bindParam(':mls',$mls, PDO::PARAM_INT);
			$stmt->execute();
			$Listing = new Listing;
			$Listing = $stmt->fetchObject('Listing');
			return $Listing;
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function Save($Listing){
		$pdo;
		$stmt;

		try {
			if($Listing->mls > 0){
					$pdo = getPDO();
					$stmt =  $pdo->prepare("update listings set
                        marketing_id = :marketing_id,
                        address = :address,
                        price = :price,
                        date_listed = :date_listed,
                        date_sold = :date_sold,
                        type = :type,
                        status = :status,
                        shortsale = :shortsale,
                        price_original = :price_original,
                        price_previous = :price_previous,
                        price_reduced = :price_reduced,
                        price_sold = :price_sold,
                        sold_notes = :sold_notes,
                        sqft_live = :sqft_live,
                        sqft_lot = :sqft_lot,
                        acres = :acres,
                        title = :title,
                        description_short = :description_short,
                        description_long = :description_long,
                        public_remarks = :public_remarks,
                        featured = :featured,
                        front_page = :front_page,
                        area = :area,
                        subdiv = :subdiv,
                        neighborhood = :neighborhood,
                        location = :location,
                        latitude = :latitude,
                        longitude = :longitude,
                        elevation = :elevation,
                        unit = :unit,
                        city = :city,
                        state = :state,
                        zip = :zip,
                        county = :county,
                        gated = :gated,
                        floor = :floor,
                        bed = :bed,
                        bath = :bath,
                        stories = :stories,
                        garage = :garage,
                        pool = :pool,
                        spa = :spa,
                        year_built = :year_built,
                        zoning = :zoning,
                        parcel = :parcel,
                        open_house_date = :open_house_date,
                        open_house_time = :open_house_time,
                        school_elementary = :school_elementary,
                        school_middle = :school_middle,
                        school_high = :school_high,
                        youtube_id = :youtube_id
 											where mls = :id;");
            $stmt->bindParam(':id',$Listing->mls, PDO::PARAM_INT);

            if(is_null($Listing->marketing_id)){
                $stmt->bindValue(':marketing_id',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':marketing_id',$Listing->marketing_id, PDO::PARAM_INT);
            }

            $stmt->bindParam(':address',$Listing->address, PDO::PARAM_STR);
            $stmt->bindParam(':price',$Listing->price, PDO::PARAM_INT);
            $stmt->bindParam(':date_listed',$Listing->date_listed, PDO::PARAM_STR);
            if(is_null($Listing->date_sold)){
                $stmt->bindValue(':date_sold',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':date_sold',$Listing->date_sold, PDO::PARAM_STR);
            }
            $stmt->bindParam(':type',$Listing->type, PDO::PARAM_STR);
            $stmt->bindParam(':status',$Listing->status, PDO::PARAM_STR);
            if(is_null($Listing->shortsale)){
                $stmt->bindValue(':shortsale',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':shortsale',$Listing->shortsale, PDO::PARAM_STR);
            }

            if(is_null($Listing->price_original)){
                $stmt->bindValue(':price_original',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':price_original',$Listing->price_original, PDO::PARAM_INT);
            }

            if(is_null($Listing->price_previous)){
                $stmt->bindValue(':price_previous',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':price_previous',$Listing->price_previous, PDO::PARAM_INT);
            }

            if(is_null($Listing->price_reduced)){
                $stmt->bindValue(':price_reduced',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':price_reduced',$Listing->price_reduced, PDO::PARAM_STR);
            }

            if(is_null($Listing->price_sold)){
                $stmt->bindValue(':price_sold',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':price_sold',$Listing->price_sold, PDO::PARAM_INT);
            }
            if(is_null($Listing->sold_notes)){
                $stmt->bindValue(':sold_notes',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':sold_notes',$Listing->sold_notes, PDO::PARAM_STR);
            }
            $stmt->bindParam(':sqft_live',$Listing->sqft_live, PDO::PARAM_INT);
            $stmt->bindParam(':sqft_lot',$Listing->sqft_lot, PDO::PARAM_INT);
            $stmt->bindParam(':acres',$Listing->acres, PDO::PARAM_INT);
            $stmt->bindParam(':title',$Listing->title, PDO::PARAM_STR);
            $stmt->bindParam(':description_short',$Listing->description_short, PDO::PARAM_STR);

            if(is_null($Listing->description_long)){
                $stmt->bindValue(':description_long',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':description_long',$Listing->description_long, PDO::PARAM_STR);
            }
            $stmt->bindParam(':public_remarks',$Listing->public_remarks, PDO::PARAM_STR);

            if(is_null($Listing->featured)){
                $stmt->bindValue(':featured',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':featured',$Listing->featured, PDO::PARAM_STR);
            }

            if(is_null($Listing->front_page)){
                $stmt->bindValue(':front_page',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':front_page',$Listing->front_page, PDO::PARAM_STR);
            }

            $stmt->bindParam(':area',$Listing->area, PDO::PARAM_STR);
            $stmt->bindParam(':subdiv',$Listing->subdiv, PDO::PARAM_STR);
            $stmt->bindParam(':neighborhood',$Listing->neighborhood, PDO::PARAM_STR);
            $stmt->bindParam(':location',$Listing->location, PDO::PARAM_STR);
            $stmt->bindParam(':latitude',$Listing->latitude, PDO::PARAM_INT);
            $stmt->bindParam(':longitude',$Listing->longitude, PDO::PARAM_INT);
            $stmt->bindParam(':elevation',$Listing->elevation, PDO::PARAM_INT);
            if(is_null($Listing->unit)){
                $stmt->bindValue(':unit',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':unit',$Listing->unit, PDO::PARAM_STR);
            }
            $stmt->bindParam(':city',$Listing->city, PDO::PARAM_STR);
            $stmt->bindParam(':state',$Listing->state, PDO::PARAM_STR);
            $stmt->bindParam(':zip',$Listing->zip, PDO::PARAM_STR);
            $stmt->bindParam(':county',$Listing->county, PDO::PARAM_STR);
            $stmt->bindParam(':gated',$Listing->gated, PDO::PARAM_STR);

            if(is_null($Listing->floor)){
                $stmt->bindValue(':floor',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':floor',$Listing->floor, PDO::PARAM_STR);
            }

            $stmt->bindParam(':bed',$Listing->bed, PDO::PARAM_INT);
            $stmt->bindParam(':bath',$Listing->bath, PDO::PARAM_INT);
            $stmt->bindParam(':stories',$Listing->stories, PDO::PARAM_INT);
            $stmt->bindParam(':garage',$Listing->garage, PDO::PARAM_INT);
            $stmt->bindParam(':pool',$Listing->pool, PDO::PARAM_STR);
            $stmt->bindParam(':spa',$Listing->spa, PDO::PARAM_STR);
            $stmt->bindParam(':year_built',$Listing->year_built, PDO::PARAM_INT);
            if(is_null($Listing->zoning)){
                $stmt->bindValue(':zoning',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':zoning',$Listing->zoning, PDO::PARAM_STR);
            }
            $stmt->bindParam(':parcel',$Listing->parcel, PDO::PARAM_STR);
            if(is_null($Listing->open_house_date)){
                $stmt->bindValue(':open_house_date',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':open_house_date',$Listing->open_house_date, PDO::PARAM_STR);
            }
            if(is_null($Listing->open_house_time)){
                $stmt->bindValue(':open_house_time',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':open_house_time',$Listing->open_house_time, PDO::PARAM_STR);
            }
            $stmt->bindParam(':school_elementary',$Listing->school_elementary, PDO::PARAM_STR);
            $stmt->bindParam(':school_middle',$Listing->school_middle, PDO::PARAM_STR);
            $stmt->bindParam(':school_high',$Listing->school_high, PDO::PARAM_STR);
            if(is_null($Listing->youtube_id)){
                $stmt->bindValue(':youtube_id',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':youtube_id',$Listing->youtube_id, PDO::PARAM_STR);
            }
					$stmt->execute();
			}else{
					$pdo = getPDO();
				$stmt =  $pdo->prepare("insert into listings(marketing_id,address,price,date_listed,date_sold,type,status,shortsale,price_original,price_previous,price_reduced,price_sold,sold_notes,sqft_live,sqft_lot,acres,title,description_short,description_long,public_remarks,featured,front_page,area,subdiv,neighborhood,location,latitude,longitude,elevation,unit,city,state,zip,county,gated,floor,bed,bath,stories,garage,pool,spa,year_built,zoning,parcel,open_house_date,open_house_time,school_elementary,school_middle,school_high,youtube_id)
        values(:marketing_id,:address,:price,:date_listed,:date_sold,:type,:status,:shortsale,:price_original,:price_previous,:price_reduced,:price_sold,:sold_notes,:sqft_live,:sqft_lot,:acres,:title,:description_short,:description_long,:public_remarks,:featured,:front_page,:area,:subdiv,:neighborhood,:location,:latitude,:longitude,:elevation,:unit,:city,:state,:zip,:county,:gated,:floor,:bed,:bath,:stories,:garage,:pool,:spa,:year_built,:zoning,:parcel,:open_house_date,:open_house_time,:school_elementary,:school_middle,:school_high,:youtube_id);");

				$stmt->bindParam(':address',$Listing->address, PDO::PARAM_STR);
				$stmt->bindParam(':price',$Listing->price, PDO::PARAM_INT);
				$stmt->bindParam(':type',$Listing->type, PDO::PARAM_STR);
				$stmt->bindParam(':status',$Listing->status, PDO::PARAM_STR);
				$stmt->bindParam(':shortsale',$Listing->shortsale, PDO::PARAM_STR);
				$stmt->bindParam(':price_original',$Listing->price_original, PDO::PARAM_INT);
				$stmt->bindParam(':price_previous',$Listing->price_previous, PDO::PARAM_INT);
				$stmt->bindParam(':price_reduced',$Listing->price_reduced, PDO::PARAM_STR);
				$stmt->bindParam(':price_sold',$Listing->price_sold, PDO::PARAM_INT);
				$stmt->bindParam(':sold_notes',$Listing->sold_notes, PDO::PARAM_STR);
				$stmt->bindParam(':acres',$Listing->acres, PDO::PARAM_INT);
				$stmt->bindParam(':title',$Listing->title, PDO::PARAM_STR);
				$stmt->bindParam(':description_short',$Listing->description_short, PDO::PARAM_STR);
				$stmt->bindParam(':description_long',$Listing->description_long, PDO::PARAM_STR);
				$stmt->bindParam(':public_remarks',$Listing->public_remarks, PDO::PARAM_STR);
				$stmt->bindParam(':featured',$Listing->featured, PDO::PARAM_STR);
				$stmt->bindParam(':front_page',$Listing->front_page, PDO::PARAM_STR);
				$stmt->bindParam(':area',$Listing->area, PDO::PARAM_STR);
				$stmt->bindParam(':subdiv',$Listing->subdiv, PDO::PARAM_STR);
				$stmt->bindParam(':neighborhood',$Listing->neighborhood, PDO::PARAM_STR);
				$stmt->bindParam(':location',$Listing->location, PDO::PARAM_STR);
				$stmt->bindParam(':latitude',$Listing->latitude, PDO::PARAM_INT);
				$stmt->bindParam(':longitude',$Listing->longitude, PDO::PARAM_INT);
				$stmt->bindParam(':unit',$Listing->unit, PDO::PARAM_STR);
				$stmt->bindParam(':city',$Listing->city, PDO::PARAM_STR);
				$stmt->bindParam(':state',$Listing->state, PDO::PARAM_STR);
				$stmt->bindParam(':zip',$Listing->zip, PDO::PARAM_STR);
				$stmt->bindParam(':county',$Listing->county, PDO::PARAM_STR);
				$stmt->bindParam(':gated',$Listing->gated, PDO::PARAM_STR);
				$stmt->bindParam(':pool',$Listing->pool, PDO::PARAM_STR);
				$stmt->bindParam(':spa',$Listing->spa, PDO::PARAM_STR);
				$stmt->bindParam(':zoning',$Listing->zoning, PDO::PARAM_STR);
				$stmt->bindParam(':parcel',$Listing->parcel, PDO::PARAM_STR);
				$stmt->bindParam(':open_house_date',$Listing->open_house_date, PDO::PARAM_STR);
				$stmt->bindParam(':open_house_time',$Listing->open_house_time, PDO::PARAM_STR);
				$stmt->bindParam(':school_elementary',$Listing->school_elementary, PDO::PARAM_STR);
				$stmt->bindParam(':school_middle',$Listing->school_middle, PDO::PARAM_STR);
				$stmt->bindParam(':school_high',$Listing->school_high, PDO::PARAM_STR);
				$stmt->bindParam(':youtube_id',$Listing->youtube_id, PDO::PARAM_STR);
				$stmt->execute();
				$Listing->mls = $pdo->lastInsertId();
			}
			if($stmt->rowCount() > 0){
				Return $this->Get($Listing->mls);
			}else{
				throw new Exception(($Listing->mls > 0 ? "Update" : "Insert") . "  failed.");
			}
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	public function Delete($mls){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("delete from listings where mls = :mls;");
			$stmt->bindParam(':mls',$mls, PDO::PARAM_INT);
			$stmt->execute();
			if($stmt->rowCount() == 0){
				throw new Exception("Could not remove Listing.");
			}else{
				Return "Listing removed successfully.";
			}
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
}
?>
