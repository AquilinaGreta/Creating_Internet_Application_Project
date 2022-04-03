<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title>Profile section</title>
    </head>
    
    <body >
        <h1>Your profile</h1>
        <!--Superior bar with tools like signup login search so on-->
        <div class="navigation bar">
            <ul class="navigation">
                <li><a id="home" title="home" href="./homepage.php">Homepage</a></li>
                <li><a id="search" href="./search.php">Search</a></li>
            <?php
                include("./db_files/connection.php");

                session_start();
                if(isset($_SESSION['name']) && $_SESSION['type_User']==1){

                    $nameToVisualize=$_SESSION['name'];
                    echo"<h4>Welcome back: $nameToVisualize</h4>
                        ";
                }
                else{
                    echo"<li> <a id='sign-up' title='Sign-up' href='./userSelectionSignup.php'>Sign-up</a></li>
                    <li> <a id='login' title='log-in' href='./loginUsers.php'>Log-in</a></li>
                    ";

                }
            ?>
            </ul>
        </div>

        <div id="jobAdvPublished">
        <h1>Job Advertisement published</h1>
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

                                /*//extract the tagID of the current jobAdv
                                $sql3 = "SELECT *
                                FROM $db_tab_association
                                WHERE $db_tab_association.postID = $jobAdv_ID
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
                                        $rowcount4=mysqli_num_rows($result4);
                    
                                        if($rowcount4>0){

                                            while($row4 = mysqli_fetch_array($result4)) {
                                                $tagName = $row4['tagName'];
                                        
                                        }
                                    }
                                }
                            }*/
                            echo"<div class='card'>

                            <a class='link_jobAdv' title='Link to job adv visualization' href='visualizeJobAdvSubmissions.php?jobAdv_ID=".$jobAdv_ID."'><h1 class='titleJob'>$title</h1></a>
                                <form method ='post' action ='./deletePost.php'>
                                    <button id='deleteCreation' name='deleteCreation' value='$jobAdv_ID'>Delete Job Advertisement</button>
                                </form>
                                <form method ='post' action ='./modifyPost.php'>
                                    <input type='hidden' id='title_modify' name='title_modify' value='$title'/>
                                    <input type='hidden' id='description_modify' name='description_modify' value='$description'/>
                                    <input type='hidden' id='typeJob_modify' name='typeJob_modify' value='$typeOfJob'/>
                                    <input type='hidden' id='location_modify' name='location_modify' value='$locationJob'/>
                                    <button type='submit' id='modifyCreation' name='modifyCreation' value='$jobAdv_ID'>Modify Job Advertisement</button>
                                </form>
                                <h3 class='date'>Published: $dateDMY</h3>
                                <h3 class='description'>Job description: $description</h3>
                                <h3 class='tag'>Required job figure: $typeOfJob</h3>
                                <h3 class='location'>Location: $locationJob</h3>
                            
                            </div>";
                        }
                    }
                }
                ?>
            </div>

    </body>
</html>