<?php

include("./db_files/connection.php");

session_start();
if(isset($_POST['retireApplication'])){

    if($_SESSION['type_User'] == 0){

        $jobAdv_ID = $_POST['retireApplication'];
        $sql5 = "DELETE FROM $db_tab_application 
        WHERE  job_advID =  $jobAdv_ID 
        AND creatorID = \"{$_SESSION['UserID']}\"  
        ";
        
        $result5 = mysqli_query($mysqliConnection,$sql5);
        echo"<meta http-equiv='refresh' content='0'>";
        header('Location: ./visualizeApplianceToJob.php');

    }
    if($_SESSION['type_User'] == 1){
        
    }
}



?>