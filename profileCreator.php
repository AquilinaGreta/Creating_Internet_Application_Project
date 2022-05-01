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
        
        
            <?php
                include("./db_files/connection.php");
                include("./base_header.php");
            ?>
           
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