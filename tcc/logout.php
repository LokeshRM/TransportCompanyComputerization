<?php
    
    session_start();
    //echo $_SESSION['user'];
    //$_SESSION['username'] = " ";
    session_destroy();
    //echo 'session has destroyed';
   header ("Location: index.php");
?>