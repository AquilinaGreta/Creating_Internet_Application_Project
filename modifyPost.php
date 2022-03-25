<?php

include("./db_files/connection.php");

session_start();
if(isset($_POST['modifyCreation'])){

    if($_SESSION['type_User'] == 0){
        $Creation_ID = $_POST['modifyCreation'];
        $Title_Creation = $_POST['title_modify'];
        $Description_Creation = $_POST['description_modify'];
        $Link_Creation = $_POST['link_modify'];
        $Tag_Creation = $_POST['tag_modify'];

?>
        
        
        <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                <h1>Modify post</h1>

                <div>
                    <label for="Title"><b>Title</b></label>
                    <br>
                    <input type=hidden name='modifyCreation' value='<?php echo $Creation_ID?>'>
                    <input type="text" value='<?php echo htmlspecialchars($Title_Creation) ?>' name="title" required>
                </div>


                <div>
                    <label for="tag"><b>Tag</b></label>
                    <br>

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

                        echo"<div class='box'>
                            <select name=\"tag\">";
                                foreach($tag_list as $tag):
                                echo '<option value="'.$tag.'"';

                                    if(strcmp($tag, $Tag_Creation)==0){
                                        echo 'selected';
                                    };
                                echo    '>'.$tag.'</option>';
                                endforeach;
                            echo"</select>
                                </div>";    
                        ?>
                </div>

                <div>
                    <label for="description"><b>Description</b></label>
                    <br>
                    <textarea type="text" rows="9" cols="70" name="description" required><?php echo htmlspecialchars($Description_Creation) ?></textarea>
                </div>

                <div>
                    <label for="link"><b>Link to image</b></label>
                    <br>
                    <textarea type="text" rows="2" cols="70" name="link" required><?php echo htmlspecialchars($Link_Creation) ?></textarea>
                </div>

                <div>
                    <button type="submit" name="enter">Modify</button>
                    <button type="reset">Reset</button>
                    <button onclick="goBack()">Go back</button>
                </div>

        </form>

        <script>
            function goBack() {
                window.history.back();
            }
        </script>

        

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
            header('Location: ./profileCreator.php');


        }    

    }
    if($_SESSION['type_User'] == 1){
        
    }
}



?>