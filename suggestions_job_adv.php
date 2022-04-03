<?php
    session_start();
    include("./db_files/connection.php");


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
        echo"User called:";
        $sql3 = "SELECT *
                FROM $db_tab_creator
                WHERE UserID = '$userID'
                ";
        
        $result3 = mysqli_query($mysqliConnection,$sql3);
        $rowcount3 = mysqli_num_rows($result3);

        while($row3 = mysqli_fetch_array($result3)){
            $name = $row3['username'];
        }
        $aff = ($value*100)/$Total_value;
        $affinity = round($aff,1);
        echo"$name has an affinity of: $affinity % <br>";

    }

    
    











?>