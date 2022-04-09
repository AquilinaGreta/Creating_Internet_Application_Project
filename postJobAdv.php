<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("./base_header.php"); ?>
        <main id="main" class="main">
</head>
<div class="col-lg-6">
   <div class="card mb-3">
       <div class="card-body">
            <h3 class="card-title">Post your Job Advertisement</h3>

                <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">

                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Title</label>
                        <input type="text" placeholder="Insert title" class="form-control" name="title" required>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-5 col-form-label" for="description">Description</label>
                        <textarea class="form-control" type="text" height="100px" name="description" required></textarea>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-8 col-form-label" for="jobtType">Required job figure</label>
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

                            echo"
                                <select class=\"form-select\" name=\"tag\">";
                                    foreach($tag_list as $tag):
                                    echo '<option value="'.$tag.'">'.$tag.'</option>';
                                    endforeach;
                                echo"</select>
                                    ";    
                            ?>
                    </div>


                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="location">Location</label>
                        <input type="text" placeholder="Insert location" class="form-control" name="location" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary" name="enter">Create Job Adv.</button>
                            <button class="btn btn-primary" type="reset">Reset</button>
                        </div>
                    </div>

                </form>
        </div>
    </div>
</div>

</body>

</html>

<?php

include("./db_files/connection.php");


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
    
    $_SESSION['jobType'] = $jobType = $_POST['tag'] ;
    $_SESSION['tagID'] = $tagID;
    $_SESSION['postID'] = $postID;

    echo"<script >
    window.location.href=(\"./suggestions_job_adv.php\");
    </script>";
}

?>
</main>
</body>