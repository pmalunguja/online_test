<?php
  session_start();

  include_once 'db_conn.php';
  include_once 'gender_class.php';
  include_once 'customer_class.php';

  $database=new Db();
  $connection=$database->connect();

  $gender = new Gender($connection);
  $gender->read();
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
    <!-- Delete Modal -->
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Customer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="customer_delete.php" method="POST">
            <div class="modal-body">
                <input type="hidden" name="delete_id" id="delete_id">
                Do you want to delete ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">NO</button>
                <button type="submit" class="btn btn-success" name="delete">Yes, Delete</button>
            </div>
        </form>
        </div>
    </div>
    </div>

    <!-- Submission Modal -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                    <?php 
                        if(isset($_SESSION['message'])) 
                        echo $_SESSION['message'];
                    ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn-block" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>    
   
    
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
        <a class="navbar-brand" href="#"><h4>Ongeza Test<h4></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="btn btn-sm btn-success" href="customer_create.php"><i class="fas fa-user-plus"></i> Register Customers</a>
                </li>
            </ul>

        </div>
        </div>
    </nav>

    <!-- Customer Table --> 
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="text-center"><i class="fas fa-users-cog"></i> Customer Management</h3>
                <table class="table table-bordered dtable-hover">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Town Name</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        $customer= new Customer($connection);
                        $result = $customer->read();

                        while ($customer_row = $result->fetch(PDO::FETCH_ASSOC)){
                            extract($customer_row);
                    ?>  
                        <tr>
                           
                            <td><?php echo $id; ?></td>
                            <td><?php echo $first_name; ?></td>
                            <td><?php echo $last_name; ?></td>
                            <td><?php echo $town_name; ?></td>
                            <td><?php echo $gender_name; ?></td>
                            <td>
                            
                            <a class="btn btn-sm btn-primary" href="customer_update.php?id=<?php echo $id ?>"><i class="fas fa-edit"></i> Update</a>
                            <a class="btn btn-sm btn-danger delete-btn" name="delete" href="#"><i class="fas fa-trash-alt"></i> Delete</a>
            
                            </td>
        
                        </tr>  
                         
                    <?php
                        }
                    ?>
                       
                    </tbody>
                </table>     
            </div>
        </div>
    </div>

    <!-- Delete Modal Script -->                     
    <script>
        $(document).ready( function (){
            $('.delete-btn').on('click', function(){
                $('#confirm-delete').modal('show');

                    $tr = $(this).closest('tr');

                    var data = $tr.children("td").map(function() {
                        return $(this).text();
                    }).get();

                    console.log(data);
                    $('#delete_id').val(data[0]);
            });
        });
    </script>

    <!-- Message Modal Script -->
    <?php
        if(isset($_SESSION['message'])){
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#myModal').modal('show');
        });
    </script>
    <?php
        unset($_SESSION['message']);
        }
        
    ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>