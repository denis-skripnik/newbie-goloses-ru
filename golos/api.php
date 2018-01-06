<?php 
error_reporting(E_ALL) ;
ini_set('display_errors', 'On');

class APICall
{
	protected $ms;
	protected $count;
	
	function __construct()
	{
		$serverName = "sql.golos.cloud";
		$connectionOptions = array(
			"Database" => "DBGolos",
			"Uid" => "golos",
			"PWD" => "golos"
		);

		$this->ms = sqlsrv_connect( $serverName, $connectionOptions );
		if( $this->ms === false ) {
			if( ($errors = sqlsrv_errors() ) != null) {
			foreach( $errors as $error ) {
				echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
				echo "code: ".$error[ 'code']."<br />";
				echo "message: ".$error[ 'message']."<br />";
			}
    }
		}
	}
	
	function __destruct()
	{
		sqlsrv_close($this->ms);
	}
	
	public function query($params = array())
	{
		header('Access-Control-Allow-Origin: *');  
	}
}
?>