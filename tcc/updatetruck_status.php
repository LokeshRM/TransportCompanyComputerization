<?php
    $connection= mysqli_connect("localhost:3306","root","","tcc");

    session_start();
    $msg= "" ;     

    if(isset($_POST['submit'])){
        $truck_id=$_POST['truckId'];
        $resi=false;

        $get_id = "SELECT DISTINCT consignments.destination_city as newId,consignments.origin_city as old_Id  FROM `consignments`,`trucks` WHERE `trucks`.`id`=`consignments`.`truck_id`AND `consignments`.`status` = 2 AND `trucks`.`id` = $truck_id";

        $br_id = mysqli_query($connection,$get_id);
        $branch_id = mysqli_fetch_assoc($br_id);
        $b_id = $branch_id["newId"];
        $o_id = $branch_id["old_Id"];

        $t = time();
        $update_truck="UPDATE `trucks` SET `status` = 1, `branch_office_id` = $b_id,`time` = $t  WHERE `trucks`.`id` = $truck_id";
        $update_consigns="UPDATE `consignments` SET `status` = 3 WHERE `consignments`.`truck_id`=$truck_id AND `consignments`.`status` =2";
        
        $resi= mysqli_query($connection,$update_truck);
        $resi= mysqli_query($connection,$update_consigns);

        $update_truck="INSERT INTO `truckhistory` (`id`, `origin_city`, `destination_city`, `truck_id`) VALUES ('', $o_id, $b_id, $truck_id)";
        $resi= mysqli_query($connection,$update_truck);

        $waiting_sql = "SELECT SUM(volume) > 500 as vol, destination_city as destin FROM `consignments` WHERE `consignments`.`origin_city` = $b_id AND `consignments`.`status` = 1 GROUP BY destination_city";
        $wait = mysqli_query($connection,$waiting_sql);


        while($row=mysqli_fetch_assoc($wait)){
            $stat = $row["vol"];
            $d_city = $row["destin"];
            if($stat > 0){
                $wait_sql = "SELECT * FROM `consignments` WHERE `consignments`.`origin_city` = $b_id AND `consignments`.`status` = 1 AND `consignments`.`destination_city`=$d_city";
                $wait1 = mysqli_query($connection,$wait_sql);
                $sum = 0;
                while($rowi=mysqli_fetch_assoc($wait1)){
                        $sum = $sum + $rowi["volume"];
                        $id = $rowi["id"];
                        $origin = $rowi["origin_city"];
                        if($sum >= 500){
                            $t = time();
                            $sql1 = "UPDATE `consignments` SET `status` = 2,`truck_id` =$truck_id, `end` = $t WHERE `consignments`.`id`=$id";
                            $sql2 = "UPDATE `trucks` SET `status` = 2 WHERE `trucks`.`id` = $truck_id";
                            $res = mysqli_query($connection,$sql1);
                            $res = mysqli_query($connection,$sql2);
                            break;
                        }else{
                            $t = time();
                            $sql1 = "UPDATE `consignments` SET `status` = 2,`truck_id` =$truck_id, `end` = $t  WHERE `consignments`.`id`=$id";
                            $res = mysqli_query($connection,$sql1);
                        }
                }
                break;
            }
        }

        
        
        if($resi==true){
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

    }

    $sql= "SELECT DISTINCT  trucks.id as id,trucks.license_plate as license, trucks.status as status,b1.city as origin,b2.city as destination FROM `consignments`,`trucks`,`branch_offices` AS `b1`,`branch_offices` AS `b2` WHERE `trucks`.`id`=`consignments`.`truck_id`AND `consignments`.`status` = 2 AND `consignments`.`origin_city` = `b1`.`id` AND `consignments`.`destination_city` = `b2`.`id`";
    $res=mysqli_query($connection,$sql);
    $res1 = mysqli_query($connection,$sql);
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
  
   <?php include 'navbar.php'; ?>
   <br><br><br>
   <div class="container">
      <?php
        if(mysqli_num_rows($res)>0){ ?>
    
      <div class="container">
         <div class="row">
             <div class="col-md-3"></div>
             <div class="col-md-6 foo">
                 <div class="page-header">
                    <h1 class="animated bounceIn" style="text-align: center;">Trucks</h1>      
                  </div> 
                  <table class="table">
                    <thead>
                        <th>Truck id</th>
                        <th>Registration No</th>
                        <th>Status</th>
                        <th>Origin branch</th>
                        <th>Destination branch</th>
                    </thead>  

                    <?php while($row=mysqli_fetch_assoc($res)) {  ?>
                    <tbody>
                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo $row["license"] ?></td>
                            <td><?php echo $row["status"] ?></td>
                            <td><?php echo $row["origin"] ?></td>
                            <td><?php echo $row["destination"] ?></td>
                        </tr>
                    </tbody> 
                <?php } }?>
                
                </table>
             </div>
             <div class="col-md-3"></div>
         </div>

         <div class="row">
       
        <div class="page-header">
            <h3 style="text-align: center;">Update Truck Status</h3>
            <?php echo $msg; ?>
        </div> 
       <div class="col-md-3">
         
       </div>
        <div class="col-md-6 animated bounceIn"> 
                <br>
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" >
                <div class="input-group">
                <span class="input-group-addon"><b>Select Truck</b></span>
                    <select class="form-control" name="truckId">
                        <?php
                            while ($row = mysqli_fetch_array($res1)){
                        ?>
                            <option value="<?php echo $row["id"];
                            ?>">
                                <?php echo $row["license"];
                                ?>
                            </option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                
                <br> 
                
                <div class="input-group">
                  <button type="submit" name="submit" class="btn btn-success">update</button>
                  
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