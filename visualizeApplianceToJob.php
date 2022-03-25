<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title>Your job appliances</title>
    </head>
    
    <body>
        <h1>Your job appliances</h1>

        <?php
                include("./db_files/connection.php");

                session_start();
                if(isset($_SESSION['name'])){

                    $nameToVisualize=$_SESSION['name'];
                    echo"<h4>Here there are your job appliances $nameToVisualize</h4>
                        ";
                }
                
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
        
                                echo"<div class='card'>
                                        <h1 class='titleJob'>$title</h1>
                                        <form method ='post' action ='./retireApplication.php'>
                                                <button id='retireApplication' name='retireApplication' value='$jobAdvID'>Retire application</button>
                                        </form>
                                        <h3 class='date'>$dateDMY</h3>
                                        <h3 class='description'>$description</h3>
                                        <h3 class='jobType'>Required figure: $typeOfJob</h3>
                                        <h3 class='locationJob'>Job location: $locationJob</h3>
                                    </div>";
        
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
    
                                                echo"<div class='card'>
                                                <h3class='tag'>$tagName</h3>
                                                    </div>";
                                        
                                            }
                                        }
                                    }
                                }

                            }
                        }

                    }
                }

            ?>

    </body>
</html>
