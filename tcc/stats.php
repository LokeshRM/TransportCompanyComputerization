<?php
    $connection= mysqli_connect("localhost:3306","root","","tcc");

    session_start();  


    $sql= "SELECT * FROM `branch_offices`";
    $brdet=mysqli_query($connection,$sql);

    $sql= "SELECT consignments.id as id,consignments.volume as vol,b1.city as origin,b2.city as destination, consignments.status as status,  `end`-`start` as wait FROM `consignments`,`branch_offices` AS `b1`,`branch_offices` AS `b2` WHERE `consignments`.`origin_city` = `b1`.`id` AND `consignments`.`destination_city` = `b2`.`id` AND `consignments`.`status` != 1";
    $res=mysqli_query($connection,$sql);

    $sql="SELECT  AVG(`end`-`start`) as avg FROM `consignments` WHERE `consignments`.`status` != 1";
    $result = mysqli_query($connection,$sql);
    $avg = mysqli_fetch_assoc($result);

    $sql="SELECT * FROM `trucks`";
    $truck = mysqli_query($connection,$sql);

    $sql="SELECT AVG(ideal) as avg FROM `trucks`";
    $result = mysqli_query($connection,$sql);
    $avg_truck = mysqli_fetch_assoc($result);

    // while($row=mysqli_fetch_assoc($res)){
    //     echo $row["trucks.id"]
    // }
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
   <div class="container">
      <?php
        if(mysqli_num_rows($res)>0){ ?>
    
      <div class="container">
         <div class="row">
             <div class="col-md-2"></div>
             <div class="col-md-8 foo">
                 <div class="page-header">
                    <h1 class="animated bounceIn" style="text-align: center;">Consignments</h1>      
                  </div> 
                  <table class="table">
                    <thead>
                        <th>Consignment id</th>
                        <th>Volume</th>
                        <th>Origin branch</th>
                        <th>Destination branch</th>
                        <th>Status</th>
                        <th>Waiting Time</th>
                    </thead>  

                    <?php while($row=mysqli_fetch_assoc($res)) {  ?>
                    <tbody>
                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo $row["vol"] ?></td>
                            <td><?php echo $row["origin"] ?></td>
                            <td><?php echo $row["destination"] ?></td>
                            <td><?php echo $row["status"] ?></td>
                            <td><?php echo $row["wait"] ?></td>
                        </tr>
                    </tbody> 
                <?php } }?>
                        <tbody>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Average Waiting Time</td>
                            <td><?php echo $avg["avg"]; ?></td>
                        </tbody>
                </table>
             </div>
             <div class="col-md-2"></div>
         </div>
         <br> <br> 
         <div class="row">
             <div class="col-md-2"></div>
             <div class="col-md-8 foo">
             <?php
        if(mysqli_num_rows($truck)>0){ ?>
                 <div class="page-header">
                    <h1 class="animated bounceIn" style="text-align: center;">Trucks</h1>      
                  </div> 
                  <table class="table">
                    <thead>
                        <th>Truck id</th>
                        <th>License</th>
                        <th>Ideal Time</th>
                    </thead>  

                    <?php while($row=mysqli_fetch_assoc($truck)) {  ?>
                    <tbody>
                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo $row["license_plate"] ?></td>
                            <td><?php echo $row["ideal"] ?></td>
                        </tr>
                    </tbody> 
                <?php } }?>
                        <tbody>
                            <td></td>
                            <td>Average Ideal Time</td>
                            <td><?php echo $avg_truck["avg"]; ?></td>
                        </tbody>
                </table>
             </div>
             <div class="col-md-2"></div>
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