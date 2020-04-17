<?php

class Customer{

    //Customer Properties
    public $first_name;
    public $last_name;
    public $town_name;
    public $gender_id;
    private $is_deleted;

    //Database Connection & Table_name
    private $conn;
    private $table="customer";

    public function __construct($db){
        $this->conn = $db;
    }
 
    // METHOD --> Insert New Customer
    public function create(){
        //Insert Data Query
        $query = "INSERT INTO " . $this->table . " SET first_name=:first_name, last_name=:last_name, town_name=:town_name,  gender_id=:gender_id";
 
        $stmt = $this->conn->prepare($query);

        //Form Posted Values
        $this->first=htmlspecialchars(strip_tags($this->first_name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->town_name=htmlspecialchars(strip_tags($this->town_name));
        $this->gender_id=htmlspecialchars(strip_tags($this->gender_id));
 
        //Bind Values 
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":town_name", $this->town_name);
        $stmt->bindParam(":gender_id", $this->gender_id);

        //Execute Query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

    //METHOD--> Fetch all Customer Records where is_deleted=0
    public function read(){ 

        $sql = "SELECT customer.id,customer.first_name,customer.last_name,customer.town_name,

        Gender.gender_name,customer.is_deleted FROM customer RIGHT JOIN gender ON customer.gender_id = gender.id WHERE customer.is_deleted = ?" ;
        
        $this->is_deleted = 0;

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(1, $this->is_deleted);
        $stmt->execute();

        return $stmt;
    
    }

    // METHOD --> Fetch One Customer Records
    public function readOne(){
 
        $sql = "SELECT customer.id,customer.first_name,customer.last_name,customer.town_name,customer.gender_id,

        gender.gender_name FROM customer RIGHT JOIN gender ON customer.gender_id = gender.id WHERE customer.id = ? LIMIT 0,1";
     
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
        $this->first_name = $row['first_name'];
        $this->last_name = $row['last_name'];
        $this->town_name = $row['town_name'];
        $this->gender_id = $row['gender_id'];
        $this->gender_name = $row['gender_name'];
    }

    //METHOD --> Update Customer Records
    public function update(){
        $sql = "UPDATE " . $this->table . " SET first_name = :first_name, last_name = :last_name, town_name = :town_name, gender_id  = :gender_id WHERE id = :id";
 
        $stmt = $this->conn->prepare($sql);
        $this->first_name=htmlspecialchars(strip_tags($this->first_name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->town_name=htmlspecialchars(strip_tags($this->town_name));
        $this->gender_id=htmlspecialchars(strip_tags($this->gender_id));
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        //Bind Parameters
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name',$this->last_name);
        $stmt->bindParam(':town_name', $this->town_name);
        $stmt->bindParam(':gender_id', $this->gender_id);
    
        //Execute Query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    //METHOD--> Delete Customer by Update is_deleted to 1
    public function delete(){
        $sql = "UPDATE " . $this->table . " SET is_deleted = :is_deleted WHERE id = :id";
 
        $stmt = $this->conn->prepare($sql);

        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->is_deleted=1;
        //Bind Parameters
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':is_deleted', $this->is_deleted);
       
        //Execute Query
        if($stmt->execute()){
            return true;
        }
    
        return false;

    }

}


?>