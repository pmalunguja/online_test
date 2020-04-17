<?php
    //Include-->DB Connection & Classes
    include_once 'db_conn.php';
    include_once 'customer_class.php';

    //Create Database Object
    $database=new Db();
    $connection=$database->connect();

    //Create Customer Object
    $customer = new Customer($connection);

    //Delete Customer
    if(isset($_POST['delete'])){
        $customer->id = $_POST['delete_id'];
        echo $customer->id;

        if($customer->delete()){
            $message="Customer Updated Successful";
            $_SESSION['message']=$message;
            header("location:index.php");
        }
        else{
            $message="ERROR!!, Unable to delete Customer";
            $_SESSION['message']=$message;
            header("location:index.php");
        }

    }
  
?>