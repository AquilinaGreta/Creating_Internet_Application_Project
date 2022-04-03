<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Job advertisement creation</title>
</head>

<body>
   
        <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
        <h1>Job Advertisement creation</h1>

        <div>
            <label for="Title"><b>Title</b></label>
            <br>
            <input type="text" placeholder="Insert title" name="title" required>
        </div>

       
        <div>
            <label for="description"><b>Description</b></label>
            <br>
            <textarea type="text" rows="9" cols="70" name="description" required></textarea>
        </div>

        <div>
            <label for="jobtType"><b>Required job figure</b></label>
            <br>

            <?php

                include("./db_files/connection.php");

                $tag_list=array();

                $sql = "SELECT *
                FROM $db_tab_tag
                ";

                if (!$result = mysqli_query($mysqliConnection, $sql)) {
                    printf("Error in query execution\n");
                exit();
                }

                while( $row = mysqli_fetch_array($result) ) {
                
                $tagName = $row['tagName'];
                array_push($tag_list,$tagName);}

                echo"<div class='box'>
                    <select name=\"tag\">";
                        foreach($tag_list as $tag):
                        echo '<option value="'.$tag.'">'.$tag.'</option>';
                        endforeach;
                    echo"</select>
                        </div>";    
                ?>
        </div>


        <div>
            <label for="location"><b>Location</b></label>
            <br>
            <textarea type="text" rows="1" cols="70" name="location" required></textarea>
        </div>

        <div>
            <button type="submit" name="enter">Create</button>
            <button type="reset">Reset</button>
            <button onclick="goBack()">Go back</button>
        </div>

        </form>

    <script>
        function goBack() {
        window.history.back();
        }
    </script>
</body>

</html>

<?php

include("./db_files/connection.php");

session_start();

if (isset($_POST['enter'])){

    $title = $_POST['title'];
    $description = $_POST['description'];
    $jobType = $_POST['tag'];
    $location = $_POST['location'];

    $company_ID = $_SESSION['UserID']; 
    $dateJobAdv = date("Y-m-d");
    
    $sql = "INSERT INTO $db_tab_jobAdv (title, description, date, company_ID, type_of_job, location)
    VALUES
    ('$title', ' $description', '$dateJobAdv', '$company_ID', '$jobType', '$location' )
    ";

    if (mysqli_query($mysqliConnection, $sql)) {

        $postID = mysqli_insert_id($mysqliConnection);

    }

    $sql2 = "SELECT *
    FROM $db_tab_tag
    WHERE tagName = '$jobType'
    ";

    $result2 = mysqli_query($mysqliConnection,$sql2);
    $rowcount2 = mysqli_num_rows($result2);
                
    if($rowcount2>0){

        $row2 = mysqli_fetch_array($result2);
        $tagID = $row2['tagID'];
        
        
        $sql3 = "INSERT INTO $db_tab_association (postID, tagID, type_content) 
        VALUES 
        ('$postID', '$tagID', 1)
        ";
        
        $result3 = mysqli_query($mysqliConnection,$sql3);
        //$rowcount3 = mysqli_num_rows($result3);

    }
	
}

?>