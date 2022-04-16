<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualize Job Advertisement</title>
    </head>
    <?php  
        include("./db_files/connection.php");
        include("./base_header.php");
    ?>

    <body>
        <main id="main" class="main">

        <div class="pagetitle">
            <h1>Visualize Job Advertisement</h1>
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
                echo"<h4>You are logged as: $nameToVisualize</h4>";
            }
            else{
                echo"<li> <a id='sign-up' title='Sign-up' href='./userSelectionSignup.php'>Sign-up</a></li>
                <li> <a id='login' title='log-in' href='./loginUsers.php'>Log-in</a></li>
                ";

            }*/

            if(isset($_GET['jobAdv_ID'])){

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

                        echo" <div class='card'>
                                <div class='card-body'>
                                    <h5 class='card-title'>$title</h5>
                                    <h6 class='card-text'>Published: $dateDMY</h6>
                                    <h6 class='card-text'>Required job figure: $typeOfJob</h6>
                                    <h6 class='card-text'>Location: $locationJob</h6>
                                    <h6 class='card-text'>Description: $description</h6>
                                
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
                
                //If creator is logged, then the button for the jobAdv appliance will appear
            if(isset($_SESSION['type_User'])){
                if($_SESSION['type_User'] == 0){

                    $sql4 = "SELECT *
                        FROM $db_tab_application
                        WHERE job_advID = \"{$_GET['jobAdv_ID']}\"
                        AND   creatorID = \"{$_SESSION['UserID']}\"
                        ";

                    $result4 = mysqli_query($mysqliConnection,$sql4);
                    $rowcount4=mysqli_num_rows($result4);

                    if($rowcount4>0){
                        echo"
                        <form method ='post'>
                        <button class='btn btn-primary' id='retireApplication' name='retireApplication' value='retireApplication'>Retire application</button>
                        </form>
                        </div>
                        </div>
                        ";

                        if(isset($_POST['retireApplication'])){
                            $sql5 = "DELETE FROM $db_tab_application 
                                     WHERE  job_advID = \"{$_GET['jobAdv_ID']}\"
                                     AND   creatorID = \"{$_SESSION['UserID']}\"
                            ";
    
                            $result5 = mysqli_query($mysqliConnection,$sql5);
                            echo"<meta http-equiv='refresh' content='0'>";
                        }
                        
                    }else{
                        echo"
                        <form method ='post'>
                        <button class='btn btn-primary' id='applyApplication' name='applyApplication' value='applyApplication'>Apply application</button>
                        </form>
                        </div>
                        </div>
                        ";
                        if(isset($_POST['applyApplication'])){

                            $creatorID = $_SESSION['UserID'];
                            $jobAdvID = $_GET['jobAdv_ID'];
                            $dateApplication = date("Y-m-d");
                           
                            $sql6 = "INSERT INTO $db_tab_application (creatorID, job_advID, date, viewed, response, notification_viewed, notification_response, notification_checked)
                            VALUES
                            ('$creatorID', ' $jobAdvID', '$dateApplication', '0', '0', '0', '0', '0')
                            ";
    
                            $result6 = mysqli_query($mysqliConnection,$sql6);
                            echo"<meta http-equiv='refresh' content='0'>";

                        }
                    }
                }
            }
            echo"
            </div>
            </div>
            ";
        }
        ?>
        </main>
    </body>
</html>