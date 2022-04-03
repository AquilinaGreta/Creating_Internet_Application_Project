<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title>Visualize creator's portfolio</title>
    </head>
    
    <body>

    <?php
        include("./db_files/connection.php");

        session_start();
        if(isset($_GET['creatorID'])){

            $application_ID = $_GET['applicationID'];
            $sql0 = "UPDATE $db_tab_application
            SET viewed = 1, notification_viewed = 1
            WHERE applicationID = '$application_ID'";

            $result0 = mysqli_query($mysqliConnection,$sql0);
            
            //extract creator informations
            $sql = "SELECT *
            FROM $db_tab_creator
            WHERE UserID = \"{$_GET['creatorID']}\"
            ";

            $result = mysqli_query($mysqliConnection,$sql);
            $rowcount=mysqli_num_rows($result);

                if($rowcount>0){
            
                    while($row = mysqli_fetch_array($result)) {

                        $Creator_ID = $row['UserID'];
                        $nameCreator = $row['name'];
                        $usernameCreator = $row['username'];
                        $jobFigure = $row['jobFigure'];
                        $tools = $row['tools'];

                        echo" 
                            <h2>Username: $usernameCreator</h2>
                            <h3>Name: $nameCreator</h3>
                            <h3>JobFigure: $jobFigure</h3>
                            <h3>Tool: $tools </h3>
                            "; 

                    }
                }
                
            //extract creator's portfolio with its creations
            $sql2 = "SELECT *
                FROM $db_tab_portfolio, $db_tab_creations
                WHERE $db_tab_portfolio.PortfolioID = \"{$_GET['creatorID']}\"
                AND $db_tab_creations.portfolio_ID = \"{$_GET['creatorID']}\"
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
                                <h3 class='date'>$dateDMY</h3>
                                <h3 class='description'>$description</h3>
                                <img class='creaIMG' src='".$external_host_link."' height='780' width='680'>
                            </div>";

                        //extract the tagID of the current creation
                        $sql3 = "SELECT *
                        FROM $db_tab_association
                        WHERE $db_tab_association.postID = $Creation_ID
                        AND $db_tab_association.type_content = 0
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
    ?>

</body>
</html>