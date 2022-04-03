<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title>Visualize appliances to Job Advertisement</title>
    </head>
    
    <body>
        <h1>Appliances to your Job Advertisement</h1>
            <?php
                include("./db_files/connection.php");

                session_start();
                if(isset($_SESSION['name'])){

                    $nameToVisualize=$_SESSION['name'];
                    echo"<h4>Here there are the creators who applied to your job advertisement $nameToVisualize</h4>
                        ";
                }

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
                                    <h1 class='titleJob'>$title</h1>
                                    <h3 class='date'>$dateDMY</h3>
                                    <h3 class='description'>$description</h3>
                                    <h3 class='jobType'>Required figure: $typeOfJob</h3>
                                    <h3 class='locationJob'>Job location: $locationJob</h3>
                                </div>";
    
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
                    <h2>Creators who applied for the job</h2>
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
                                                <a class='link_toPortfolio' title='Link to portfolio' href='visualizeUserPortfolio.php?creatorID=".$creatorID."&applicationID=".$application_ID."'><h3 class='username'>$usernameCreator</h3></a>
                                                <form method ='post' action ='./acceptAppliance.php'>
                                                    <button id='acceptAppliance' name='acceptAppliance' value='$application_ID'>Accept Proposal</button>
                                                </form>
                                                <form method ='post' action ='./rejectAppliance.php'>
                                                    <button id='rejectAppliance' name='rejectAppliance' value='$application_ID'>Reject Proposal</button>
                                                </form>
                                            </div>";
                                    }
                                    //if response is 1 or 2, then it is printed 'accepted proposal' or 'rejected proposal'
                                    if($response==1){
                                        echo"<p>You have accepted the proposal of creator: $usernameCreator</p>";
                                    }
                                    if($response==2){
                                        echo"<p>You have rejected the proposal of creator: $usernameCreator</p>";
                                    }
                                }
                            }
                        }
                    }else{
                        echo"<h4>It seems that no creators applied for your job advertisement</h4>";
                    }
                }
            ?>
    </body>
</html>