<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile section</title>
    </head>
    
    <body >
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Your profile</h1>
        </div>
        
        <!--Superior bar with tools like signup login search so on-->
        <!--<div class="navigation bar">
            <ul class="navigation">
                <li><a id="home" title="home" href="./homepage.php">Homepage</a></li>
                <li><a id="search" href="./search.php">Search</a></li>-->
            <?php
                include("./db_files/connection.php");
                include("./base_header.php");

                //session_start();
                //if(isset($_SESSION['name'])){

                    //$creatorID = $_SESSION['UserID'];

                    //recover the number of notifications for viewed profile
                    /*$sql0 = "SELECT *
                    FROM $db_tab_application
                    WHERE creatorID = $creatorID
                    AND notification_checked = 0
                    AND notification_viewed != 0
                    ";

                    $result0 = mysqli_query($mysqliConnection,$sql0);
                    $rowcount0 = mysqli_num_rows($result0);
                    
                    $countViewed = $rowcount0;
                    //echo"Viewed: $countViewed";

                    //recover the number of notifications for response 
                    $sql01 = "SELECT *
                    FROM $db_tab_application
                    WHERE creatorID = $creatorID
                    AND notification_checked = 0
                    AND notification_response != 0
                    ";

                    $result01 = mysqli_query($mysqliConnection,$sql01);
                    $rowcount01 = mysqli_num_rows($result01);
                    $countResponse = $rowcount01;
                    //echo"Response:  $countResponse";

                    $totalNotification = $countViewed + $countResponse;
                    //echo"Total: $totalNotification";

                    $nameToVisualize=$_SESSION['name'];
                    echo"<h4>Welcome back: $nameToVisualize</h4>
                        <li><a id='jobSubmission' title='jobSubmission' href='./visualizeApplianceToJob.php'>Your job appliances</a></li>
                        <li id='notificationIcon'>
                        <form method='post'>
                            <a href='#' class='notification' onclick='removeNumberVisualizeNotif()'>
                                <span>Notifications</span>
                                <span class='badge'>$totalNotification</span>
                            </a>
                        </form>
                        </li>
                        <script>
                            function removeNumberVisualizeNotif(){
                                document.getElementsByClassName('badge')[0].innerHTML = '';";

                                //inserire query che fa retrieve di tutte le notifiche. Quelle con checked a zero le mette in bold le altre no
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

                                    echo"let i = 0;
                                        let cardNotif = 0;
                                        let notificationIcon = 0;
                                        let textNotification = 0;
                                        let text = 0;
                                        let message = 0;
                                        let messageText = 0;
                                       ";

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
                                                echo"textNotification = document.createElement('p');
                                                text = document.createTextNode('$companyName has accepted your proposal'); 
                                                textNotification.style.fontWeight = 'bold'; 
                                                textNotification.append(text);
                                                ";
                                            }else{
                                                echo"textNotification = document.createElement('p');
                                                text = document.createTextNode('$companyName has accepted your proposal'); 
                                                textNotification.style.fontWeight = 'normal'; 
                                                textNotification.append(text);
                                                ";
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
                                            echo"message = document.createElement('p');
                                                    message.style.fontWeight = 'bold';
                                                    messageText = document.createTextNode('Message text: \\n $messageText. \\n Link: \\n $messageLink ');  
                                                    message.append(messageText);
                                                ";
                                        }else{
                                            echo"message = document.createElement('p');
                                                    message.style.fontWeight = 'normal';
                                                    messageText = document.createTextNode('Message text: \\n $messageText. \\n Link: \\n $messageLink ');  
                                                    message.append(messageText);
                                                ";
                                        }

                                        }
                                        if($response == 2){
                                            if($notification_checked == 0){
                                            echo"textNotification = document.createElement('p');
                                                textNotification.style.fontWeight = 'bold';
                                                text = document.createTextNode('$companyName has rejected your proposal');  
                                                textNotification.append(text);
                                                ";
                                            }else{
                                                echo"textNotification = document.createElement('p');
                                                textNotification.style.fontWeight = 'normal';
                                                text = document.createTextNode('$companyName has rejected your proposal');  
                                                textNotification.append(text);
                                                ";
                                            }
                                        }
                                        
                                        if($viewed == 0){
                                            $sql10 = "UPDATE $db_tab_application
                                            SET notification_checked = 1
                                            WHERE applicationID = $application_ID";
                                        
                                        $result10 = mysqli_query($mysqliConnection,$sql10);
                                        }

                                        echo"cardNotif = document.createElement('div');
                                            cardNotif.setAttribute('id', 'cardNotif');
                                            cardNotif.append(textNotification);
                                            cardNotif.append(message);
                                            notificationIcon = document.querySelector('#notificationIcon');";
                                        echo" notificationIcon.append(cardNotif);   ";
                                        
                                    }
                                }

                                //inserire query che fa retrieve di tutte le notifiche. Quelle con checked a zero le mette in bold le altre no
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

                                    echo"
                                        let cardNotif1 = 0;
                                        let notificationIcon1 = 0;
                                        let textNotification1 = 0;
                                        let text1 = 0;
                                       ";

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
                                        echo"console.log('qui');";
                                        //extract the response 
                                            if($notification_checked == 0){
                                                echo"textNotification1 = document.createElement('p');
                                                text1 = document.createTextNode('$companyName has viewed your proposal'); 
                                                textNotification1.style.fontWeight = 'bold'; 
                                                textNotification1.append(text1);
                                                ";
                                            }else{
                                                echo"textNotification1 = document.createElement('p');
                                                text1 = document.createTextNode('$companyName has viewed your proposal'); 
                                                textNotification1.style.fontWeight = 'normal'; 
                                                textNotification1.append(text1);
                                                ";
                                            }



                                            $sql14 = "UPDATE $db_tab_application
                                            SET notification_checked = 1
                                            WHERE applicationID = $application_ID";

                                            $result14 = mysqli_query($mysqliConnection,$sql14);
                                            
                                            echo"cardNotif1 = document.createElement('div');
                                                cardNotif1.setAttribute('id', 'cardNotif1');
                                                cardNotif1.append(textNotification1);
                                                notificationIcon1 = document.querySelector('#notificationIcon');
                                                notificationIcon1.append(cardNotif1); ";
                                        }
                                }

                         echo"   }
                        </script>
                        ";
                }
                else{
                    echo"<li> <a id='sign-up' title='Sign-up' href='./userSelectionSignup.php'>Sign-up</a></li>
                    <li> <a id='login' title='log-in' href='./loginUsers.php'>Log-in</a></li>
                    ";

                }*/
            ?>
            <!--</ul>
        </div> -->

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

    <section class="section profile"> 
        <div class="row">
        <div class="col-xl-4">
        <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <!--<img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">-->
              <h2>
                  <?php
                    if(isset($_SESSION['name']) && $_SESSION['type_User']==0){

                        $nameToVisualize=$_SESSION['name'];
                        echo"$nameToVisualize
                            ";
                    }
                  ?>
                </h2>
                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                        <?php
                            if(isset($_SESSION['UserID'])){
                                $companyID = $_SESSION['UserID'];
                                $sql =
                                    "SELECT *
                                    FROM $db_tab_creator
                                    WHERE UserID = $companyID
                                    ";
                                $result = mysqli_query($mysqliConnection,$sql);
                                $row = mysqli_fetch_array($result);

                                $email = $row['email'];
                                $jobFigure = $row['jobFigure'];
                                $tool = $row['tools'];

                                echo"<h3>Email: $email</h3>";
                                echo"<h3>Job Figure: $jobFigure</h3>";
                                echo"<h3>Tools: $tool</h3>";
                            }
                        ?>
                    </div>
                </div>
              <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-8">
            <div class="portfolio">
                <!--Portfolio is shown when user accesses his profile section otherwise nothing is shown-->
                <h1>Your Portfolio</h1>
                <?php

                    if(isset($_SESSION['name'])){

                        $nameCreator = $_SESSION['name'];
                        $creatorID = $_SESSION['UserID'];

                        $sql = "SELECT *
                        FROM $db_tab_portfolio
                        WHERE creator_ID = $creatorID
                        ";

                        $result = mysqli_query($mysqliConnection,$sql);
                        $rowcount=mysqli_num_rows($result);

                        if($rowcount>0){
                    
                            while($row = mysqli_fetch_array($result)) {
                                    
                            //extract creator's portfolio with its creations
                            $sql2 = "SELECT *
                            FROM $db_tab_creations
                            WHERE  $db_tab_creations.portfolio_ID = $creatorID
                            ORDER BY date DESC
                            ";

                            $result2 = mysqli_query($mysqliConnection,$sql2);
                            $rowcount2=mysqli_num_rows($result2);

                                if($rowcount2>0){
                            
                                    while($row2 = mysqli_fetch_array($result2)) {

                                        $title = $row2['title'];
                                        $description = $row2['description'];
                                        $date = $row2['date'];
                                        $dateDMY = strtotime( $date );
                                        $dateDMY = date( 'd-m-Y', $dateDMY );
                                        $Creation_ID = $row2['postID'];

                                        $external_host_link = mysqli_real_escape_string($mysqliConnection, urldecode($row2['external_host_link']));
                                        //extract the tagID of the current creation
                                        $sql3 = "SELECT *
                                        FROM $db_tab_association
                                        WHERE $db_tab_association.postID = $Creation_ID
                                        ";
                    
                                        $result3 = mysqli_query($mysqliConnection,$sql3);
                                        $rowcount3=mysqli_num_rows($result3);
                    
                                        if($rowcount3>0){
                                    
                                            while($row3 = mysqli_fetch_array($result3)) {
                                                

                                                $tagID = $row3['tagID'];
                                                
                                                //extract tag name for each tagID
                                                $sql4 = "SELECT *
                                                FROM $db_tab_tag
                                                WHERE tagID =  $tagID
                                                ";
                            
                                                $result4 = mysqli_query($mysqliConnection,$sql4);
                                                $rowcount4=mysqli_num_rows($result4);
                            
                                                if($rowcount4>0){

                                                    while($row4 = mysqli_fetch_array($result4)) {
                                                        $tagName = $row4['tagName'];

                                                    
                                                    }
                                                }
                                            }
                                        }     

                                        echo"<div class='card'>
                                                <img class='card-img-bottom' alt='...' src='".$external_host_link."'>
                                                    <div class='card-body'>
                                                        <h5 class='card-title'>$title</h5>
                                                        <h6 class='card-text'>Published: $dateDMY</h6>
                                                        <h6 class='card-text'>Description: $description</h6>
                                                        <h6 class='card-text'>Tag: $tagName</h6>
                                                        <form method ='post' action ='./deletePost.php'>
                                                            <button class='btn btn-primary' id='deleteCreation' name='deleteCreation' value='$Creation_ID'>Delete creation</button>
                                                        </form>
                                                        <p></p>
                                                        <form method ='post' action ='./modifyPost.php'>
                                                            <input type='hidden' id='title_modify' name='title_modify' value='$title'/>
                                                            <input type='hidden' id='description_modify' name='description_modify' value='$description'/>
                                                            <input type='hidden' id='link_modify' name='link_modify' value='$external_host_link'/>
                                                            <input type='hidden' id='tag_modify' name='tag_modify' value='$tagName'/>
                                                            <button class='btn btn-primary' type='submit' id='modifyCreation' name='modifyCreation' value='$Creation_ID'>Modify creation</button>
                                                        </form>
                                                    </div>
                                            </div>
                                        ";                                        
                                    }
                                }
                            }
                        }
                    }
                    else{
                        echo"It seems that you need to log-in or sig-up
                        ";
                    }
                ?>          
                            </div>
                        </div>
                    </div>
                </section>
            </main>
    </body>
</html>