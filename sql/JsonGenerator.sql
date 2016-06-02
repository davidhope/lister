use tlg_v2;

set @classname = "zoningtype";
set @table_name = concat(lower(@classname));
set @schema_name = "tlg_v2";

/*primary key col*/
SELECT concat("""",parentTable.COLUMN_NAME,""":",ceiling(rand()*100))
FROM INFORMATION_SCHEMA.COLUMNS as parentTable
WHERE parentTable.TABLE_SCHEMA = @schema_name 
    AND parentTable.TABLE_NAME = @table_name
    and parentTable.column_key = 'PRI'
   
union all
 
/*find singular and nullable child objects for keyed columns of parent table*/
SELECT distinct concat("""",parentTable.TABLE_NAME,""":{}")
FROM INFORMATION_SCHEMA.COLUMNS parentTable
inner join INFORMATION_SCHEMA.KEY_COLUMN_USAGE childTable
	on childTable.REFERENCED_TABLE_NAME = parentTable.TABLE_NAME
    and childTable.REFERENCED_TABLE_SCHEMA = parentTable.TABLE_SCHEMA
WHERE parentTable.TABLE_SCHEMA = @schema_name 
    AND childTable.TABLE_NAME = @table_name /*keyed columns in @table_name*/

union all

/*find child collection objects of parent table - other tables keyed on parenty table primary key*/
SELECT distinct concat("""",childTable.TABLE_NAME,""":[]")
FROM INFORMATION_SCHEMA.COLUMNS parentTable
inner join INFORMATION_SCHEMA.KEY_COLUMN_USAGE childTable
	on childTable.REFERENCED_TABLE_NAME = parentTable.TABLE_NAME
    and childTable.REFERENCED_TABLE_SCHEMA = parentTable.TABLE_SCHEMA
WHERE parentTable.TABLE_SCHEMA = @schema_name 
    AND childTable.REFERENCED_TABLE_NAME = @table_name /*tables referencing @table_name*/
    and 0=1

union all 

/*rest of unkeyed columns*/
SELECT concat("""",parentTable.COLUMN_NAME,""":",
													case data_type 
														when 'tinyint' then ceiling(rand()*100)
														when 'bigint' then ceiling(rand()*100) 
														when 'mediumint' then ceiling(rand()*100)
														when 'int' then ceiling(rand()*100)
														when 'smallint' then ceiling(rand()*100)
														when 'decimal' then ceiling(rand()*100)
														when 'varchar' then """"""
														when 'date' then now()
														when 'datetime' then now()
														else data_type 
													end)
FROM INFORMATION_SCHEMA.COLUMNS as parentTable
WHERE parentTable.TABLE_SCHEMA = @schema_name  
    AND parentTable.TABLE_NAME = @table_name
    and parentTable.column_key = '';