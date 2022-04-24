<?php
include("./db_files/connection.php");



    $output = '';
    $output .='<li class="dropdown-header">
                    Your notifications
                <!-- <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a> -->
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>';

    $creatorID = $_POST['creator'];
    //view notification
    //recover the all notifications of proposal with response
    $sql02 = "SELECT *
    FROM $db_tab_application
    WHERE creatorID = $creatorID
    AND notification_response != 0
    ORDER BY date DESC
    ";

    $result02 = mysqli_query($mysqliConnection,$sql02);
    $rowcount02 = mysqli_num_rows($result02);
    
    if($rowcount02>0){

        while($row02 = mysqli_fetch_array($result02)) {

            $application_ID = $row02['applicationID'];
            $notification_checked = $row02['notification_checked'];
            $viewed =  $row02['viewed'];
            //extract the response 
            $response = $row02['response'];

            //extract jobID to get the company 
            $jobadvID = $row02['job_advID'];

            $sql5 = "SELECT *
            FROM $db_tab_jobAdv
            WHERE postID = $jobadvID
            ";

            $result5 = mysqli_query($mysqliConnection,$sql5);
            $rowcount5 = mysqli_num_rows($result5);
            $row5 = mysqli_fetch_array($result5);
            $companyID = $row5['company_ID'];

            //extract companyID
            $sql6 = "SELECT *
            FROM $db_tab_company
            WHERE UserID = $companyID
            ";

            $result6 = mysqli_query($mysqliConnection,$sql6);
            $rowcount6 = mysqli_num_rows($result6);
            $row6 = mysqli_fetch_array($result6);
            //company name
            $companyName = $row6['name'];

            
            if($response == 1){
                if($notification_checked == 0){
                //company has accepted proposal in bold
                    $output .= '
                    <li class="notification-item">
                    <i class="bi bi-exclamation-circle text-warning"></i>
                    <div style="font-weight: bold">
                        <h4>Accepted proposal</h4>
                        <p>'.$companyName.' has accepted your proposal</p>
                    </div>
                    </li>

                    <li>
                    <hr class="dropdown-divider">
                    </li>
                    ';

                }else{

                    $output .= '<li class="notification-item">
                    <i class="bi bi-check-circle text-success"></i>
                    <div style="font-weight: normal">
                    <h4>Accepted proposal</h4>
                    <p>'.$companyName.' has accepted your proposal</p>
                    </div>
                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>
                    ';

                }
                    
            //extract and print the clickable message of the accepted proposal  
            $sql9 = "SELECT *
            FROM $db_tab_message
            WHERE applicationID = $application_ID
            ";
            $result9 = mysqli_query($mysqliConnection,$sql9);
            $rowcount9 = mysqli_num_rows($result9);
            $row9 = mysqli_fetch_array($result9); 

            $messageText = $row9['message_text'];
            $messageLink = mysqli_real_escape_string($mysqliConnection, urldecode($row9['meeting_link']));

            //create the message to append to the div and check if needs to be in bold or not
            if($notification_checked == 0){

                $output .= '<li class="notification-item">
                <i class="bi bi-exclamation-circle text-warning"></i>
                <div  style="font-weight: bold">
                <h4>Message from: '.$companyName.'</h4>
                <p>Message text: '.$messageText.'</p>
                <p>Meeting link: '.$messageLink.'</p>
                </div>
            </li>

            <li>
                <hr class="dropdown-divider">
            </li>
                    ';
            }else{

                $output .= '<li class="notification-item">
                <i class="bi bi-check-circle text-success"></i>
                <div style="font-weight: normal">
                <h4>Message from: '.$companyName.'</h4>
                <p>Message text: '.$messageText.'</p>
                <p>Meeting link: '.$messageLink.'</p>
                </div>
            </li>

            <li>
                <hr class="dropdown-divider">
            </li>
                    ';
            }

            }
            if($response == 2){
                if($notification_checked == 0){
                $output .= '<li class="notification-item">
                    <i class="bi bi-exclamation-circle text-warning"></i>
                    <div style="font-weight: bold">
                    <h4>Rejected proposal</h4>
                    <p>'.$companyName.' has rejected your proposal</p>
                    </div>
                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>
                        ';
                }else{
                    $output .= '<li class="notification-item">
                    <i class="bi bi-x-circle text-danger"></i>
                    <div style="font-weight: normal">
                    <h4>Rejected proposal</h4>
                    <p>'.$companyName.' has rejected your proposal</p>
                    </div>
                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>
                    ';
                }
            }
            
            if($viewed == 0){
                $sql10 = "UPDATE $db_tab_application
                SET notification_checked = 1
                WHERE applicationID = $application_ID";
            
            $result10 = mysqli_query($mysqliConnection,$sql10);
            }
        }
    }
   

//recover the all notifications of viewed profile
$sql11 = "SELECT *
FROM $db_tab_application
WHERE creatorID = $creatorID
AND notification_viewed != 0
ORDER BY date DESC
";
$result11 = mysqli_query($mysqliConnection,$sql11);
$rowcount11 = mysqli_num_rows($result11);

if($rowcount11>0){

    while($row11 = mysqli_fetch_array($result11)) {

        $application_ID = $row11['applicationID'];
        $notification_checked = $row11['notification_checked'];

        //extract jobID to get the company 
        $jobadvID = $row11['job_advID'];

        $sql12 = "SELECT *
        FROM $db_tab_jobAdv
        WHERE postID = $jobadvID
        ";

        $result12 = mysqli_query($mysqliConnection,$sql12);
        $rowcount12 = mysqli_num_rows($result12);
        $row12 = mysqli_fetch_array($result12);
        $companyID = $row12['company_ID'];

        //extract companyID
        $sql13 = "SELECT *
        FROM $db_tab_company
        WHERE UserID = $companyID
        ";

        $result13 = mysqli_query($mysqliConnection,$sql13);
        $rowcount13 = mysqli_num_rows($result13);
        $row13 = mysqli_fetch_array($result13);
        //company name
        $companyName = $row13['name'];
        
        //extract the response 
            if($notification_checked == 0){
                $output .= '<li class="notification-item">
                <i class="bi bi-exclamation-circle text-warning"></i>
                <div style="font-weight: bold">
                    <h4>Viewed profile</h4>
                    <p>'.$companyName.' has viewed your proposal</p>
                </div>
                </li>

                <li>
                <hr class="dropdown-divider">
                </li>
                ';
            }else{
                $output .= '<li class="notification-item">
                <i class="bi bi-check-circle text-success"></i>
                <div style="font-weight: normal">
                    <h4>Viewed profile</h4>
                    <p>'.$companyName.' has viewed your proposal</p>
                </div>
                </li>

                <li>
                <hr class="dropdown-divider">
                </li>
                ';
            }

            $sql14 = "UPDATE $db_tab_application
            SET notification_checked = 1
            WHERE applicationID = $application_ID";

            $result14 = mysqli_query($mysqliConnection,$sql14);
            
        }
        }

        echo json_encode($output);

?>




        