<?php
    session_start();
    
    //Include-->DB Connection & Classes
    include_once 'db_conn.php';
    include_once 'gender_class.php';
    include_once 'customer_class.php';

    //Create Database Object
    $database=new Db();
    $connection=$database->connect();

    //Create Customer Object
    $customer = new Customer($connection);

    //Insert-->Customer Record
    if(isset($_POST['create'])){
    
        //Customer Property Values
        $customer->first_name = $_POST['fname'];
        $customer->last_name = $_POST['lname'];
        $customer->town_name = $_POST['tname'];
        $customer->gender_id = $_POST['gender_id'];
    
        //Insert Customer
        if($customer->create()){
            $message="Successfully, Registered a Customer";
			$_SESSION['message']=$message;
            header("location:index.php");
        }
        else{
            $message="ERROR!!, Unable to Register a Customer";
			$_SESSION['message']=$message;
            header("location:index.php");
        }
    }
?>


<!doctype html>
<html lang="en">
<head>
    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <title>Ongeza Test</title>

</head>
<body>
    <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
            <a class="navbar-brand" href="#"><h4>Ongeza Test</h4></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="btn btn-sm btn-success" href="index.php"><i class="fas fa-users"></i> View Customers</a>
                    </li>
                </ul>

            </div>
            </div>
        </nav>
  
    <!-- CUSTOMER FORM -->
        <main class="my-form">
            <div class="cotainer">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                <h4 class="text-center"><i class="fas fa-user-plus"></i> Customer Registration</h4>
                                </div>
                                <div class="card-body">
                                    <form onsubmit="return validate();" name="customerForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="customer_form">
                                        <div class="form-group row">
                                            <label for="first_name" class="col-md-4 col-form-label text-md-right">First Name</label>
                                            <div class="col-md-6">
                                                <input type="text" id="fname" class="form-control" name="fname" required>
                                                <div id="fname_err" style="font-size:14px;color:red;"></div>
                                            </div>
                                            
                                        </div>

                                        <div class="form-group row">
                                            <label for="last_name" class="col-md-4 col-form-label text-md-right">Last Name</label>
                                            <div class="col-md-6">
                                                <input type="text" id="lname" class="form-control" name="lname" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="town-name" class="col-md-4 col-form-label text-md-right">Town Name</label>
                                            <div class="col-md-6">
                                                <input type="text" id="tname" class="form-control" name="tname" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="gender" class="col-md-4 col-form-label text-md-right">Gender</label>
                                            <div class="col-md-6">
                                                <select class="form-control" id="gender_id" name="gender_id" class="form-control" required>
                                                    <option value="0" selected>--Select Gender--</option>
                                                    <?php
                                                        //Display Gender Object
                                                        $gender = new Gender($connection);
                                                        $result = $gender->read();

                                                        while ($gender_row = $result->fetch(PDO::FETCH_ASSOC)){
                                                            extract($gender_row);
                                                    ?>
                                                    <option value="<?php echo $id; ?>"><?php echo $gender_name;?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                                <div id="gender_err" style="font-size:14px;color:red;"></div>
                                            
                                            </div>
                                        </div>

                                        <div class="col-md-6 offset-md-4"> 
                                            <button type="submit" name='create' class="btn btn-primary">
                                            <i class="fas fa-check-square"></i> Register
                                            </button>
                                        </div>
                                    
                                    </form>
                            </div>
                            
                        </div>
                    </div>

                </div>
            </div>

        </main>
 

    <!--Validation Script-->
    <script>
        function validate() {
        
        var fname = document.getElementById('fname').value;
        var gender =  document.getElementById('gender_id');

        // Check if input is bigger than 3
        if (fname.length < 3){
            document.getElementById('fname_err').innerHTML="First name must be at least 3 characters";
            return false; 
        }
        if (fname.length >= 3){
            document.getElementById("fname_err").style.display = "none";
        }

        // Check if select is empty
        if (gender.value == 0){
            document.getElementById('gender_err').innerHTML="Please select gender";
            return false; 
        }

            return true;
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</body>
</html>