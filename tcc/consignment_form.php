<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    $connection= mysqli_connect('localhost:3306','root','','tcc');


    $username= $_SESSION['username'];
    // echo $username;

    $sql= "SELECT * FROM `branch_offices`";
    $brdet=mysqli_query($connection,$sql);
    $brdet1=mysqli_query($connection,$sql);
    
    $query= "SELECT  `first_name`, `last_name`, `email` FROM `user` WHERE username='$username'";
    $result= mysqli_query($connection,$query);
    
    $row= mysqli_fetch_assoc($result);
    // $name= $row['first_name']." ". $row['last_name'];
    // echo $name;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
     <link rel="stylesheet" href="css/wickedpicker.min.css">
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
     <link rel="stylesheet" href="sweetalert2/sweetalert2.css">
    <script src="sweetalert2/sweetalert2.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="js/wickedpicker.min.js"></script>
    <link rel="stylesheet" href="animate.css">
    <link rel="stylesheet" href="style.css">
    
    
</head>
<style>
    .navbar-fixed-top.scrolled {
   background-color: ghostwhite;
  transition: background-color 200ms linear;
}    
</style>

<body>
    <?php include 'navbar.php'; ?>
    <br>
    <div class="container">
        <div class="row">
            <div class="page-header">
                <h1 style="text-align:center;">Consignment Details</h1>
                 <?php //echo $msg; ?>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form class="animated bounce" action="addconsignment.php" method="post">
                   
                    <div class="input-group">
                      <span class="input-group-addon"><b>Volume</b></span>
                      <input id="volume" placeholder="in cubic meters" type="number" class="form-control" name="volume" value="" min="1" max="500"  required>
                    </div>
                    
                    <br>

                    <div class="input-group">
                      <span class="input-group-addon"><b>Sender Name</b></span>
                      <input id="sender_name" type="text" class="form-control" name="sname" placeholder="Sender name" required>
                    </div>
                    <br>

                    <div class="input-group">
                      <span class="input-group-addon"><b>Sender Address</b></span>
                      <input id="sender_address" type="text" class="form-control" name="sAdd" placeholder="Sender Address" required>
                    </div>
                    <br>

                    <div class="input-group">
                      <span class="input-group-addon"><b>Receiver Name</b></span>
                      <input id="receiver_name" type="text" class="form-control" name="rname" placeholder="Receiver name" required>
                    </div>
                    <br>

                    <div class="input-group">
                      <span class="input-group-addon"><b>Receiver Address</b></span>
                      <input id="receiver_address" type="text" class="form-control" name="rAdd" placeholder="Receiver Address" required>
                    </div>
                    <br>

                    <div class="input-group">
                      <span class="input-group-addon"><b>origin city</b></span>
                      <select class="form-control" name="orcity">
                        <?php
                            while ($row = mysqli_fetch_array($brdet1)){
                        ?>
                            <option value="<?php echo $row["id"];
                            ?>">
                                <?php echo $row["city"];
                                ?>
                            </option>
                        <?php
                            }
                        ?>
                    </select>
                    </div>
                    <br>

                    <div class="input-group">
                      <span class="input-group-addon"><b>Destination city</b></span>
                      <select class="form-control" name="drcity">
                        <?php
                            while ($rowi = mysqli_fetch_array($brdet)){
                        ?>
                            <option value="<?php echo $rowi["id"];
                            ?>">
                                <?php echo $rowi["city"];
                                ?>
                            </option>
                        <?php
                            }
                        ?>
                    </select>
                    </div>
                    <br>
                    <div class="input-group">
                      <span class="input-group-addon"><b>Distance</b></span>
                      <input id="distance" placeholder="in kms" type="number" class="form-control" name="distance" value=""  required>
                    </div>
                    <br>
                    <div class="input-group">
                  <input type="submit" name="submit" class="btn btn-success">
                  
                </div>
                     
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
    
<script>
    $(function () {
  $(document).scroll(function () {
    var $nav = $(".navbar-fixed-top");
    $a= $(".navbar-fixed-top");
    $nav.toggleClass('scrolled', $(this).scrollTop() > $a.height());
  });
}); 
    
</script>  
</body>
</html>