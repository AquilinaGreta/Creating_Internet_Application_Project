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
            <h3 class="card-title">Post your creation</h3>
                <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">

                <div class="row mb-3">
                    <label for="inputText" class="col-sm-2 col-form-label">Title</label>
                    <input type="text" placeholder="Insert title" class="form-control" name="title" required>
                </div>

            
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="tag">Tag</label>
                   

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
                            echo"</select>";    
                        ?>
                </div>


                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label" for="description">Description</label>
                    <textarea class="form-control" type="text" height="100px" name="description" required></textarea>
                </div>

                <div class="row mb-3">
                <label for="basic-url" class="form-label">Image URL</label>
                
                <div class="input-group mb-3">
                    
                    <span class="input-group-text" id="basic-addon3">Imgur Link</span>
                    <input class="form-control" id="basic-url" type="text" name="link" required>
                </div>
                </div>

                <div class="row mb-3">
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary" name="enter">Create Post</button>
                    <button class="btn btn-primary" type="reset">Reset</button>
                  </div>
                </div>

                </form>
        </div>
    </div>
</div>

</html>

<?php

    include("./db_files/connection.php");

    if (isset($_POST['enter'])){

        $title = $_POST['title'];
        $tag = $_POST['tag'];
        $description = $_POST['description'];

        $Creator_ID = $_SESSION['UserID']; 
        $dateCreation = date("Y-m-d");
        $portFolio_ID = $Creator_ID;
        $concat_Link = $_POST['link'];
        $external_host_link = mysqli_real_escape_string($mysqliConnection, urlencode($concat_Link));

        $sql = "INSERT INTO $db_tab_creations (title, description, date, portfolio_ID, external_host_link)
        VALUES
        ('$title', ' $description', '$dateCreation', '$portFolio_ID', '$external_host_link')
        ";

        if (mysqli_query($mysqliConnection, $sql)) {

            $postID = mysqli_insert_id($mysqliConnection);

        }

        $sql2 = "SELECT *
        FROM $db_tab_tag
        WHERE tagName = '$tag'
        ";
        
        $result2 = mysqli_query($mysqliConnection,$sql2);
        $rowcount2 = mysqli_num_rows($result2);
                    
        if($rowcount2>0){

            $row2 = mysqli_fetch_array($result2);
            $tagID = $row2['tagID'];
            
            $sql3 = "INSERT INTO $db_tab_association (postID, tagID, type_content) 
            VALUES 
            ('$postID', '$tagID', 0)
            ";

            $result3 = mysqli_query($mysqliConnection,$sql3);

        }
        echo"<script >
            window.location.href=(\"./homepage.php\");
            </script>";
    }
?>
</main>
</body>