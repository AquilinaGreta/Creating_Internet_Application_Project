<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualize creator's portfolio</title>
    </head>
    <?php  
        include("./db_files/connection.php");
        include("./base_header.php");
    ?>
    
    <body>
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Visualize creator's portfolio</h1>
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
    <section class="section profile"> 
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
    <?php
        //include("./db_files/connection.php");

        //session_start();
        if(isset($_GET['creatorID'])){

            $application_ID = $_GET['applicationID'];
            $sql0 = "UPDATE $db_tab_application
            SET viewed = 1, notification_viewed = 1
            WHERE applicationID = '$application_ID'";

            $result0 = mysqli_query($mysqliConnection,$sql0);
            
            //extract creator informations
            $sql = "SELECT *
            FROM $db_tab_creator
            WHERE UserID = \"{$_GET['creatorID']}\"
            ";

            $result = mysqli_query($mysqliConnection,$sql);
            $rowcount=mysqli_num_rows($result);

                if($rowcount>0){
            
                    while($row = mysqli_fetch_array($result)) {

                        $Creator_ID = $row['UserID'];
                        $nameCreator = $row['name'];
                        $usernameCreator = $row['username'];
                        $jobFigure = $row['jobFigure'];
                        $tools = $row['tools'];
                        $email = $row['email'];

                        echo" 
                            <h2>$usernameCreator</h2>
                            <div class='tab-content pt-2'>
                                <div class='tab-pane fade show active profile-overview' id='profile-overview'>
                                    <h3>Email: $email</h3>
                                    <h3>Job Figure: $jobFigure</h3>
                                    <h3>Tools: $tools</h3>
                                </div>
                            </div>
                            "; 

                    }
                }
                ?>
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
        <h1>Portfolio</h1>
        <?php 
                
            //extract creator's portfolio with its creations
            $sql2 = "SELECT *
                FROM $db_tab_portfolio, $db_tab_creations
                WHERE $db_tab_portfolio.PortfolioID = \"{$_GET['creatorID']}\"
                AND $db_tab_creations.portfolio_ID = \"{$_GET['creatorID']}\"
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
                        WHERE postID = $Creation_ID
                        AND type_content = 0
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
                                </div>
                        </div>";
                }
            }
        }        
    ?>
    </div>
    </div>
    </section>
</main>
</body>
</html>