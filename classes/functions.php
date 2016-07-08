<?php
	date_default_timezone_set("America/Chicago");

	session_start();

  use Mailgun\Mailgun;

	function ReturnJsonTable($json) {
		header('HTTP/1.1 200 OK', true, 200);
		header('Content-Type: application/json');
		print("{\"aaData\":" . json_encode($json) . "}");
	}

	function GetJsonMessage($msg) {
		header('HTTP/1.1 200 OK', true, 200);
		header('Content-Type: application/json');
		$arr = array("SvcMessage" => array("MessageText" => $msg));
		print json_encode($arr);
	}

	function ReturnJsonSuccess($json){
		//http_response_code(200);
		header('HTTP/1.1 200 OK', true, 200);
		header('Content-Type: application/json');
		print(json_encode($json));
	}

	function ReturnJsonError($err){
		//http_response_code(400);
		header('HTTP/1.1 400 Bad Request', true, 400);
		header('Content-Type: application/json');
		print(json_encode($err));
	}

    function arrayToDataTable(array $cols, array $rows) {

	    if (!empty($rows) && !empty($cols)) {

		    if (count($cols) !== count($rows[0])) {
			    // Values specified in the first row of $rows don't add up to the ones in $cols
			    throw new Exception('Number of values in rows must match number of columns');
		    }

		    $return = array();

		    // Process columns
		    foreach ($cols as $column) {
			    // Check if the column has a type
			    if (!array_key_exists('type', $column) && array_key_exists(0, $column)) {
				    // Try to mangle us a type
				    switch ($column[0]) {
					    case 'boolean':
					    case 'number':
					    case 'string':
					    case 'date':
					    case 'datetime':
					    case 'timeofday':
						    $column['type'] = $column[0];
					    break;
					    default:
						    $column['type'] = 'string';
					    break;
				    }
				    unset($column[0]);
				    // Assume the second entry is a label
				    if (array_key_exists(1, $column)) {
					    $column['label'] = $column[1];
					    unset($column[1]);
				    }
			    }
			    // @TODO: Add key => val validation here?
			    $return['cols'][] = $column;
		    }

            //print_r($return['cols']);

		    // Process rows
		    foreach ($rows as $row) {
			    // <3 Nested Arrays
			    $tmp = array('c' => array());
			    foreach ($row as $key => $cell) {
				    // Is our cell a plain or an array with other stuff?
				    if (!is_array($cell)) {
					    $cell = array('v' => $cell);
				    }
				    // @TODO: Add key => val validation here?
				    $tmp['c'][] = $cell;
			    }
			    $return['rows'][] = $tmp;
		    }

            //print_r($return);

		    print(json_encode($return));
	    }
	    else {
		    // We can't work without something to work on
		    throw new Exception('Unable to process empty arrays');
	    }
    }


	function logout(){
		unset($_SESSION[con_displayname]);
		unset($_SESSION[con_userid]);
		unset($_SESSION[con_timeout]);
	}

	function logError($num, $msg){
        $pdo;
        $stmt;

        try {
            $pdo = getPDO();

            $stmt =  $pdo->prepare('insert into errorlogs(number, message, timestamp)
                                        values(:errnum, :message, now());');

            $stmt->bindParam(':errnum',$num, PDO::PARAM_INT);
            $stmt->bindParam(':message',$msg, PDO::PARAM_STR);

            $stmt->execute();

            if($stmt->rowCount() == 0){
                ReturnJsonError("Could not log error.");
            }

        }
        catch(PDOException $pdoe){
            throw new Exception($pdoe->getMessage());
        }
        catch(Exception $e){
            throw new Exception($e->getMessage());
        }
	}

    function getStateById($id){
        $states = array(1=>'AL',
                        2=>'AK',
                        3=>'AZ',
                        4=>'AR',
                        5=>'CA',
                        6=>'CO',
                        7=>'CT',
                        8=>'DE',
                        9=>'DC',
                        10=>'FL',
                        11=>'GA',
                        12=>'HI',
                        13=>'ID',
                        14=>'IL',
                        15=>'IN',
                        16=>'IA',
                        17=>'KS',
                        18=>'KY',
                        19=>'LA',
                        20=>'ME',
                        21=>'MD',
                        22=>'MA',
                        23=>'MI',
                        24=>'MN',
                        25=>'MS',
                        26=>'MO',
                        27=>'MT',
                        28=>'NE',
                        29=>'NV',
                        30=>'NH',
                        31=>'NJ',
                        32=>'NM',
                        33=>'NY',
                        34=>'NC',
                        35=>'ND',
                        36=>'OH',
                        37=>'OK',
                        38=>'OR',
                        39=>'PA',
                        40=>'RI',
                        41=>'SC',
                        42=>'SD',
                        43=>'TN',
                        44=>'TX',
                        45=>'UT',
                        46=>'VT',
                        47=>'VA',
                        48=>'WA',
                        49=>'WV',
                        50=>'WI',
                        51=>'WY'
                    );

            return $states[$id];
    }

		//solution found at http://stackoverflow.com/questions/3243900/convert-cast-an-stdclass-object-to-another-class/3243949
		//method used to cast stdClass objects that come in from phpInput to native class

		function objectToObject($instance, $className) {
		    return unserialize(sprintf(
		        'O:%d:"%s"%s',
		        strlen($className),
		        $className,
		        strstr(strstr(serialize($instance), '"'), ':')
		    ));
		}
?>
