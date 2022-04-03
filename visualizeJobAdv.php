<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title>Visualize Job Advertisement</title>
    </head>
    
    <body>

    <?php
            include("./db_files/connection.php");

            session_start();
            if(isset($_SESSION['name'])){

                $nameToVisualize=$_SESSION['name'];
                echo"<h4>You are logged as: $nameToVisualize</h4>";
            }
            else{
                echo"<li> <a id='sign-up' title='Sign-up' href='./userSelectionSignup.php'>Sign-up</a></li>
                <li> <a id='login' title='log-in' href='./loginUsers.php'>Log-in</a></li>
                ";

            }

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
                
                //If creator is logged, then the button for the jobAdv appliance will appear
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
                        <button id='retireApplication' name='retireApplication' value='retireApplication'>Retire application</button>
                        </form>
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
                        <button id='applyApplication' name='applyApplication' value='applyApplication'>Apply application</button>
                        </form>
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
        ?>

    </body>
</html>