<?php
    $connection= mysqli_connect("localhost:3306","root","","tcc");

    session_start();

    $msg= "" ;     


    if(isset($_POST['submit'])){
        $id=$_POST['user_id'];
       
        $resi=false;
        $insert_query="UPDATE `user` SET `approve` = '1' WHERE `user`.`user_id` = $id";
        
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

    $sql= "SELECT * FROM `user` WHERE approve != 1";
    $res=mysqli_query($connection,$sql);
    $resi=mysqli_query($connection,$sql);
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
                    <h1 class="animated bounceIn" style="text-align: center;">Approval List</h1>      
                  </div> 
                  <table class="table">
                    <thead>
                        <th>User id</th>
                        <th>Name</th>
                        <th>E-mail</th>
                    </thead>  

                    <?php while($row=mysqli_fetch_assoc($res)) {  ?>
                    <tbody>
                        <tr>
                            <td><?php echo $row["user_id"]; ?></td>
                            <td><?php echo $row["first_name"] . ' ' . $row["last_name"];  ?></td>
                            <td><?php echo $row["email"]; ?></td>
                        </tr>
                    </tbody> 
                <?php } }?>
                </table>
             </div>
             <div class="col-md-3"></div>
         </div>

        <div class="row">
       
        <div class="page-header">
            <h1 style="text-align: center;">Approve Employees</h1>
            <?php echo $msg; ?>
        </div> 
       <div class="col-md-3">
         
       </div>
        <div class="col-md-6 animated bounceIn"> 
                <br>
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data" >
                
                <div class="input-group">
                <span class="input-group-addon"><b>User ID</b></span>
                      <select class="form-control" name="user_id">
                        <?php
                            while ($rowi = mysqli_fetch_array($resi)){
                        ?>
                            <option value="<?php echo $rowi["user_id"];
                            ?>">
                                <?php echo $rowi["user_id"];
                                ?>
                            </option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <br> 
                
                 <br>
                
                 <div class="input-group">
                  <button type="submit" name="submit" class="btn btn-success">Approve</button>
                  
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