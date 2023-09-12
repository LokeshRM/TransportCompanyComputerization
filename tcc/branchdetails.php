<?php
    $connection= mysqli_connect("localhost:3306","root","","tcc");

    session_start();

    $msg= "" ;     


    if(isset($_POST['submit'])){
        $brname=$_POST['brname'];
       
        $resi=false;
        $insert_query="INSERT INTO `branch_offices`(`id`, `city`) VALUES ('','$brname')";
        
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
    $res=mysqli_query($connection,$sql);
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
             <div class="col-md-3"></div>
             <div class="col-md-6 foo">
                 <div class="page-header">
                    <h1 class="animated bounceIn" style="text-align: center;">Branchs List</h1>      
                  </div> 
                  <table class="table">
                    <thead>
                        <th>branch id</th>
                        <th>branch</th>
                    </thead>  

                    <?php while($row=mysqli_fetch_assoc($res)) {  ?>
                    <tbody>
                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo $row["city"] ?></td>
                        </tr>
                    </tbody> 
                <?php } }?>
                </table>
             </div>
             <div class="col-md-3"></div>
         </div>

        <div class="row">
       
        <div class="page-header">
            <h1 style="text-align: center;">Add Branch</h1>
            <?php echo $msg; ?>
        </div> 
       <div class="col-md-3">
         
       </div>
        <div class="col-md-6 animated bounceIn"> 
                <br>
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" >
                
                <div class="input-group">
                  <span class="input-group-addon"><b>branch Name</b></span>
                  <input id="drname" type="text" class="form-control" name="brname" placeholder="Name">
                </div>
                <br> 
                
                 <br>
                
                 <div class="input-group">
                  <button type="submit" name="submit" class="btn btn-success">Add</button>
                  
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