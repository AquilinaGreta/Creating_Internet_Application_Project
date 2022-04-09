<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualize appliances to Job Advertisement</title>

</head>
    <?php  
        include("./db_files/connection.php");
        include("./base_header.php");
    ?>
    
    <body>
    <main id="main" class="main">
    <section class="section profile">
        
        <div class="pagetitle">
            <h1>Appliances to your Job Advertisement</h1>
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
                    echo"<h4>Here there are the creators who applied to your job advertisement $nameToVisualize</h4>
                        ";
                }*/

                if(isset($_GET['jobAdv_ID'])){

                    $jobAdv_ID = $_GET['jobAdv_ID'];
                    
                    //extract jobAdv informations
                    $sql = "SELECT *
                            FROM $db_tab_jobAdv
                            WHERE postID = \"{$_GET['jobAdv_ID']}\"
                            ";
    
                    $result = mysqli_query($mysqliConnection,$sql);
                    $rowcount=mysqli_num_rows($result);
    
                    if($rowcount>0){
                
                        while($row = mysqli_fetch_array($result)) {
    
                            $title = $row['title'];
                            $description = $row['description'];
                            $date = $row['date'];
                            $dateDMY = strtotime( $date );
                            $dateDMY = date( 'd-m-Y', $dateDMY );
                            //$jobAdv_ID = $row['postID'];
                            $typeOfJob = $row['type_of_job'];
                            $locationJob = $row['location'];
    
                            echo"<div class='card'>
                                    <div class='card-body'>
                                        <h5 class='card-title'>$title</h5>
                                        <h6 class='card-text'>Published: $dateDMY</h6>
                                        <h6 class='card-text'>Required job figure: $typeOfJob</h6>
                                        <h6 class='card-text'>Location: $locationJob</h6>
                                        <h6 class='card-text'>Description: $description</h6>
                                    </div>
                                </div>
                                    ";
    
                                /*//extract the tagID of the current jobAdv
                                $sql2 = "SELECT *
                                FROM $db_tab_association
                                WHERE $db_tab_association.postID = \"{$_GET['jobAdv_ID']}\"
                                AND $db_tab_association.type_content = 1
                                ";
            
                                $result2 = mysqli_query($mysqliConnection,$sql2);
                                $rowcount2=mysqli_num_rows($result2);
            
                                if($rowcount2>0){
                            
                                    while($row2 = mysqli_fetch_array($result2)) {
                                        
                                        $tagID = $row2['tagID'];
                                        
                                        //extract tag name for each tagID
                                        $sql3 = "SELECT *
                                        FROM $db_tab_tag
                                        WHERE tagID =  $tagID
                                        ";
                    
                                        $result3 = mysqli_query($mysqliConnection,$sql3);
                                        $rowcount3=mysqli_num_rows($result3);
                    
                                        if($rowcount3>0){
    
                                            while($row3 = mysqli_fetch_array($result3)) {
                                                $tagName = $row3['tagName'];
    
                                                echo"<div class='card'>
                                                <h3class='tag'>$tagName</h3>
                                                    </div>";
                                        
                                        }
                                    }
                                }
                            }*/
    
                        }
                    }

                    echo"
                    <h2 class='card-title'>Creators who applied for the job</h2>
                    ";
                    //extract all appliances for the job adv
                    $sql2 = "SELECT *
                            FROM $db_tab_application
                            WHERE job_advID = $jobAdv_ID
                            ";
                    $result2 = mysqli_query($mysqliConnection,$sql2);
                    $rowcount2 =mysqli_num_rows($result2);
                    

                    if($rowcount2>0){
                
                        while($row2 = mysqli_fetch_array($result2)) {

                            $application_ID = $row2['applicationID'];
                            $creatorID = $row2['creatorID'];
                            
                            //extract each creator who applied for that job
                            $sql3 = "SELECT *
                                    FROM $db_tab_creator
                                    WHERE UserID = $creatorID
                                    ";
                            $result3 = mysqli_query($mysqliConnection,$sql3);
                            $rowcount3 =mysqli_num_rows($result3);
        
                            if($rowcount3>0){
                        
                                while($row3 = mysqli_fetch_array($result3)) { 

                                    $usernameCreator = $row3['username'];

                                    //check if the company has already accepted or rejected the user proposal.
                                    //If so, then the buttons accept/reject are not displayed
                                    $sql4 = "SELECT *
                                    FROM $db_tab_application
                                    WHERE applicationID = $application_ID
                                    ";
                                    $result4 = mysqli_query($mysqliConnection,$sql4);
                                    $rowcount4 = mysqli_num_rows($result4);
                                    $row4 = mysqli_fetch_array($result4);
                                    //recover the field response and check if it's zero
                                    $response = $row4['response'];
                                    //if there is still no response then print button
                                    if($response == 0){

                                        echo"<div class='card'>
                                                <div class='card-body'>
                                                    <a class='link_toPortfolio' title='Link to portfolio' href='visualizeUserPortfolio.php?creatorID=".$creatorID."&applicationID=".$application_ID."'><h3 class='card-title'>$usernameCreator</h3></a>
                                                    <form method ='post' action ='./acceptAppliance.php'>
                                                        <button class='btn btn-primary' id='acceptAppliance' name='acceptAppliance' value='$application_ID'>Accept Proposal</button>
                                                    </form>
                                                    <p></p>
                                                    <form method ='post' action ='./rejectAppliance.php'>
                                                        <button class='btn btn-primary' id='rejectAppliance' name='rejectAppliance' value='$application_ID'>Reject Proposal</button>
                                                    </form>
                                                </div>
                                            </div>
                                                ";
                                    }
                                    //if response is 1 or 2, then it is printed 'accepted proposal' or 'rejected proposal'
                                    if($response==1){
                                        echo"
                                        <div class='card'>
                                            <div class='card-body'>
                                                <br>
                                                <h6 class='card-text'>You have accepted the proposal of creator: $usernameCreator</h6>
                                            </div>
                                        </div>
                                        ";
                                    }
                                    if($response==2){
                                        echo"
                                        <div class='card'>
                                            <div class='card-body'>
                                                <br>
                                                <h6 class='card-text'>You have rejected the proposal of creator: $usernameCreator</h6>
                                            </div>
                                        </div>";
                                    }
                                }
                            }
                        }
                    }else{
                        echo"<h4>It seems that no creators applied for your job advertisement</h4>";
                    }
                    
                }
            ?>
            </section>
        </main>
    </body>
</html>