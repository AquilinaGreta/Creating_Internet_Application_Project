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
                        <li><a id='jobPublished' title='jobPublished' href='./visualizeJobPublished.php'>Job advertisement published</a></li>
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

                }
                ?>
            </div>

    </body>
</html>