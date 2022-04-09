<!DOCTYPE html>
<html lang="en">

<?php session_start(); 
include("./db_files/connection.php");?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.2.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
  <a href="homepage.php" class="logo d-flex align-items-center">
    <img src="assets/img/logo.png" alt="">
    <span class="d-none d-lg-block">ArtFolio</span>
  </a>
  <i class="bi bi-list toggle-sidebar-btn"></i>
</div><!-- End Logo -->

<div class="search-bar">
  <form class="search-form d-flex align-items-center" method="POST" action="search.php">
    <input type="text" name="nameSearch" placeholder="Search" title="Enter search keyword">
    <button type="submit" title="nameSearch"><i class="bi bi-search"></i></button>
  </form>
</div><!-- End Search Bar -->

<nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->


      <?php 
      if(isset($_SESSION['name'])){
        if($_SESSION['type_User']==0){
          //only creators have notifications
          $creatorID = $_SESSION['UserID'];

                    //recover the number of notifications for viewed profile
                    $sql0 = "SELECT *
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
      ?>
        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" >
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number"><?php echo" $totalNotification";?></span>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              You have <?php echo"$totalNotification"; ?> new notifications
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a> 
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <?php 
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
                              echo"
                              <li class='notification-item'>
                                <i class='bi bi-exclamation-circle text-warning'></i>
                                <div style='font-weight: bold'>
                                  <h4>Accepted proposal</h4>
                                  <p>$companyName has accepted your proposal</p>
                                </div>
                              </li>

                              <li>
                                <hr class='dropdown-divider'>
                              </li>
                              ";
                          }else{
                              echo"<li class='notification-item'>
                              <i class='bi bi-check-circle text-success'></i>
                              <div style='font-weight: normal'>
                                <h4>Accepted proposal</h4>
                                <p>$companyName has accepted your proposal</p>
                              </div>
                            </li>

                            <li>
                              <hr class='dropdown-divider'>
                            </li>
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
                          echo"<li class='notification-item'>
                          <i class='bi bi-exclamation-circle text-warning'></i>
                          <div  style='font-weight: bold'>
                            <h4>Message from: $companyName</h4>
                            <p>Message text: $messageText</p>
                            <p>Meeting link: $messageLink</p>
                          </div>
                        </li>

                        <li>
                          <hr class='dropdown-divider'>
                        </li>
                              ";
                      }else{
                          echo"<li class='notification-item'>
                          <i class='bi bi-check-circle text-success'></i>
                          <div style='font-weight: normal'>
                            <h4>Message from: $companyName</h4>
                            <p>Message text: $messageText</p>
                            <p>Meeting link: $messageLink</p>
                          </div>
                        </li>

                        <li>
                          <hr class='dropdown-divider'>
                        </li>
                              ";
                      }

                      }
                      if($response == 2){
                          if($notification_checked == 0){
                          echo"<li class='notification-item'>
                          <i class='bi bi-exclamation-circle text-warning'></i>
                          <div>
                            <h4 style='font-weight: bold'>Rejected proposal</h4>
                            <p>$companyName has rejected your proposal</p>
                          </div>
                        </li>

                        <li>
                          <hr class='dropdown-divider'>
                        </li>
                              ";
                          }else{
                              echo"<li class='notification-item'>
                              <i class='bi bi-x-circle text-danger'></i>
                              <div>
                                <h4 style='font-weight: normal'>Rejected proposal</h4>
                                <p>$companyName has rejected your proposal</p>
                              </div>
                            </li>

                            <li>
                              <hr class='dropdown-divider'>
                            </li>
                              ";
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
                            echo"<li class='notification-item'>
                            <i class='bi bi-exclamation-circle text-warning'></i>
                            <div style='font-weight: bold'>
                              <h4>Viewed profile</h4>
                              <p>$companyName has viewed your proposal</p>
                            </div>
                          </li>

                          <li>
                            <hr class='dropdown-divider'>
                          </li>
                            ";
                        }else{
                            echo"<li class='notification-item'>
                            <i class='bi bi-check-circle text-success'></i>
                            <div style='font-weight: normal'>
                              <h4>Viewed profile</h4>
                              <p>$companyName has viewed your proposal</p>
                            </div>
                          </li>

                          <li>
                            <hr class='dropdown-divider'>
                          </li>
                            ";
                        }

                        $sql14 = "UPDATE $db_tab_application
                        SET notification_checked = 1
                        WHERE applicationID = $application_ID";

                        $result14 = mysqli_query($mysqliConnection,$sql14);
                        
                    }
                  }


            ?>
          <!--  <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Lorem Ipsum</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>30 min. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-x-circle text-danger"></i>
              <div>
                <h4>Atque rerum nesciunt</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>1 hr. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-check-circle text-success"></i>
              <div>
                <h4>Sit rerum fuga</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>2 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-info-circle text-primary"></i>
              <div>
                <h4>Dicta reprehenderit</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>4 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li> -->
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

      <!--  <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">3</span>
          </a> --> <!-- End Messages Icon -->

        <!--  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              You have 3 new messages
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Maria Hudson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>4 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Anna Nelson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>6 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>David Muldon</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>8 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="dropdown-footer">
              <a href="#">Show all messages</a>
            </li>

          </ul> --><!-- End Messages Dropdown Items -->

      <!--  </li>  End Messages Nav -->
        <?php
          }
        }
        ?>

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <!--<img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">-->
            <?php
              if (isset($_SESSION['name'])){
                $nameUser = $_SESSION['name'];
                echo"<span class='d-none d-md-block dropdown-toggle ps-2'>$nameUser</span>";
              }else{
                echo"
                <a class='dropdown-item d-flex align-items-center' href='./chooseProfileTypeSignup.php'>
                <span>Sign-up</span></a>";
              }
            ?>
            <!--<span class="d-none d-md-block dropdown-toggle ps-2">K. Anderson</span>-->
          </a><!-- End Profile Iamge Icon -->
        <?php 
        
              if(isset($_SESSION['name'])){
        ?>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php 
                        if (isset($_SESSION['name'])){
                         
                          $nameUser = $_SESSION['name'];
                          echo "$nameUser";
                          
                        }
                        
                        ?></h6>
              <span>
              <?php 
                        if (isset($_SESSION['name'])){
                          if($_SESSION['type_User']==0){
                            $userID = $_SESSION['UserID'];

                            $sql = "SELECT *
                            FROM $db_tab_creator
                            WHERE userID = $userID
                              ";
                            
                            $result = mysqli_query($mysqliConnection,$sql);
                            $row = mysqli_fetch_array($result);
                            $jobFigure = $row['jobFigure'];
                            echo"$jobFigure";
                          }
                        }
                        ?>  
             </span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <?php
              if($_SESSION['type_User']==0){
                echo"<a class='dropdown-item d-flex align-items-center' href='./profileCreator.php'>
                <i class='bi bi-person'></i>";
              }
              if($_SESSION['type_User']==1){
                echo"<a class='dropdown-item d-flex align-items-center' href='./profileCompany.php'>
                <i class='bi bi-person'></i>";
              }
               ?>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

             <!--<li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li> -->

            <!-- <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li> -->

            <li>
              <a class="dropdown-item d-flex align-items-center" href="./logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->
        <?php }
        ?>

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->