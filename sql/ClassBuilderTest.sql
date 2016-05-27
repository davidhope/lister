use tlg_v2;

set @classname = "Listing";
set @table_name = concat(lower(@classname));
set @schema_name = "tlg_v2";
set @keyname = "mls"; /*concat(lcase(left(@classname,1)), substring(@classname,2,length(@classname) - 1),"Id");*/

/*primary key col*/
SELECT concat("public $",parentTable.COLUMN_NAME,";")
FROM INFORMATION_SCHEMA.COLUMNS as parentTable
WHERE parentTable.TABLE_SCHEMA = @schema_name 
    AND parentTable.TABLE_NAME = @table_name
    and parentTable.column_key = 'PRI'
   
union all
 
/*find singular and nullable child objects for keyed columns of parent table*/
SELECT distinct concat("public $",parentTable.TABLE_NAME,";")
FROM INFORMATION_SCHEMA.COLUMNS parentTable
inner join INFORMATION_SCHEMA.KEY_COLUMN_USAGE childTable
	on childTable.REFERENCED_TABLE_NAME = parentTable.TABLE_NAME
    and childTable.REFERENCED_TABLE_SCHEMA = parentTable.TABLE_SCHEMA
WHERE parentTable.TABLE_SCHEMA = @schema_name 
    AND childTable.TABLE_NAME = @table_name /*keyed columns in @table_name*/

union all

/*find child collection objects of parent table - other tables keyed on parenty table primary key*/
SELECT distinct concat("public $",childTable.TABLE_NAME,";")
FROM INFORMATION_SCHEMA.COLUMNS parentTable
inner join INFORMATION_SCHEMA.KEY_COLUMN_USAGE childTable
	on childTable.REFERENCED_TABLE_NAME = parentTable.TABLE_NAME
    and childTable.REFERENCED_TABLE_SCHEMA = parentTable.TABLE_SCHEMA
WHERE parentTable.TABLE_SCHEMA = @schema_name 
    AND childTable.REFERENCED_TABLE_NAME = @table_name /*tables referencing @table_name*/

union all 

/*rest of unkeyed columns*/
SELECT concat("	public $",parentTable.COLUMN_NAME,";")
FROM INFORMATION_SCHEMA.COLUMNS as parentTable
WHERE parentTable.TABLE_SCHEMA = @schema_name  
    AND parentTable.TABLE_NAME = @table_name
    and parentTable.column_key = '';