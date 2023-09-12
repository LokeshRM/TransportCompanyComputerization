<?php
    $connection= mysqli_connect("localhost:3306","root","","tcc");

    session_start();
    $msg= "" ;     

    if(isset($_POST['submit'])){
        $lpname=$_POST['lpname'];
        $brname=$_POST['brname'];
        $resi=false;
        $t = time();
        $insert_query="INSERT INTO `trucks`(`id`, `license_plate`,`status`,`branch_office_id`,`ideal`,`time`) VALUES ('','$lpname',1,$brname,0,$t)";
        
        $resi= mysqli_query($connection,$insert_query);
            
        if($resi==true){
            $msg= "<script language='javascript'>
                                       swal(
                                            'Success!',
                                            'Added!',
                                            'success'
                                            );
				          </script>";
        }
        else{
            die('unsuccessful' .mysqli_error($connection));
        }
    }

    $sql= "SELECT * FROM `branch_offices`";
    $brdet=mysqli_query($connection,$sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List of Drivers</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="animate.css">
    <link rel="stylesheet" href="style.css">
    
</head> 

<body  > 
  
   <div id="myDiv">
  
   <?php include 'navbar_admin.php'; ?>
   <br><br><br>
         <div class="row">
       
        <div class="page-header">
            <h1 style="text-align: center;">Order Truck</h1>
            <?php echo $msg; ?>
        </div> 
       <div class="col-md-3">
         
       </div>
        <div class="col-md-6 animated bounceIn"> 
                <br>
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" >
                
                <div class="input-group">
                  <span class="input-group-addon"><b>License</b></span>
                  <input id="drname" type="text" class="form-control" name="lpname" placeholder="License-plate">
                </div>
                <br>
                <div class="input-group">
                <span class="input-group-addon"><b>Select Branch</b></span>
                    <select class="form-control" name="brname">
                        <?php
                            while ($row = mysqli_fetch_array($brdet)){
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
                  <button type="submit" name="submit" class="btn btn-success">Order</button>
                  
                </div>
              </form>   
        </div>  
        <div class="col-md-3"></div>
         
     </div>
          
      </div>  
       
   </div>
    </div> 
    
 <script src="https://unpkg.com/scrollreveal/dist/scrollreveal.min.js"></script>
  
  
  <script>
        window.sr = ScrollReveal();
        sr.reveal('.foo', { duration: 800 });
        sr.reveal('.foo1', { duration: 800,origin: 'top'});
    </script>
       

   
    
</body>
</html>