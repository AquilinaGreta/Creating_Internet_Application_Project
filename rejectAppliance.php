<?php

include("./db_files/connection.php");

session_start();
if(isset($_POST['rejectAppliance'])){

    $application_ID = $_POST['rejectAppliance'];
    //extract the job adv ID that has to be passed to the prev page for its visualization 
    $sql4 = "SELECT * 
             FROM $db_tab_application 
             WHERE  applicationID =  '$application_ID'       
    ";
    $result4 = mysqli_query($mysqliConnection,$sql4);
    $rowcount4 =mysqli_num_rows($result4);
    $row4 = mysqli_fetch_array($result4);        
    $jobAdv_ID = $row4['job_advID'];
    
    //incorretto eliminare la proposta dal DB
    $sql5 = "UPDATE $db_tab_application
            SET response = 2, notification_response = 2
            WHERE applicationID = '$application_ID'";
    
    $result5 = mysqli_query($mysqliConnection,$sql5);
    echo"<meta http-equiv='refresh' content='0'>";

    
    header('Location: ./visualizeJobAdvSubmissions.php?jobAdv_ID='.$jobAdv_ID);

}
?>