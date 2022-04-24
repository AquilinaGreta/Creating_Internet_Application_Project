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

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown" onclick="fetch_notif()">
            <i class="bi bi-bell"></i>
            <span id="numNotif" class="badge bg-primary badge-number"><?php echo" $totalNotification"; ?></span>
          </a><!-- End Notification Icon -->

                <!--AJAX code for filtering creations in desc asc order -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                <script>
                    function fetch_notif() {
                      
                      $.ajax({ 
                          type: "POST", 
                          dataType:"json",
                          data:{"creator":"<?= $creatorID ?>"},
                          url: "./fetch_not.php",
                          beforeSend: function(){
                                    $('#listNotif').empty();
                                    $('#numNotif').empty();
                                },
                          success: function(data){

                            $('#numNotif').append(0);
                            $('#listNotif').append(data);
                              
                      }
                    });
                  }
                </script>


          <ul id="listNotif" class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications" style ="height: 400px; overflow: auto;">
            

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
          <!--  <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li> -->

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