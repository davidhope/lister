/* remove trailing comma in column list in save/update */

set @schema_name = 'tlg_v2';
set @classname = 'Sale';
set @table_name = lower(@classname);
use `tlg_v2`;

select @keyname := parentTable.COLUMN_NAME
FROM INFORMATION_SCHEMA.COLUMNS as parentTable
WHERE parentTable.TABLE_SCHEMA = @schema_name 
    AND parentTable.TABLE_NAME = @table_name
    and parentTable.column_key = 'PRI';

select "<?php"

union all

select "	require_once('JsonDataObject.php');"

union all

select concat("Class ",@classname," extends JsonDataObject")

union all 

select "{" 

union all

/*primary key col*/
SELECT concat("	public $",parentTable.COLUMN_NAME,";")
FROM INFORMATION_SCHEMA.COLUMNS as parentTable
WHERE parentTable.TABLE_SCHEMA = @schema_name 
    AND parentTable.TABLE_NAME = @table_name
    and parentTable.column_key = 'PRI'
   
union all

/*key columns for objects below*/
SELECT concat("	public $",parentTable.COLUMN_NAME,";")
FROM INFORMATION_SCHEMA.COLUMNS as parentTable
WHERE parentTable.TABLE_SCHEMA = @schema_name  
    AND parentTable.TABLE_NAME = @table_name
    and parentTable.column_key = 'MUL' 

union all

select concat("	/*single and nullable objects*/")

union all 

/*find singular and nullable child objects for keyed columns of parent table*/
SELECT distinct concat("	public $",childTable.REFERENCED_TABLE_NAME,";")
FROM INFORMATION_SCHEMA.COLUMNS parentTable
inner join INFORMATION_SCHEMA.KEY_COLUMN_USAGE childTable
	on childTable.REFERENCED_TABLE_NAME = parentTable.TABLE_NAME
    and childTable.REFERENCED_TABLE_SCHEMA = parentTable.TABLE_SCHEMA
WHERE parentTable.TABLE_SCHEMA = @schema_name 
    AND childTable.TABLE_NAME = @table_name

union all

select concat("	/*arrays of objects*/")

union all

/*find child collection objects of parent table - other tables keyed on parenty table primary key*/
SELECT distinct concat("	public $",childTable.TABLE_NAME,";")
FROM INFORMATION_SCHEMA.COLUMNS parentTable
inner join INFORMATION_SCHEMA.KEY_COLUMN_USAGE childTable
	on childTable.REFERENCED_TABLE_NAME = parentTable.TABLE_NAME
    and childTable.REFERENCED_TABLE_SCHEMA = parentTable.TABLE_SCHEMA
WHERE parentTable.TABLE_SCHEMA = @schema_name 
    AND childTable.REFERENCED_TABLE_NAME = @table_name

union all

select concat("	/*rest of unkeyed columns*/")

union all 

/*rest of unkeyed columns*/
SELECT concat("	public $",parentTable.COLUMN_NAME,";")
FROM INFORMATION_SCHEMA.COLUMNS as parentTable
WHERE parentTable.TABLE_SCHEMA = @schema_name  
    AND parentTable.TABLE_NAME = @table_name
    and parentTable.column_key = '' 

union all

select concat("  function __construct() {}")

union all

/*START LIST*/
select concat("	public function getAll(){")

union all 

select concat_ws('\n',
				"		$pdo;", 
				"		$stmt;",
				"		try {",
				"			$pdo = getPDO();",
				concat("			$stmt =  $pdo->prepare(\"select ",GROUP_CONCAT(COLUMN_NAME SEPARATOR ',')," from ", @table_name,";\");")
)
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = @schema_name 
    AND TABLE_NAME = @table_name

union all

select "			$stmt->execute();"

union all

 select concat_ws('\n',"			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);",
			"			return $result;",
			"		}catch(PDOException $pdoe){",
			"			throw new Exception($pdoe->getMessage());",
			"		}catch(Exception $e){",
			"			throw new Exception($e->getMessage());",
			"		}",
			"	}")
/*END LIST*/

union all

/*START GET*/
select concat("	public function get($", @keyname, "){")

union all 

select concat_ws('\n',
				"		$pdo;", 
				"		$stmt;",
				"		try {",
				"			$pdo = getPDO();",
				concat("			$stmt =  $pdo->prepare(\"select ",GROUP_CONCAT(COLUMN_NAME SEPARATOR ',')," from ", @table_name," where ", @keyname, " = :", @keyname,";\");")
)
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = @schema_name 
    AND TABLE_NAME = @table_name

union all

select concat("			$stmt->bindParam(':",@keyname,"',$", @keyname, ", PDO::PARAM_INT);")

union all 

select "			$stmt->execute();"

union all

select concat("			$", @classname," = new ", @classname, ";")

union all

select concat("			if($", @keyname," > 0){")

