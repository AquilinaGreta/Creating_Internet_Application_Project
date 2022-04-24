<?php
include("./db_files/connection.php");

$output = array();                   
$tag = $_POST['orderingPostTag'];

$sql4 = "SELECT *
FROM $db_tab_tag
WHERE tagName = '$tag'
";

$result4 = mysqli_query($mysqliConnection,$sql4);
$rowcount4 = mysqli_num_rows($result4);
            
if($rowcount4>0){
   
    $row4 = mysqli_fetch_array($result4);
    $tagID = $row4['tagID'];
    
    $sql5 = "SELECT *
    FROM $db_tab_association
    WHERE tagID = $tagID
    AND type_content = 0
    ";

$result5 = mysqli_query($mysqliConnection,$sql5);
$rowcount5 = mysqli_num_rows($result5);

if($rowcount5>0){

        while( $row5 = mysqli_fetch_array($result5) ) {
           
            $postID = $row5['postID'];
            //extract all the post in descending order 
            $sql2 = "SELECT *
            FROM $db_tab_creations
            WHERE postID = $postID
            ORDER BY date DESC
            ";
            
            $result2 = mysqli_query($mysqliConnection,$sql2);
            $rowcount2=mysqli_num_rows($result2);
            
            if($rowcount2>0){

                while($row2 = mysqli_fetch_array($result2)) {

                    $Creator_ID = $row2['portfolio_ID'];
                    $title = $row2['title'];
                    $description = $row2['description'];
                    $date = $row2['date'];
                    $dateDMY = strtotime( $date );
                    $dateDMY = date( 'd-m-Y', $dateDMY );
                    $Creation_ID = $row2['postID'];
                    $external_host_link = mysqli_real_escape_string($mysqliConnection, urldecode($row2['external_host_link']));

                    $sql31 = "SELECT *
                    FROM $db_tab_creator
                    WHERE  UserID = $Creator_ID
                    ";

                    $result31 = mysqli_query($mysqliConnection,$sql31);
                    $rowcount31 = mysqli_num_rows($result31);
                    $row31 = mysqli_fetch_array($result31);
                    $usernameCreator = $row31['username'];
                   
                    //extract the tagID of the current creation
                    $sql3 = "SELECT *
                    FROM $db_tab_association
                    WHERE $db_tab_association.postID = $Creation_ID
                    AND type_content = 0
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
                    }  
                    array_push($output, $Creator_ID. "£" .$title. "£" .$description. "£" .$dateDMY. "£" .$external_host_link. "£" .$usernameCreator. "£" .$tagName);
                }
            }
        }
    }
    
}
echo json_encode($output);


?>