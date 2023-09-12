<?php
    $connection= mysqli_connect("localhost:3306","root","","tcc");
    
    session_start();

    $truck_id= $_GET['truckid']; 

    $sql = "SELECT * FROM `trucks` WHERE id=$truck_id";
    $res= mysqli_query($connection,$sql);
    $rowi= mysqli_fetch_assoc($res);

    $sql= "SELECT truckhistory.id as id,b1.city as origin,b2.city as destination FROM `truckhistory`,`branch_offices` AS `b1`,`branch_offices` AS `b2` WHERE truck_id = $truck_id AND `truckhistory`.`origin_city` = `b1`.`id` AND `truckhistory`.`destination_city` = `b2`.`id` ORDER BY id
    "; 
    //echo $sql;
    $res= mysqli_query($connection,$sql);
    if($res==true){
        $msg= "<script language='javascript'>
                                  swal(
                                        'Success!',
                                        'Updated!',
                                        'success'
                                        );
              </script>";
    }
    else{
        die('unsuccessful' .mysqli_error($connection));
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>vehicle management system</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

</head>
<body>  
  
   <?php  include 'navbar_admin.php';?>
   <div class="container" style="margin-top: 20px; margin-bottom: 20px;">
	
   
</div>
       
        <div class="container">
          <div class="row"> 
            <br><br>
           <div class="col-sm-2">
           </div> 
           
           <div class="col-sm-8">
           <div class="fb-profile-text" id="h1" >
                    <h2><?php echo $rowi["license_plate"]; ?></h2>
            </div>
            <hr>
               <div data-spy="scroll" class="tabbable-panel">
                <div class="tabbable-line">
                  <ul class="nav nav-tabs ">
                    <li class="active">
                      <a href="#tab_default_1" data-toggle="tab">
                      Truck Usage</a>
                    </li>
                    
                    <!--
                    <li>
                      <a href="#tab_default_2" data-toggle="tab">
                     Bill </a>
                    </li>
                    -->
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="tab_default_1">
                    <?php
                    if(mysqli_num_rows($res)>0){ ?>
                    <table class="table">
                    <thead>
                        <th>Trip</th>                        
                        <th>Source</th>
                        <th>Destination</th>
                    </thead>  

                    <?php while($row=mysqli_fetch_assoc($res)) {  ?>
                    <tbody>
                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo $row["origin"] ?></td>
                            <td><?php echo $row["destination"] ?></td>
                        </tr>
                    </tbody> 
                <?php } }?>
                </table>

                    </div>
                    
                    <?php //if($_SESSION['username']!= null) {  ?>
                    
                    <!--
                    <div class="tab-pane" id="tab_default_2">
                      <div class="row">
                      <div class="col-sm-10">
                       <?php //include 'insertbill.php';?>
                          
                          <?php // } ?>
                      </div>
                      </div>
                    </div>  
                    -->
                            
                  </div>
                  
                   
                  
                
                  
                </div>
              </div>
           </div>
          </div>
        </div>
        
          <!-- /container fluid-->  
        <div class="container">
          <div class="col-sm-12"> 
              
          </div>
    </div>
    
</body>
</html>




