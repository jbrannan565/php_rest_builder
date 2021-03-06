<?php
class DBClass {

	private $host = "%s";
	private $username = "%s";
	private $password = "%s";
	private $database = "%s";

	public $connection;

	// get the database connection
	public function getConnection(){
		$this->connection = null;

		try{
			$this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database, $this->username, $this->password);
			$this->connection->exec("set names utf8");
		}catch(PDOException $exception){
			echo "Error: " . $exception->getMessage();
		}

		return $this->connection;
	}
}
?>
