<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your job appliances</title>
    </head>
    <?php  
        include("./db_files/connection.php");
        include("./base_header.php");
    ?>
    <body>
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Your job appliances</h1>
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
                /*include("./db_files/connection.php");

                session_start();
                if(isset($_SESSION['name'])){

                    $nameToVisualize=$_SESSION['name'];
                    echo"<h4>Here there are your job appliances $nameToVisualize</h4>
                        ";
                }*/
                
                $sql = "SELECT *
                        FROM $db_tab_application
                        WHERE creatorID = \"{$_SESSION['UserID']}\"
                        ";

                $result = mysqli_query($mysqliConnection,$sql);
                $rowcount=mysqli_num_rows($result);

                if($rowcount>0){
            
                    while($row = mysqli_fetch_array($result)) {

                        $jobAdvID = $row['job_advID'];

                        $sql2 = "SELECT *
                        FROM $db_tab_jobAdv
                        WHERE postID = $jobAdvID
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
                                //$jobAdv_ID = $row['postID'];
                                $typeOfJob = $row2['type_of_job'];
                                $locationJob = $row2['location'];
        
                                //extract the tagID of the current jobAdv
                                $sql3 = "SELECT *
                                FROM $db_tab_association
                                WHERE $db_tab_association.postID = $jobAdvID
                                AND $db_tab_association.type_content = 1
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
                                        $rowcount4 = mysqli_num_rows($result4);
                    
                                        if($rowcount4>0){
    
                                            while($row4 = mysqli_fetch_array($result4)) {
                                                $tagName = $row4['tagName'];
    
                                            }
                                        }
                                    }
                                }
                                echo"<div class='card'>
                                        <div class='card-body'>
                                            <h5 class='card-title'>$title</h5>
                                            <h6 class='card-text'>Published: $dateDMY</h6>
                                            <h6 class='card-text'>Required job figure: $typeOfJob</h6>
                                            <h6 class='card-text'>Location: $locationJob</h6>
                                            <h6 class='card-text'>Description: $description</h6>
                                            <h3class='tag'>$tagName</h3>
                                            <p></p>
                                            <form method ='post' action ='./retireApplication.php'>
                                                <button class='btn btn-primary' id='retireApplication' name='retireApplication' value='$jobAdvID'>Retire application</button>
                                            </form>
                                        </div>
                                    </div>";
                            }
                        }

                    }
                }else{
                    echo"
                    <h5 class='card-text'>It seems that there are no job appliances</h5>
                    ";
                }

            ?>

    </body>
</html>