union all

select concat("				$", @classname," = $stmt->fetchObject('",@classname,"');")

union all

select concat("				/*	single and nullable objects*/")

union all 

/*find singular and nullable child objects for keyed columns of parent table*/
SELECT distinct concat_ws('\n',	
							concat("				$",childTable.REFERENCED_TABLE_NAME," = new ", CONCAT(UCASE(LEFT(childTable.REFERENCED_TABLE_NAME, 1)), SUBSTRING(childTable.REFERENCED_TABLE_NAME, 2)),"();"),
							concat("				$",@classname,"->",childTable.REFERENCED_TABLE_NAME," =  $", childTable.REFERENCED_TABLE_NAME, "->get($",@classname,"->",childTable.REFERENCED_TABLE_NAME,"Id);")
							)
FROM INFORMATION_SCHEMA.COLUMNS parentTable
inner join INFORMATION_SCHEMA.KEY_COLUMN_USAGE childTable
	on childTable.REFERENCED_TABLE_NAME = parentTable.TABLE_NAME
    and childTable.REFERENCED_TABLE_SCHEMA = parentTable.TABLE_SCHEMA
WHERE parentTable.TABLE_SCHEMA = @schema_name 
    AND childTable.TABLE_NAME = @table_name

union all

select concat("				/*arrays of objects*/")

union all

/*find child collection objects of parent table - other tables keyed on parenty table primary key*/
SELECT distinct concat_ws('\n',	
							concat("				$",childTable.TABLE_NAME," = new ", CONCAT(UCASE(LEFT(childTable.TABLE_NAME, 1)), SUBSTRING(childTable.TABLE_NAME, 2)),"();"),
							concat("				$",@classname,"->",childTable.TABLE_NAME," =  $", childTable.TABLE_NAME, "->getBy",@classname,"($",@classname,"->$", @keyname, ");")
							)
FROM INFORMATION_SCHEMA.COLUMNS parentTable
inner join INFORMATION_SCHEMA.KEY_COLUMN_USAGE childTable
	on childTable.REFERENCED_TABLE_NAME = parentTable.TABLE_NAME
    and childTable.REFERENCED_TABLE_SCHEMA = parentTable.TABLE_SCHEMA
WHERE parentTable.TABLE_SCHEMA = @schema_name 
    AND childTable.REFERENCED_TABLE_NAME = @table_name

union all

select "			}"/*end if*/

union all 

select concat_ws('\n',
					concat("			return $",@classname, ";"),
			"		}catch(PDOException $pdoe){",
			"			throw new Exception($pdoe->getMessage());",
			"		}catch(Exception $e){",
			"			throw new Exception($e->getMessage());",
			"		}",
			"	}")
/*END GET*/

union all

/*START SAVE*/
select concat("	public function save(){")

union all 

select concat_ws('\n',
				"		$pdo;", 
				"		$stmt;",
				" ",
				"		try {",
				concat("			if($this->",@keyname, " > 0){"),
						"					$pdo = getPDO();",
				concat("					$stmt =  $pdo->prepare(\"update ",@table_name, " set")
				)

union all

SELECT concat_ws('\n',
				concat("											", COLUMN_NAME, " = :", COLUMN_NAME,","))
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = @schema_name 
    AND TABLE_NAME = @table_name
	and column_name != @keyname

union all

select concat_ws('\n', 
				concat(" 											where ", @keyname, " = :",@keyname,";\");"),
				concat("					$stmt->bindParam(':",@keyname,"', $this->", @keyname, ", PDO::PARAM_INT);")
				)
 
union all 


SELECT concat_ws('\n',
				case is_nullable
					when 'no'
					then 
						concat("					$stmt->bindParam(':", COLUMN_NAME, "',$this->", COLUMN_NAME,", ", 
													case data_type 
														when 'tinyint' then "PDO::PARAM_INT" 
														when 'bigint' then "PDO::PARAM_INT" 
														when 'mediumint' then "PDO::PARAM_INT" 
														when 'int' then "PDO::PARAM_INT" 
														when 'smallint' then "PDO::PARAM_INT" 
														when 'decimal' then "PDO::PARAM_INT" 
														when 'varchar' then "PDO::PARAM_STR"
														when 'date' then "PDO::PARAM_STR"
														else data_type 
														end,");")
				else
						concat("					if(is_null($this->", COLUMN_NAME, ")){ \n",
								"						$stmt->bindValue(':", COLUMN_NAME, "',NULL, PDO::PARAM_INT);\n",
								"					} else {\n",
                                "						$stmt->bindParam(':", COLUMN_NAME, "',$this->", COLUMN_NAME,", ", 
														case data_type 
															when 'tinyint' then "PDO::PARAM_INT" 
															when 'bigint' then "PDO::PARAM_INT" 
															when 'mediumint' then "PDO::PARAM_INT" 
															when 'int' then "PDO::PARAM_INT" 
															when 'smallint' then "PDO::PARAM_INT" 
															when 'decimal' then "PDO::PARAM_INT" 
															when 'varchar' then "PDO::PARAM_STR"
															when 'date' then "PDO::PARAM_STR"
															else data_type 
														end,");\n",
								"					}\n")
				end
				)
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = @schema_name 
    AND TABLE_NAME = @table_name
	and column_name != @keyname

