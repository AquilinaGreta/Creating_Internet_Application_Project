<?php

include("./db_files/connection.php");

session_start();
if(isset($_POST['deleteCreation'])){

    if($_SESSION['type_User'] == 0){
        $Creation_ID = $_POST['deleteCreation'];
        $sql5 = "DELETE FROM $db_tab_creations 
        WHERE  postID =  $Creation_ID       
        ";
        
        $result5 = mysqli_query($mysqliConnection,$sql5);
        echo"<meta http-equiv='refresh' content='0'>";
        header('Location: ./profileCreator.php');
    }


    if($_SESSION['type_User'] == 1){
        
        $jobAdv_ID = $_POST['deleteCreation'];
        $sql = "DELETE FROM $db_tab_jobAdv 
        WHERE  postID =  $jobAdv_ID       
        ";

        $result = mysqli_query($mysqliConnection,$sql);

        $sql1 = "DELETE FROM $db_tab_application 
        WHERE  job_advID =  $jobAdv_ID       
        ";

        $result = mysqli_query($mysqliConnection,$sql1);
        echo"<meta http-equiv='refresh' content='0'>";

        header('Location: ./profileCompany.php');
    }
}



?>