<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    </head>
    
    
    <?php  
        include("./db_files/connection.php");
        include("./base_header.php");
    ?>
<body>
    <main id="main" class="main">

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
    
    <button class='btn btn-primary' onclick="location.href='./homepage.php'" type='button'>
                        Skip and return to home</button>
    


<?php
    //session_start();
    //include("./db_files/connection.php");

    $jobType = $_SESSION['jobType'];
    $tagID = $_SESSION['tagID'];
    $postID= $_SESSION['postID'];

    $sql = "SELECT DISTINCT UserID
            FROM $db_tab_creator
            WHERE UserID IN (   SELECT portfolio_ID
                                FROM $db_tab_creations
                                WHERE postID IN (SELECT postID
                                                FROM $db_tab_association
                                                WHERE tagID = '$tagID'
                                                AND type_content = '0'))
            AND jobfigure = '$jobType'
            ";

    $result = mysqli_query($mysqliConnection,$sql);
    $rowcount = mysqli_num_rows($result);


    if($rowcount >0){
        $Creators_ID_Useful =[];

        while($row = mysqli_fetch_array($result)){
            array_push($Creators_ID_Useful,$row['UserID']);
        }
    }

    $sql1 = "SELECT postID
             FROM $db_tab_association
             WHERE tagID = '$tagID'
             AND type_content = '0'

            ";

    $result1 = mysqli_query($mysqliConnection,$sql1);
    $rowcount1 = mysqli_num_rows($result1);

    if($rowcount1 >0){
        $POST_ID_Useful =[];

        while($row1 = mysqli_fetch_array($result1)){
            array_push($POST_ID_Useful,$row1['postID']);
        }
    }

    $sql2 = "SELECT portfolio_id, COUNT(*) as countof
             FROM $db_tab_creations
             WHERE postID IN ( '" . implode( "', '", $POST_ID_Useful ) . "' )
             AND portfolio_ID IN ( '" . implode( "', '", $Creators_ID_Useful ) . "' )
             GROUP BY portfolio_id
             ";
    
    $result2 = mysqli_query($mysqliConnection,$sql2);
    $rowcount2 = mysqli_num_rows($result2);

    if($rowcount2 >0){
        $array_interesting_users = [];
        $Total_value = 0;

        while($row2 = mysqli_fetch_array($result2)){
            $Total_value = $Total_value + $row2['countof'];
            $array_interesting_users[$row2['portfolio_id']] = $row2['countof'];

        }
    }
    
    foreach ($array_interesting_users as $userID => $value){
        
        $sql3 = "SELECT *
                FROM $db_tab_creator
                WHERE UserID = '$userID'
                ";
        
        $result3 = mysqli_query($mysqliConnection,$sql3);
        $rowcount3 = mysqli_num_rows($result3);

        while($row3 = mysqli_fetch_array($result3)){
            $usernameCreator = $row3['username'];
            $Creator_ID = $row3['UserID'];
        }
        $aff = ($value*100)/$Total_value;
        $affinity = round($aff,1);

        $sql4 = "SELECT *
        FROM $db_tab_application
        WHERE creatorID = '$Creator_ID'
        AND job_AdvID = '$postID'
        ";

        $result4 = mysqli_query($mysqliConnection,$sql4);
        $rowcount4 = mysqli_num_rows($result4);

        echo"
        <p></p>
        <div class='card'>
                <div class='card-body'>
                <a class='link_userprofile' title='Link to user's profile' href='visualizeUserProfile.php?Creator_ID=".$Creator_ID."'><h5 class='card-title'>$usernameCreator</h5></a>
                <h6 class='card-text'>$usernameCreator has an affinity of: $affinity % for this Job Advertisement</h6>
                <p class='card-text'>By clicking on the button below, you automatically create and accept the creator's proposal, beind able to send him a message with the meeting information</p>
                ";

        if($rowcount4 > 0){
            echo"<h6 class='card-text'>You have contacted the creator</h6>
            </div>
            </div>";
        }else{
                
            echo"<form method ='post' action='./createApplianceAndMessage.php'>
                    <input type='hidden' id='jobID' name='jobID' value='$postID'/> 
                    <button class='btn btn-primary' id='insertCandidate' name='insertCandidate' value='$Creator_ID'>Contact creator</button>
                </form>
            </div>
        </div>
        ";
        }
    }

?>

</body>
</main>
</html>