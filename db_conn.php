<?php

class Db {

    //DATABASE PROPERTIES
	private $db_host = 'localhost';
	private $db_name = 'ongeza_test';
	private $db_user = 'root';
	private $db_pass = '';
	
	public $connect_db;

	//Method-->Database Connection 
	public function connect() {

        $this->connect_db = null;

        try{
            $this->connect_db = new PDO("mysql:host=" .$this->db_host. ";dbname=" . $this->db_name, $this->db_user, $this->db_pass);
        }catch(PDOException $exception){
            echo "There is some problem in connection: " . $exception->getMessage();
        }
		
		return $this->connect_db;
    }
    
    //Method-->Close Database Connection
    public function close_connection(){
        $this->connect_db=null;
    }

}
?>