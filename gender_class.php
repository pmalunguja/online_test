<?php
class Gender{
 
    //Database Property
    private $conn;
    
 
    //Gender Properties
    public $id;
    public $gender_name;
    
 
    public function __construct($db){
        $this->conn = $db;
    }
 
    //Method-->Fetch gender records
    public function read(){
        //select all data
        $query = "SELECT * FROM gender";
 
        $result = $this->conn->prepare( $query );
        $result->execute();
 
        return $result;
    }
 
}
?>