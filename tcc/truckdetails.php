<?php
    $connection= mysqli_connect("localhost:3306","root","","tcc");

    session_start();

    $sql= "SELECT * FROM `branch_offices`";
    $brdet=mysqli_query($connection,$sql);

    $sql= "SELECT DISTINCT  trucks.id as id,trucks.license_plate as license, trucks.status as status,b1.city as origin,b2.city as destination FROM `consignments`,`trucks`,`branch_offices` AS `b1`,`branch_offices` AS `b2` WHERE `trucks`.`id`=`consignments`.`truck_id`AND `consignments`.`status` = 2 AND `consignments`.`origin_city` = `b1`.`id` AND `consignments`.`destination_city` = `b2`.`id`";
    $res=mysqli_query($connection,$sql);
    $sql = "SELECT trucks.id as id,trucks.license_plate as license,trucks.status as status,branch_offices.city as city FROM `trucks` , `branch_offices` WHERE trucks.branch_office_id=branch_offices.id AND trucks.status=1";
    $resp=mysqli_query($connection,$sql); 
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
      
    
      <div class="container">
         <div class="row">
         <div class="page-header">
                    <h1 class="animated bounceIn" style="text-align: center;">Truck Status</h1>      
                  </div> 
         <?php
        if(mysqli_num_rows($res)>0){ ?>
             <div class="col-md-3"></div>
             <div class="col-md-6 foo">
                  <table class="table">
                    <thead>
                        <th>Truck id</th>
                        <th>Registration No</th>
                        <th>Status</th>
                        <th>Origin Branch</th>
                        <th>Destination Branch</th>
                    </thead>  

                    <?php while($row=mysqli_fetch_assoc($res)) {  ?>
                    <tbody>
                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td><a href="truckHistory.php?truckid=<?php echo $row["id"]; ?>"> <?php echo $row["license"] ?></a></td>
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
         <?php
        if(mysqli_num_rows($resp)>0){ ?>
             <div class="col-md-3"></div>
             <div class="col-md-6 foo">
                  <table class="table">
                    <thead>
                        <th>Truck id</th>
                        <th>Registration No</th>
                        <th>Status</th>
                        <th>Branch</th>
                    </thead>  

                    <?php while($row=mysqli_fetch_assoc($resp)) {  ?>
                    <tbody>
                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td><a href="truckHistory.php?truckid=<?php echo $row["id"]; ?>"> <?php echo $row["license"] ?></a></td>
                            <td><?php echo $row["status"] ?></td>
                            <td><?php echo $row["city"] ?></td>
                        </tr>
                    </tbody> 
                <?php } }?>
                </table>
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