<?php include("./base_header.php"); ?>
<main id="main" class="main">

<?php

include("./db_files/connection.php");
if(isset($_POST['modifyCreation'])){

    if($_SESSION['type_User'] == 0){
        $Creation_ID = $_POST['modifyCreation'];
        $Title_Creation = $_POST['title_modify'];
        $Description_Creation = $_POST['description_modify'];
        $Link_Creation = $_POST['link_modify'];
        $Tag_Creation = $_POST['tag_modify'];

?>
<div class="col-lg-6">
   <div class="card mb-3">
       <div class="card-body">
            <h3 class="card-title">Modify your creation</h3>
        
                <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">

                <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Title</label>

                    <input type=hidden name='modifyCreation' value='<?php echo $Creation_ID?>'>
                    <input type="text" value='<?php echo htmlspecialchars($Title_Creation) ?>' class="form-control" name="title" required>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="tag">Tag</label>

                        <?php


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
                                    echo '<option value="'.$tag.'"';

                                        if(strcmp($tag, $Tag_Creation)==0){
                                            echo 'selected';
                                        };
                                    echo    '>'.$tag.'</option>';
                                    endforeach;
                                echo"</select>";    
                            ?>
                    </div>



                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="description">Description</label>
                        <textarea class="form-control" type="text" height="100px" name="description" required><?php echo htmlspecialchars($Description_Creation) ?></textarea>
                    </div>


                

                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Image URL</label>


                        <input type="text" value='<?php echo htmlspecialchars($Link_Creation) ?>' class="form-control" name="link" required>
                    </div>


                    <div class="row mb-3">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary" name="enter">Modify Post</button>
                        </div>
                    </div>

            </form>
        </div>
    </div>
</div>

<?php

        	
        if (isset($_POST['enter'])){
            $Creation_ID = $_POST['modifyCreation'];
            $New_title = $_POST['title'];
            $New_tag = $_POST['tag'];
            $New_description = $_POST['description'];
            $New_external_host_link = mysqli_real_escape_string($mysqliConnection, urlencode($_POST['link']));


            $sql = "UPDATE $db_tab_creations
                    SET title = '$New_title', description = '$New_description', 
                    external_host_link = '$New_external_host_link'
                    WHERE postID = '$Creation_ID'";


            if (!$result = mysqli_query($mysqliConnection, $sql)) {
                print(mysqli_error($mysqliConnection));
            exit();
            }
            
            $sql2 = "SELECT *
                    FROM $db_tab_tag
                    WHERE tagName = '$New_tag'
                    ";

            $result2 = mysqli_query($mysqliConnection,$sql2);
            $rowcount2=mysqli_num_rows($result2);

            if($rowcount2>0){

                while($row2 = mysqli_fetch_array($result2)) {
                    $tagID = $row2['tagID'];

                    $sql3 = "UPDATE $db_tab_association
                    SET tagID = '$tagID'
                    WHERE postID = '$Creation_ID'";


                    if (!$result = mysqli_query($mysqliConnection, $sql3)) {
                        print(mysqli_error($mysqliConnection));
                    exit();
                    }

                }
            }
            echo"<script >
            window.location.href=(\"./profileCreator.php\");
            </script>";
            //header('Location: ./profileCompany.php');

        }    

    }

    ?>
    <?php
    if($_SESSION['type_User'] == 1){
        
        $jobAdv_ID = $_POST['modifyCreation'];
        $Title_jobAdv = $_POST['title_modify'];
        $Description_jobAdv = $_POST['description_modify'];
        $Tag_jobAdv = $_POST['typeJob_modify'];
        $Location_jobAdv = $_POST['location_modify'];

?>
        
<div class="col-lg-6">
   <div class="card mb-3">
       <div class="card-body">
            <h3 class="card-title">Modify your Job Adv!</h3>


        
                <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">


                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Title</label>

                        <input type=hidden name='modifyCreation' value='<?php echo $jobAdv_ID?>'>
                        <input type="text" value='<?php echo htmlspecialchars($Title_jobAdv) ?>' class="form-control" name="title" required>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="description">Job description</label>
                        <textarea class="form-control" type="text" height="100px" name="description" required><?php echo htmlspecialchars($Description_jobAdv) ?></textarea>
                    </div>



                    <div class="row mb-3">
                            <label class="col-sm-5 col-form-label" for="jobTag">Required job figure</label>
                            

                            <?php


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
                                        echo '<option value="'.$tag.'"';

                                            if(strcmp($tag, $Tag_jobAdv)==0){
                                                echo 'selected';
                                            };
                                        echo    '>'.$tag.'</option>';
                                        endforeach;
                                    echo"</select>";    
                                ?>
                        </div>



                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-5 col-form-label">Location</label>

                            <input type="text" value='<?php echo htmlspecialchars($Location_jobAdv) ?>' class="form-control" name="location" required>
                        </div>                


                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary" name="enterCompany">Modify Job</button>
                            </div>
                        </div>

                </form>



<?php

        	
        if (isset($_POST['enterCompany'])){
            
            $jobAdv_ID = $_POST['modifyCreation'];
            $New_title = $_POST['title'];
            $New_jobTag = $_POST['tag'];
            $New_description = $_POST['description'];
            $New_location = $_POST['location'];

            $sql = "UPDATE $db_tab_jobAdv
                    SET title = '$New_title', description = '$New_description', 
                    location = '$New_location', type_of_job = '$New_jobTag'
                    WHERE postID = '$jobAdv_ID'";


            if (!$result = mysqli_query($mysqliConnection, $sql)) {
                print(mysqli_error($mysqliConnection));
            exit();
            }
            
            $sql2 = "SELECT *
                    FROM $db_tab_tag
                    WHERE tagName = '$New_jobTag'
                    ";

            $result2 = mysqli_query($mysqliConnection,$sql2);
            $rowcount2=mysqli_num_rows($result2);

            if($rowcount2>0){

                while($row2 = mysqli_fetch_array($result2)) {
                    $tagID = $row2['tagID'];

                    $sql3 = "UPDATE $db_tab_association
                    SET tagID = '$tagID'
                    WHERE postID = '$jobAdv_ID'";


                    if (!$result = mysqli_query($mysqliConnection, $sql3)) {
                        print(mysqli_error($mysqliConnection));
                    exit();
                    }
                }
            }
            echo"<script >
            window.location.href=(\"./profileCompany.php\");
            </script>";
        }
    }
}

?>
</body>
</html>