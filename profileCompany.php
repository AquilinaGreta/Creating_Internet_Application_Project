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
                /*if(isset($_SESSION['name']) && $_SESSION['type_User']==1){

                    $nameToVisualize=$_SESSION['name'];
                    
                }
                else{
                    /*echo"<li> <a id='sign-up' title='Sign-up' href='./userSelectionSignup.php'>Sign-up</a></li>
                    <li> <a id='login' title='log-in' href='./loginUsers.php'>Log-in</a></li>
                    ";
                }*/
            ?>
        <!--    </ul>
        </div> -->

    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link collapsed" href="./homepage.php">
                <i class="bi bi-grid"></i>
                <span>Homepage</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="./postJobAdv.php">
                <i class="bi bi-menu-button-wide"></i>
                <span>Post a new Job Advertisement</span>
                </a>
            </li>
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
                                if(isset($_SESSION['name']) && $_SESSION['type_User']==1){

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
                                                FROM $db_tab_company
                                                WHERE UserID = $companyID
                                                ";
                                            $result = mysqli_query($mysqliConnection,$sql);
                                            $row = mysqli_fetch_array($result);

                                            $email = $row['email'];
                                            $location = $row['location'];

                                            echo"<h3>Email: $email</h3>";
                                            echo"<h3>Location: $location</h3>";
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
        </div>

        <div class="col-xl-8">
            
        <h2>Your Job Advertisements</h2>
            <?php
                if(isset($_SESSION['name']) && $_SESSION['type_User']==1){

                    $nameCompany = $_SESSION['name'];
                    $companyID = $_SESSION['UserID'];

                    //extract company job adv
                    $sql2 = "SELECT *
                        FROM $db_tab_jobAdv
                        WHERE $db_tab_jobAdv.company_ID = $companyID
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
                                $jobAdv_ID = $row2['postID'];
                                $typeOfJob = $row2['type_of_job'];
                                $locationJob = $row2['location'];

                                echo"
                                <div class='card'>
                                    <div class='card-body'>
                                    <a class='link_jobAdv' title='Link to job adv visualization' href='visualizeJobAdvSubmissions.php?jobAdv_ID=".$jobAdv_ID."'><h5 class='card-title'>$title</h5></a>
                                        <h6 class='card-text'>Published: $dateDMY</h6>
                                        <h6 class='card-text'>Required job figure: $typeOfJob</h6>
                                        <h6 class='card-text'>Location: $locationJob</h6>
                                        <h6 class='card-text'>Description: $description</h6>
                                        <form method ='post' action ='./deletePost.php'>
                                            <button class='btn btn-primary' id='deleteCreation' name='deleteCreation' value='$jobAdv_ID'>Delete Job Advertisement</button>
                                        </form>
                                        <p></p>
                                        <form method ='post' action ='./modifyPost.php'>
                                            <input type='hidden' id='title_modify' name='title_modify' value='$title'/>
                                            <input type='hidden' id='description_modify' name='description_modify' value='$description'/>
                                            <input type='hidden' id='typeJob_modify' name='typeJob_modify' value='$typeOfJob'/>
                                            <input type='hidden' id='location_modify' name='location_modify' value='$locationJob'/>
                                            <button class='btn btn-primary' type='submit' id='modifyCreation' name='modifyCreation' value='$jobAdv_ID'>Modify Job Advertisement</button>
                                        </form> 
                                    </div>
                                </div>
                                ";
                            }
                        }
                    }
                ?>
                
                
                </div>
            </section>
        </main>
    </body>
</html>