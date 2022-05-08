<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your messages</title>
    </head>
    <?php  
        include("./db_files/connection.php");
        include("./base_header.php");
    ?>
    <body>
        <main id="main" class="main">

        <div class="pagetitle">
            <h1>Your messages</h1>
        </div>

        <aside id="sidebar" class="sidebar">
                <ul class="sidebar-nav" id="sidebar-nav">
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="./homepage.php">
                        <i class="bi bi-grid"></i>
                        <span>Homepage</span>
                        </a>
                    </li>
                    <?php 
                    if(isset($_SESSION['type_User'])){    
                    if($_SESSION['type_User'] == 0){
                       echo"<li class='nav-item'>
                                <a class='nav-link collapsed' href='./postCreation.php'>
                                <i class='bi bi-menu-button-wide'></i>
                                <span>Post a new Creation</span>
                                </a>
                            </li>
                            <li class='nav-item'>
                                <a class='nav-link collapsed' href='./visualizeApplianceToJob.php'>
                                <i class='bi bi-menu-button-wide'></i>
                                <span>Visualize Appliance to Job Adv.</span>
                                </a>
                            </li>
                            <li class='nav-item'>
                                <a class='nav-link collapsed' href='./visualizeMessage.php'>
                                <i class='bi bi-menu-button-wide'></i>
                                <span>Visualize messages by company</span>
                                </a>
                            </li>";
                        }
                    }
                    ?>
                    <?php 
                    if(isset($_SESSION['type_User'])){ 
                    if($_SESSION['type_User'] == 1){
                        echo"<li class='nav-item'>
                                <a class='nav-link collapsed' href='./postJobAdv.php'>
                                <i class='bi bi-menu-button-wide'></i>
                                <span>Post a new Job Advertisement</span>
                                </a>
                            </li>";
                        } 
                    }
                    ?>
                </ul>
            </aside>

            <?php

                $sql = "SELECT *
                FROM $db_tab_application
                WHERE creatorID = \"{$_SESSION['UserID']}\"
                ";

                $result = mysqli_query($mysqliConnection,$sql);
                $rowcount=mysqli_num_rows($result);

                if($rowcount>0){

                    while($row = mysqli_fetch_array($result)) {

                        $applicationID = $row['applicationID'];
                        $jobAdvID = $row['job_advID'];

                        $sql2 = "SELECT *
                        FROM $db_tab_jobAdv
                        WHERE postID = $jobAdvID
                        ";

                        $result2 = mysqli_query($mysqliConnection,$sql2);
                        $rowcount2=mysqli_num_rows($result2);

                        $row2 = mysqli_fetch_array($result2);
                        $companyID = $row2['company_ID'];

                        //extract companyID
                        $sql3 = "SELECT *
                        FROM $db_tab_company
                        WHERE UserID = $companyID
                        ";

                        $result3 = mysqli_query($mysqliConnection,$sql3);
                        $rowcount3 = mysqli_num_rows($result3);
                        $row3 = mysqli_fetch_array($result3);
                        //company name
                        $companyName = $row3['name'];

                        $sql4 = "SELECT *
                        FROM $db_tab_message
                        WHERE applicationID = $applicationID
                        ";

                        $result4 = mysqli_query($mysqliConnection,$sql4);
                        $rowcount4=mysqli_num_rows($result4);

                        if($rowcount4>0){

                            while($row4 = mysqli_fetch_array($result4)) {

                                $messageText = $row4['message_text'];
                                $messageLink = mysqli_real_escape_string($mysqliConnection, urldecode($row4['meeting_link']));

                                echo"<div class='card'>
                                        <div class='card-body'>
                                            <h5 class='card-title'>Message from: $companyName </h5>
                                            <h6 class='card-text'>Message text: $messageText</h6>
                                            <h6 class='card-text'>Message link: <a href='$messageLink'> $messageLink </a></h6>
                                        </div>
                                    </div>";
                            }
                        }
                    }
                }else{
                    echo"
                    <h5 class='card-text'>It seems that there are no messages</h5>
                    ";
                }

            ?>

        </main>
    </body>