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
                if(isset($_SESSION['name']) && $_SESSION['type_User']==0){

                    $nameToVisualize=$_SESSION['name'];
                    echo"<h4>Welcome back: $nameToVisualize</h4>
                        <li><a id='jobSubmission' title='jobSubmission' href='./visualizeApplianceToJob.php'>Your job appliances</a></li>
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

        <div class="portfolio">
            <!--Portfolio is shown when user accesses his profile section otherwise nothing is shown-->
            <h1>Your Portfolio</h1>
            <?php

                if(isset($_SESSION['name']) && $_SESSION['type_User']==0){

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
                                        

                                    echo"<div class='card'>

                                            <h1 class='title'>$title</h1>
                                            <form method ='post' action ='./deletePost.php'>
                                                <button id='deleteCreation' name='deleteCreation' value='$Creation_ID'>Delete creation</button>
                                            </form>
                                            <form method ='post' action ='./modifyPost.php'>
                                                <button id='modifyCreation' name='modifyCreation' value='$Creation_ID'>Modify creation</button>
                                            </form>
                                            <h3 class='date'>$dateDMY</h3>
                                            <h3 class='description'>$description</h3>
                                            <img class='creaIMG' src='".$external_host_link."' height='780' width='680'>
                                        
                                        </div>";

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
                }
                else{
                    echo"It seems that you need to log-in or sig-up
                    ";
                }
            ?>
            
        </div>

    </body>
</html>