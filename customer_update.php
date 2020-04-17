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

    //GET-->ID of Customer
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
    $customer->id = $id;

    $customer->readOne();

    if(isset($_POST['update'])){
    
        //Customer property values
        $customer->first_name = $_POST['fname'];
        $customer->last_name = $_POST['lname'];
        $customer->town_name = $_POST['tname'];
        $customer->gender_id = $_POST['gender_id'];
    
        //Update-->Customer Records
        if($customer->update()){
            $message="Successfully, Updated Customer Records";
			$_SESSION['message']=$message;
            header("location:index.php");
        }
        else{
            $message="Successfully, Updated Customer Records";
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
        <a class="navbar-brand" href="#">Ongeza Test</a>
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

    <!-- Update Form -->
    <main class="my-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                            <h4 class="text-center"><i class="fas fa-user-plus"></i> Update Customer</h4>
                            </div>
                            <div class="card-body">
                                <form onsubmit="return validate();" name="customerForm"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post" id="customer_form">
                                    <div class="form-group row">
                                        <label for="first_name" class="col-md-4 col-form-label text-md-right">First Name</label>
                                        <div class="col-md-6">
                                            <input type="text" id="fname" class="form-control" name="fname" value="<?php echo $customer->first_name; ?>" required>
                                            <div id="fname_err" style="font-size:14px;color:red;"></div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="last_name" class="col-md-4 col-form-label text-md-right">Last Name</label>
                                        <div class="col-md-6">
                                            <input type="text" id="lname" class="form-control" name="lname" value="<?php echo $customer->last_name; ?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="town-name" class="col-md-4 col-form-label text-md-right">Town Name</label>
                                        <div class="col-md-6">
                                            <input type="text" id="tname" class="form-control" name="tname"  value="<?php echo $customer->town_name; ?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="gender" class="col-md-4 col-form-label text-md-right">Gender</label>
                                        <div class="col-md-6">
                                            <select class="form-control" id="gender_id" name="gender_id" class="form-control">
                                                <option value="<?php echo $customer->gender_id; ?>"> <?php echo $customer->gender_name; ?></option>
                                                <?php
                                                    //Dislay customer gender
                                                    $gender = new Gender($connection);
                                                    $result = $gender->read();

                                                    while ($gender_row = $result->fetch(PDO::FETCH_ASSOC)){
                                                        extract($gender_row);
                                                        if($id==$customer->gender_id){
                                                            continue;
                                                        }else{
                                                ?>
                                                <option value="<?php echo $id; ?>"><?php echo $gender_name;?></option>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </select>
                                            <div id="gender_err" style="font-size:14px;color:red;"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 offset-md-4"> 
                                        <button type="submit" name="update" class="btn btn-primary">
                                        <i class="fas fa-check-square"></i>  Update
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