<?php
require_once('config.php');
if ( !class_exists( "dbConnection" ) ) {
	class dbConnection {
		var $dbConn;
		
		function dbConnection() {
				global $db_name, $db_user, $db_pass;
				$this->dbConn = mysql_connect('localhost', $db_user, $db_pass) or
				die("Could not connect: " . mysql_error());

			mysql_select_db($db_name, $this->dbConn) or
				die("Could not select DB: " . mysql_error());
		}
		
		function dbQuery( $query ) {
			$query_db_result = mysql_query($query, $this->dbConn) or
				die("Invalid query:\n<br>\n$query<br>\n" . mysql_error($this->dbConn));
			return $query_db_result;
		}
		
		function dbInsertID() {
			return mysql_insert_id( $this->dbConn );
		}
		
	}
}
?>
