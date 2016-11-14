<?php
require_once('JsonDataObject.php');
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
    public $lastUpdateDate;
    public $lastUpdateId;

    function __construct($obj = NULL) {
        if(isset($obj)){
            $this->buildFromObject($obj);
        }
    }

    public function buildFromObject($obj){

        $instance = objectToObject($obj,'Listing');

        return $instance;
    }

    public function getAll(){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select 
                                        mls,

                                        /*
                                        marketing_id,
                                        */

                                        address,
                                        price,

                                        /*
                                        date_listed,
                                        date_sold,
                                        type,
                                        */

                                        status,
                                        /*
                                        shortsale,
                                        price_original,
                                        price_previous,
                                        price_reduced,
                                        price_sold,
                                        sold_notes,
                                        sqft_live,
                                        sqft_lot,
                                        acres,
                                        */

                                        title,
                                        public_remarks,
                                        description_short/*,
                                        description_long,
                                        featured,
                                        front_page,
                                        area,subdiv,
                                        neighborhood,
                                        location,
                                        latitude,
                                        longitude,
                                        elevation,
                                        unit,
                                        city,
                                        state,
                                        zip,
                                        county,
                                        gated,
                                        floor,
                                        bed,
                                        bath,
                                        stories,
                                        garage,
                                        pool,
                                        spa,
                                        year_built,
                                        zoning,
                                        parcel,
                                        open_house_date,
                                        open_house_time,
                                        school_elementary,
                                        school_middle,
                                        school_high,
                                        youtube_id
                                        */
                                    from listings;");

			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}catch(PDOException $pdoe){
			throw new Exception($pdoe->getMessage());
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}

  public function GetByStatus($status){
		$pdo;
		$stmt;
		try {
			$pdo = getPDO();
			$stmt =  $pdo->prepare("select mls,marketing_id,address,price,date_listed,date_sold,type,status,shortsale,price_original,price_previous,price_reduced,price_sold,sold_notes,sqft_live,sqft_lot,acres,title,description_short,description_long,public_remarks,featured,front_page,area,subdiv,neighborhood,location,latitude,longitude,elevation,unit,city,state,zip,county,gated,floor,bed,bath,stories,garage,pool,spa,year_built,zoning,parcel,open_house_date,open_house_time,school_elementary,school_middle,school_high,youtube_id
          from listings
          where status = :status;");
          $stmt->bindParam(':status',$status, PDO::PARAM_STR);
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

	public function Save(){
		$pdo;
		$stmt;

		try {
			if($this->mls > 0){
					$pdo = getPDO();
                    /*
                        date_listed = :date_listed,
                        marketing_id = :marketing_id,
                        address = :address,
                        price = :price,
                        type = :type,
                        shortsale = :shortsale,
                        price_original = :price_original,
                        price_previous = :price_previous,
                        price_reduced = :price_reduced,
                        sqft_live = :sqft_live,
                        sqft_lot = :sqft_lot,
                        acres = :acres,
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
                        school_elementary = :school_elementary,
                        school_middle = :school_middle,
                        school_high = :school_high,

                    */
					$stmt =  $pdo->prepare("update listings set 
                                            title = :title,
                                            status = :status,
                                            description_short = :description_short,
                                            description_long = :description_long,
                                            public_remarks = :public_remarks,
                                            date_sold = :date_sold,
                                            price_sold = :price_sold,
                                            sold_notes = :sold_notes,
                                            featured = :featured,
                                            front_page = :front_page,
                                            open_house_date = :open_house_date,
                                            open_house_time = :open_house_time,
                                            youtube_id = :youtube_id 
 											where mls = :id;");

            $stmt->bindParam(':id',$this->mls, PDO::PARAM_INT);
            
            // if(is_null($this->marketing_id)){
            //     $stmt->bindValue(':marketing_id',NULL, PDO::PARAM_INT);
            // } else {
            //     $stmt->bindParam(':marketing_id',$this->marketing_id, PDO::PARAM_INT);
            // }

            // $stmt->bindParam(':address',$this->address, PDO::PARAM_STR);
            // $stmt->bindParam(':price',$this->price, PDO::PARAM_INT);
            // $stmt->bindParam(':date_listed',$this->date_listed, PDO::PARAM_STR);
            // $stmt->bindParam(':type',$this->type, PDO::PARAM_STR);
            // if(is_null($this->shortsale)){
            //     $stmt->bindValue(':shortsale',NULL, PDO::PARAM_INT);
            // } else {
            //     $stmt->bindParam(':shortsale',$this->shortsale, PDO::PARAM_STR);
            // }

            // if(is_null($this->price_original)){
            //     $stmt->bindValue(':price_original',NULL, PDO::PARAM_INT);
            // } else {
            //     $stmt->bindParam(':price_original',$this->price_original, PDO::PARAM_INT);
            // }

            // if(is_null($this->price_previous)){
            //     $stmt->bindValue(':price_previous',NULL, PDO::PARAM_INT);
            // } else {
            //     $stmt->bindParam(':price_previous',$this->price_previous, PDO::PARAM_INT);
            // }

            // if(is_null($this->price_reduced)){
            //     $stmt->bindValue(':price_reduced',NULL, PDO::PARAM_INT);
            // } else {
            //     $stmt->bindParam(':price_reduced',$this->price_reduced, PDO::PARAM_STR);
            // }
            // $stmt->bindParam(':sqft_live',$this->sqft_live, PDO::PARAM_INT);
            // $stmt->bindParam(':sqft_lot',$this->sqft_lot, PDO::PARAM_INT);
            // $stmt->bindParam(':acres',$this->acres, PDO::PARAM_INT);

            // $stmt->bindParam(':area',$this->area, PDO::PARAM_STR);
            // $stmt->bindParam(':subdiv',$this->subdiv, PDO::PARAM_STR);
            // $stmt->bindParam(':neighborhood',$this->neighborhood, PDO::PARAM_STR);
            // $stmt->bindParam(':location',$this->location, PDO::PARAM_STR);
            // $stmt->bindParam(':latitude',$this->latitude, PDO::PARAM_INT);
            // $stmt->bindParam(':longitude',$this->longitude, PDO::PARAM_INT);
            // $stmt->bindParam(':elevation',$this->elevation, PDO::PARAM_INT);
            // if(is_null($this->unit)){
            //     $stmt->bindValue(':unit',NULL, PDO::PARAM_INT);
            // } else {
            //     $stmt->bindParam(':unit',$this->unit, PDO::PARAM_STR);
            // }
            // $stmt->bindParam(':city',$this->city, PDO::PARAM_STR);
            // $stmt->bindParam(':state',$this->state, PDO::PARAM_STR);
            // $stmt->bindParam(':zip',$this->zip, PDO::PARAM_STR);
            // $stmt->bindParam(':county',$this->county, PDO::PARAM_STR);
            // $stmt->bindParam(':gated',$this->gated, PDO::PARAM_STR);

            // if(is_null($this->floor)){
            //     $stmt->bindValue(':floor',NULL, PDO::PARAM_INT);
            // } else {
            //     $stmt->bindParam(':floor',$this->floor, PDO::PARAM_STR);
            // }

            // $stmt->bindParam(':bed',$this->bed, PDO::PARAM_INT);
            // $stmt->bindParam(':bath',$this->bath, PDO::PARAM_INT);
            // $stmt->bindParam(':stories',$this->stories, PDO::PARAM_INT);
            // $stmt->bindParam(':garage',$this->garage, PDO::PARAM_INT);
            // $stmt->bindParam(':pool',$this->pool, PDO::PARAM_STR);
            // $stmt->bindParam(':spa',$this->spa, PDO::PARAM_STR);
            // $stmt->bindParam(':year_built',$this->year_built, PDO::PARAM_INT);
            // if(is_null($this->zoning)){
            //     $stmt->bindValue(':zoning',NULL, PDO::PARAM_INT);
            // } else {
            //     $stmt->bindParam(':zoning',$this->zoning, PDO::PARAM_STR);
            // }
            // $stmt->bindParam(':parcel',$this->parcel, PDO::PARAM_STR);
            // $stmt->bindParam(':school_elementary',$this->school_elementary, PDO::PARAM_STR);
            // $stmt->bindParam(':school_middle',$this->school_middle, PDO::PARAM_STR);
            // $stmt->bindParam(':school_high',$this->school_high, PDO::PARAM_STR);

            $stmt->bindParam(':title',$this->title, PDO::PARAM_STR);
            $stmt->bindParam(':status',$this->status, PDO::PARAM_STR);
            $stmt->bindParam(':description_short',$this->description_short, PDO::PARAM_STR);

            if(is_null($this->description_long)){
                $stmt->bindValue(':description_long',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':description_long',$this->description_long, PDO::PARAM_STR);
            }
            
            if(is_null($this->public_remarks)){
                $stmt->bindValue(':public_remarks',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':public_remarks',$this->public_remarks, PDO::PARAM_STR);
            }

            if(is_null($this->date_sold)){
                $stmt->bindValue(':date_sold',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':date_sold',$this->date_sold, PDO::PARAM_STR);
            }

            if(is_null($this->price_sold)){
                $stmt->bindValue(':price_sold',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':price_sold',$this->price_sold, PDO::PARAM_INT);
            }
            if(is_null($this->sold_notes)){
                $stmt->bindValue(':sold_notes',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':sold_notes',$this->sold_notes, PDO::PARAM_STR);
            }

            if(is_null($this->featured)){
                $stmt->bindValue(':featured',NULL, PDO::PARAM_INT);
            } else {
                if($this->featured){
                    $this->featured = 'y';

                    $stmt->bindParam(':featured',$this->featured, PDO::PARAM_STR);
                }else{
                    $stmt->bindValue(':featured',NULL, PDO::PARAM_INT);
                }
            }

            if(is_null($this->front_page)){
                $stmt->bindValue(':front_page',NULL, PDO::PARAM_INT);
            } else {
                if($this->front_page){
                    
                    $this->front_page = 'y';
                    $stmt->bindParam(':front_page',$this->front_page, PDO::PARAM_STR);
                }else{
                    $stmt->bindValue(':front_page',NULL, PDO::PARAM_INT);
                }
            }
            if(is_null($this->open_house_date)){
                $stmt->bindValue(':open_house_date',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':open_house_date',$this->open_house_date, PDO::PARAM_STR);
            }
            if(is_null($this->open_house_time)){
                $stmt->bindValue(':open_house_time',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':open_house_time',$this->open_house_time, PDO::PARAM_STR);
            }
            if(is_null($this->youtube_id)){
                $stmt->bindValue(':youtube_id',NULL, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':youtube_id',$this->youtube_id, PDO::PARAM_STR);
            }

			$stmt->execute();

			}
            ////Not allowing inserts, new listings should come from mls service
   //          else{
			// 		$pdo = getPDO();
			// 	$stmt =  $pdo->prepare("insert into listings(marketing_id,address,price,date_listed,date_sold,type,status,shortsale,price_original,price_previous,price_reduced,price_sold,sold_notes,sqft_live,sqft_lot,acres,title,description_short,description_long,public_remarks,featured,front_page,area,subdiv,neighborhood,location,latitude,longitude,elevation,unit,city,state,zip,county,gated,floor,bed,bath,stories,garage,pool,spa,year_built,zoning,parcel,open_house_date,open_house_time,school_elementary,school_middle,school_high,youtube_id)
   //      values(:marketing_id,:address,:price,:date_listed,:date_sold,:type,:status,:shortsale,:price_original,:price_previous,:price_reduced,:price_sold,:sold_notes,:sqft_live,:sqft_lot,:acres,:title,:description_short,:description_long,:public_remarks,:featured,:front_page,:area,:subdiv,:neighborhood,:location,:latitude,:longitude,:elevation,:unit,:city,:state,:zip,:county,:gated,:floor,:bed,:bath,:stories,:garage,:pool,:spa,:year_built,:zoning,:parcel,:open_house_date,:open_house_time,:school_elementary,:school_middle,:school_high,:youtube_id);");

			// 	$stmt->bindParam(':address',$this->address, PDO::PARAM_STR);
			// 	$stmt->bindParam(':price',$this->price, PDO::PARAM_INT);
			// 	$stmt->bindParam(':type',$this->type, PDO::PARAM_STR);
			// 	$stmt->bindParam(':status',$this->status, PDO::PARAM_STR);
			// 	$stmt->bindParam(':shortsale',$this->shortsale, PDO::PARAM_STR);
			// 	$stmt->bindParam(':price_original',$this->price_original, PDO::PARAM_INT);
			// 	$stmt->bindParam(':price_previous',$this->price_previous, PDO::PARAM_INT);
			// 	$stmt->bindParam(':price_reduced',$this->price_reduced, PDO::PARAM_STR);
			// 	$stmt->bindParam(':price_sold',$this->price_sold, PDO::PARAM_INT);
			// 	$stmt->bindParam(':sold_notes',$this->sold_notes, PDO::PARAM_STR);
			// 	$stmt->bindParam(':acres',$this->acres, PDO::PARAM_INT);
			// 	$stmt->bindParam(':title',$this->title, PDO::PARAM_STR);
			// 	$stmt->bindParam(':description_short',$this->description_short, PDO::PARAM_STR);
			// 	$stmt->bindParam(':description_long',$this->description_long, PDO::PARAM_STR);
			// 	$stmt->bindParam(':public_remarks',$this->public_remarks, PDO::PARAM_STR);
			// 	$stmt->bindParam(':featured',$this->featured, PDO::PARAM_STR);
			// 	$stmt->bindParam(':front_page',$this->front_page, PDO::PARAM_STR);
			// 	$stmt->bindParam(':area',$this->area, PDO::PARAM_STR);
			// 	$stmt->bindParam(':subdiv',$this->subdiv, PDO::PARAM_STR);
			// 	$stmt->bindParam(':neighborhood',$this->neighborhood, PDO::PARAM_STR);
			// 	$stmt->bindParam(':location',$this->location, PDO::PARAM_STR);
			// 	$stmt->bindParam(':latitude',$this->latitude, PDO::PARAM_INT);
			// 	$stmt->bindParam(':longitude',$this->longitude, PDO::PARAM_INT);
			// 	$stmt->bindParam(':unit',$this->unit, PDO::PARAM_STR);
			// 	$stmt->bindParam(':city',$this->city, PDO::PARAM_STR);
			// 	$stmt->bindParam(':state',$this->state, PDO::PARAM_STR);
			// 	$stmt->bindParam(':zip',$this->zip, PDO::PARAM_STR);
			// 	$stmt->bindParam(':county',$this->county, PDO::PARAM_STR);
			// 	$stmt->bindParam(':gated',$this->gated, PDO::PARAM_STR);
			// 	$stmt->bindParam(':pool',$this->pool, PDO::PARAM_STR);
			// 	$stmt->bindParam(':spa',$this->spa, PDO::PARAM_STR);
			// 	$stmt->bindParam(':zoning',$this->zoning, PDO::PARAM_STR);
			// 	$stmt->bindParam(':parcel',$this->parcel, PDO::PARAM_STR);
			// 	$stmt->bindParam(':open_house_date',$this->open_house_date, PDO::PARAM_STR);
			// 	$stmt->bindParam(':open_house_time',$this->open_house_time, PDO::PARAM_STR);
			// 	$stmt->bindParam(':school_elementary',$this->school_elementary, PDO::PARAM_STR);
			// 	$stmt->bindParam(':school_middle',$this->school_middle, PDO::PARAM_STR);
			// 	$stmt->bindParam(':school_high',$this->school_high, PDO::PARAM_STR);
			// 	$stmt->bindParam(':youtube_id',$this->youtube_id, PDO::PARAM_STR);
			// 	$stmt->execute();
			// 	$this->mls = $pdo->lastInsertId();
			// }

			if($stmt->rowCount() > 0){
				Return $this->Get($this->mls);
			}else{
				throw new Exception(($this->mls > 0 ? "Update" : "Insert") . "  failed.");
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
