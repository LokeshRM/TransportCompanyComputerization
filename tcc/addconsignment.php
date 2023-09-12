<?php
    $connection= mysqli_connect('localhost:3306','root','','tcc');
    session_start();
    require_once __DIR__ . '/vendor/autoload.php';
    $mpdf = new \Mpdf\Mpdf();
    $msg="";
    $stat= true;
    if(isset($_POST['submit'])){
        $volume=$_POST['volume'];
        $sname=$_POST['sname'];
        $sAdd=$_POST['sAdd'];
        $rname=$_POST['rname'];
        $rAdd=$_POST['rAdd'];
        $orcity=$_POST['orcity'];
        $drcity=$_POST['drcity'];
        $distance=$_POST['distance'];
        $cost = 1;
        $total_cost = $cost * $distance * $volume;

        // pdfmaking
        
        $data = "";
        $data .= '<h1>Invoice Details</h1>';
        $data .= '<strong>Volume</strong> : ' . $volume . '<br>';
        $data .= '<strong>Sender Name</strong> : ' . $sname . '<br>';
        $data .= '<strong>Sender Address</strong> : ' . $sAdd . '<br>';
        $data .= '<strong>Reciever Name</strong> : ' . $rname . '<br>';
        $data .= '<strong>Reciever Address</strong> : ' . $rAdd . '<br>';
        $data .= '<strong>Origin City</strong> : ' . $orcity . '<br>';
        $data .= '<strong>Destination City</strong> : ' . $drcity . '<br>';
        $data .= '<strong>Bill</strong> : Rs ' . $total_cost . '<br>';
        $mpdf->WriteHTML($data);
        $mpdf->Output('invoice.pdf','D');

        $t = time();
        $insert_query="INSERT INTO `consignments` (`id`, `volume`, `sender_name`, `sender_address`, `receiver_name`, `receiver_address`, `origin_city`, `destination_city`, `status`,`cost`, `truck_id`,`start`,`end`) VALUES ('', '$volume', '$sname', '$sAdd', '$rname', '$rAdd',$orcity,$drcity,1,$total_cost, NULL,$t,NULL)"; 
        $stat= mysqli_query($connection,$insert_query);
        if($stat==true){
            $msg= "<script language='javascript'>
                                       swal(
                                            'Success!',
                                            'Registration Completed!',
                                            'success'
                                            );
                          </script>";
            
        }
        else{
            die('unsuccessful' .mysqli_error($connection));
        }

        $sql = "SELECT * FROM `trucks` WHERE branch_office_id=$orcity and status=1";
        $res= mysqli_query($connection,$sql);

        $sql = "SELECT SUM(volume) as vol FROM `consignments` WHERE origin_city=$orcity and destination_city=$drcity and status=1";
        $get_det = mysqli_query($connection,$sql);
        $sum = mysqli_fetch_assoc($get_det);

        if(mysqli_num_rows($res) > 0){
            $truck = mysqli_fetch_assoc($res);
            $truck_id = $truck["id"];
            $time = $truck["time"];
            $time_ideal = $truck["ideal"];
            if($sum["vol"]>= 500){ 
                $t = time();
                $ideal = $t - $time + $time_ideal;
                $update_consig = "UPDATE `consignments` SET `status` = 2,`truck_id` =$truck_id, `end` =$t WHERE `consignments`. `origin_city`=$orcity and `consignments`. `destination_city`=$drcity and `consignments`. `status`=1";
                $sql2 = "UPDATE `trucks` SET `status` = 2,`ideal` = $ideal WHERE `trucks`.`id` = $truck_id";
                $res = mysqli_query($connection,$update_consig);
                $res = mysqli_query($connection,$sql2);
            }
        }

        // if(mysqli_num_rows($res) > 0){
        //     $sumquery = "SELECT SUM(volume) as vol FROM `consignments` WHERE origin_city=$orcity and destination_city=$drcity and status=2";
        //     $sumi= mysqli_query($connection,$sumquery);
        //     $sum = mysqli_fetch_assoc($sumi);
        //     if($sum["vol"] > 0){
        //         $truck = mysqli_fetch_assoc($res);
        //         $truck_id = $truck["id"];
        //         if($sum["vol"] + $volume > 500){ 
        //             $update_consig = "UPDATE `consignments` SET `status` = 3 WHERE `consignments`. `origin_city`=$orcity and `consignments`. `destination_city`=$drcity";
        //             $c_add= mysqli_query($connection,$update_consig);
        //             $add_query="INSERT INTO `consignments` (`id`, `volume`, `sender_name`, `sender_address`, `receiver_name`, `receiver_address`, `origin_city`, `destination_city`, `status`, `truck_id`) VALUES ('', '$volume', '$sname', '$sAdd', '$rname', '$rAdd',$orcity,$drcity,3,$truck_id)";
        //             $update_truck = "UPDATE `trucks` SET `status` = 2 WHERE `trucks`.`id` = $truck_id"; 
        //             $c_add= mysqli_query($connection,$add_query);
        //             $t_update= mysqli_query($connection,$update_truck);
        //             $stat= true;
        //             echo "added more 500 with more consign";

        //         }else{
        //             $add_query="INSERT INTO `consignments` (`id`, `volume`, `sender_name`, `sender_address`, `receiver_name`, `receiver_address`, `origin_city`, `destination_city`, `status`, `truck_id`) VALUES ('', '$volume', '$sname', '$sAdd', '$rname', '$rAdd',$orcity,$drcity,2,$truck_id)";
        //             $c_add= mysqli_query($connection,$add_query);
        //             $stat= true;
        //             echo "added with multiple consigns";
        //         }
        //     }else{
        //         $truck = mysqli_fetch_assoc($res);
        //         $truck_id = $truck["id"];
        //         if($volume > 500){
        //             $add_query="INSERT INTO `consignments` (`id`, `volume`, `sender_name`, `sender_address`, `receiver_name`, `receiver_address`, `origin_city`, `destination_city`, `status`, `truck_id`) VALUES ('', '$volume', '$sname', '$sAdd', '$rname', '$rAdd',$orcity,$drcity,3,$truck_id)";
        //             $update_truck = "UPDATE `trucks` SET `status` = 2 WHERE `trucks`.`id` = $truck_id"; 
        //             $c_add= mysqli_query($connection,$add_query);
        //             $t_update= mysqli_query($connection,$update_truck);
        //             $stat= true;
        //             echo "added more 500";
        //         }else{
        //             $add_query="INSERT INTO `consignments` (`id`, `volume`, `sender_name`, `sender_address`, `receiver_name`, `receiver_address`, `origin_city`, `destination_city`, `status`, `truck_id`) VALUES ('', '$volume', '$sname', '$sAdd', '$rname', '$rAdd',$orcity,$drcity,2,$truck_id)";
        //             $c_add= mysqli_query($connection,$add_query);
        //             $stat= true;
        //             echo "added consignment without 500";
        //         }
        //     }
            
            
        // }else{
        //     echo "noo";
        //     $insert_query="INSERT INTO `consignments` (`id`, `volume`, `sender_name`, `sender_address`, `receiver_name`, `receiver_address`, `origin_city`, `destination_city`, `status`, `truck_id`) VALUES ('', '$volume', '$sname', '$sAdd', '$rname', '$rAdd',$orcity,$drcity,1, NULL)"; 
        //     $res= mysqli_query($connection,$insert_query);
        //     $stat= true;
        // }

        

        // echo $orcity;
        // echo $drcity;
        
        // $insert_query="INSERT INTO `booking`(`booking_id`, `name`,`username` , `pic_date`, `pic_time`, `dil_date`, `dil_time`, `destination`, `pickup_point`, `description`, `email`, `mobile`, `confirmation`, `veh_reg`, `driverid`, `finished`) VALUES ('','$name','$username','$pic_date','$pic_time','$dil_date','$dil_time','$destination','$pickup','$description','$email','$mobile','','','','')"; 
        // echo $name;
        
        
        
        
        //$res= mysqli_query($connection,$insert_query);
        
        
        
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    
    
    
    
    
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
    
   
     <link rel="stylesheet" href="sweetalert2/sweetalert2.css">
    <script src="sweetalert2/sweetalert2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
     <script src="https://unpkg.com/scrollreveal/dist/scrollreveal.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./slick/slick.css">
    <link rel="stylesheet" type="text/css" href="./slick/slick-theme.css"> 
   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="animate.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
</head>
<body>
    <?php echo $msg;
    ?>
    
    <script>
    
        var timer = setTimeout(function() {
            window.location='consignment_form.php'
        }, 1000);
    </script>

</body>
</html>
