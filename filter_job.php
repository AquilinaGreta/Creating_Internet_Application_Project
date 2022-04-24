<?php
include("./db_files/connection.php");

   
    $orderType = $_POST['orderingJob'];
    if($orderType == 'desc'){
        
        //extract all the post in descending order 
        $output = array();
        $sql2 = "SELECT *
        FROM $db_tab_jobAdv
        ORDER BY date DESC
        ";

        $result2 = mysqli_query($mysqliConnection,$sql2);
        $rowcount2=mysqli_num_rows($result2);

        if($rowcount2>0){

            while($row2 = mysqli_fetch_array($result2)) {

                $company_ID = $row2['company_ID'];
                $title = $row2['title'];
                $description = $row2['description'];
                $date = $row2['date'];
                $dateDMY = strtotime( $date );
                $dateDMY = date( 'd-m-Y', $dateDMY );
                $jobAdv_ID = $row2['postID'];
                $type_job = $row2['type_of_job'];
                $location = $row2['location'];

                $sql31 = "SELECT *
                FROM $db_tab_company
                WHERE  UserID = $company_ID
                ";

                $result31 = mysqli_query($mysqliConnection,$sql31);
                $rowcount31 = mysqli_num_rows($result31);
                $row31 = mysqli_fetch_array($result31);
                $companyName = $row31['name'];

                array_push($output, $company_ID. "£" .$companyName. "£" .$title. "£" .$description. "£" .$dateDMY. "£" .$type_job. "£" .$location);
            }
            
        }
        echo json_encode($output);
    }
    else{
        //extract all the post in descending order 
        $output = array();
        $sql2 = "SELECT *
        FROM $db_tab_jobAdv
        ORDER BY date ASC
        ";

        $result2 = mysqli_query($mysqliConnection,$sql2);
        $rowcount2=mysqli_num_rows($result2);

        if($rowcount2>0){

            while($row2 = mysqli_fetch_array($result2)) {

                $company_ID = $row2['company_ID'];
                $title = $row2['title'];
                $description = $row2['description'];
                $date = $row2['date'];
                $dateDMY = strtotime( $date );
                $dateDMY = date( 'd-m-Y', $dateDMY );
                $jobAdv_ID = $row2['postID'];
                $type_job = $row2['type_of_job'];
                $location = $row2['location'];

                $sql31 = "SELECT *
                FROM $db_tab_company
                WHERE  UserID = $company_ID
                ";

                $result31 = mysqli_query($mysqliConnection,$sql31);
                $rowcount31 = mysqli_num_rows($result31);
                $row31 = mysqli_fetch_array($result31);
                $companyName = $row31['name'];
                
                array_push($output, $company_ID. "£" .$companyName. "£" .$title. "£" .$description. "£" .$dateDMY. "£" .$type_job. "£" .$location);
            }
        }
        echo json_encode($output);
    }
 
?>