union all 

select "					$stmt->execute();"

union all

select "			}else{"

union all

select "					$pdo = getPDO();"

union all

SELECT concat(
				"				$stmt =  $pdo->prepare(\"insert into ", 
				@table_name,"(",GROUP_CONCAT(COLUMN_NAME SEPARATOR ','),
				")values(",
				GROUP_CONCAT(":", COLUMN_NAME SEPARATOR ','),
				");\");"
			)
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = @schema_name 
    AND TABLE_NAME = @table_name
	and COLUMN_NAME not like @keyname



union all 

SELECT concat_ws('\n',
				case is_nullable
				when 'no'
					then 
						concat("					$stmt->bindParam(':", COLUMN_NAME, "',$this->", COLUMN_NAME,", ", 
													case data_type 
														when 'tinyint' then "PDO::PARAM_INT" 
														when 'bigint' then "PDO::PARAM_INT" 
														when 'mediumint' then "PDO::PARAM_INT" 
														when 'int' then "PDO::PARAM_INT" 
														when 'smallint' then "PDO::PARAM_INT" 
														when 'decimal' then "PDO::PARAM_INT" 
														when 'varchar' then "PDO::PARAM_STR"
														when 'date' then "PDO::PARAM_STR"
														else data_type 
														end,");")
				else
						concat("					if(is_null($this->", COLUMN_NAME, ")){ \n",
								"						$stmt->bindValue(':", COLUMN_NAME, "',NULL, PDO::PARAM_INT);\n",
								"					} else {\n",
                                "						$stmt->bindParam(':", COLUMN_NAME, "',$this->", COLUMN_NAME,", ", 
														case data_type 
															when 'tinyint' then "PDO::PARAM_INT" 
															when 'bigint' then "PDO::PARAM_INT" 
															when 'mediumint' then "PDO::PARAM_INT" 
															when 'int' then "PDO::PARAM_INT" 
															when 'smallint' then "PDO::PARAM_INT" 
															when 'decimal' then "PDO::PARAM_INT" 
															when 'varchar' then "PDO::PARAM_STR"
															when 'date' then "PDO::PARAM_STR"
															else data_type 
														end,");\n",
								"					}\n")
				end
				)
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = @schema_name 
    AND TABLE_NAME = @table_name
	and COLUMN_NAME not like @keyname

union all 

select "				$stmt->execute();"

union all 

select concat("				$this->",@keyname," = $pdo->lastInsertId();")
 
union all 

select "			}" /*end else*/

union all 

select concat_ws('\n',
					"			if($stmt->rowCount() > 0){",
					concat("				return $this->get($this->",@keyname,");"),
					"			}else{",
					concat("				throw new Exception(($this->",@keyname," > 0 ? \"Update\" : \"Insert\") . \"  failed.\");"),
					"			}"
				)

union all

 select concat_ws('\n',
			"		}catch(PDOException $pdoe){",
			"			throw new Exception($pdoe->getMessage());",
			"		}catch(Exception $e){",
			"			throw new Exception($e->getMessage());",
			"		}",
			"	}")
/*END SAVE	*/

union all

/*START DELETE*/
select concat("	public function delete($", @keyname, "){")

union all 

select concat_ws('\n',
				"		$pdo;", 
				"		$stmt;",
				"		try {",
				"			$pdo = getPDO();",
				concat("			$stmt =  $pdo->prepare(\"delete from ", @table_name," where ", @keyname, " = :", @keyname,";\");")
				)
 
union all 

select concat("			$stmt->bindParam(':",@keyname,"',$", @keyname, ", PDO::PARAM_INT);")

union all 

select "			$stmt->execute();"

union all

select concat_ws('\n',
					"			if($stmt->rowCount() == 0){",
					concat("				throw new Exception(\"Could not remove ", @classname,".\");"),
					"			}else{",
					concat("				Return \"",@classname, " removed successfully.\";"),
					"			}"
				)

union all 

 select concat_ws('\n',
					"		}catch(PDOException $pdoe){",
					"			throw new Exception($pdoe->getMessage());",
					"		}catch(Exception $e){",
					"			throw new Exception($e->getMessage());",
					"		}",
					"	}"
				)
/*END DELETE*/

union all

select "}" /*End Controller*/

union all

select "?>"


/* Output to file*/
INTO OUTFILE "H:\\Projects\\lister\\classes\\Sale.php";