<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>homepage</title>
    </head>

    <?php  
        include("./db_files/connection.php");
        include("./base_header.php");
    ?>

    <body>
        <main id="main" class="main">

        <div class="pagetitle">
            <h1>Home</h1>
        </div>
            <div >
                <a title="ArtFolio" href="./homepage.php"></a>
            </div>

            <!--<div id="navig" class="navig"> 
                <ul class="navigation">
                <li> <a id="home" title="Home" href="./homepage.php">Home</a>  </li>
                <li> <a id="search" title="Search profile" href="./search.php">Search profile</a> </li>-->

                <?php
                    /* se l'utente è loggato allora viene stampato il suo username 
                    al posto dell'icona signup e il logout al post di login, 
                    altrimenti stampa signup e login*/ 
                   
                    //session_start();   
                    /*if(isset($_SESSION['name'])){

                        
                        $nameToVisualize= $_SESSION['name'];
                        if($_SESSION['type_User'] == 0){
                        echo"<li> <a id='profile' title='profile' href='./profileCreator.php'>$nameToVisualize</a> </li>
                        <li> <a id='logout' title='logout' href='/logout.php'>Log-out</a> </li>
                        ";
                        }else{
                            echo"<li> <a id='profile' title='profile' href='./profileCompany.php'>$nameToVisualize</a> </li>
                            <li> <a id='logout' title='logout' href='/logout.php'>Log-out</a> </li>
                            "; 
                        }
                    }
                    else{
                        echo"<li> <a id='sign-up' title='Sign-up' href='./chooseProfileTypeSignup.php'>Sign-up</a> </li>
                            <li> <a id='login' title='login' href='./chooseProfileTypeLogin.php'>Sign-in</a> </li>
                                ";
                    }*/
                    ?>
            <!--    </ul>
            </div> -->

            <aside id="sidebar" class="sidebar">
                <ul class="sidebar-nav" id="sidebar-nav">
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="./homepage.php">
                        <i class="bi bi-grid"></i>
                        <span>Homepage</span>
                        </a>
                    </li>
                    <?php 
                    if(isset($_SESSION['type_User'])){    
                    if($_SESSION['type_User'] == 0){
                       echo"<li class='nav-item'>
                                <a class='nav-link collapsed' href='./postCreation.php'>
                                <i class='bi bi-menu-button-wide'></i>
                                <span>Post a new Creation</span>
                                </a>
                            </li>
                            <li class='nav-item'>
                                <a class='nav-link collapsed' href='./visualizeApplianceToJob.php'>
                                <i class='bi bi-menu-button-wide'></i>
                                <span>Visualize Appliance to Job Adv.</span>
                                </a>
                            </li>
                            <li class='nav-item'>
                                <a class='nav-link collapsed' href='./visualizeMessage.php'>
                                <i class='bi bi-menu-button-wide'></i>
                                <span>Visualize messages by company</span>
                                </a>
                            </li>";
                        }
                    }
                    ?>
                    <?php 
                    if(isset($_SESSION['type_User'])){ 
                    if($_SESSION['type_User'] == 1){
                        echo"<li class='nav-item'>
                                <a class='nav-link collapsed' href='./postJobAdv.php'>
                                <i class='bi bi-menu-button-wide'></i>
                                <span>Post a new Job Advertisement</span>
                                </a>
                            </li>";
                        } 
                    }
                    ?>
                </ul>
            </aside>
            <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Creations</button>
                </li>
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Job Advertisements</button>
                </li>

            </ul>    

            <!-- <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><span>Order creations </span><i class="bi bi-three-dots"></i></a>
              
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Order by:</h6>
                </li>

                <li><a class="dropdown-item" href="#">Ascending</a></li>
                <li><a class="dropdown-item" href="#">Descending</a></li>

              </ul>
            </div> -->

        <section class="section dashboard">
        <div class="tab-content pt-2">
            <div class="tab-pane fade show active profile-overview" id="profile-overview">

           
                <form method ="post">
                    <p></p>
                    <label for="orderingPost">Order creator's posts by date:</label>
                    
                    <select name="orderingPost" id="orderingPost">
                        <option value="desc">Descending order</option>
                        <option value="asc">Ascending order</option>
                    </select>
                    <button class='btn btn-primary btn-sm' type="submit" name="enter" id="enter_Button">Order post</button>
                </form>
            

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
                <form method='post'>
                    <div class='box'>
                    <p></p>
                    <label for='orderingPostTag'>Order creator's posts by tag:</label>
                    <select name=\"tag\">";
                        foreach($tag_list as $tag):
                        echo '<option value="'.$tag.'">'.$tag.'</option>';
                        endforeach;
                    echo"</select>
                    <button class='btn btn-primary btn-sm' type='submit' name='orderingPostTag' id='enter_Button'>Order posts</button>
                    </form>
                    <p></p>
                    </div>";   
                    ?>
                
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">

                            <!-- Creation card in desc ordered by default  -->
        
                                    <?php
                                        //extract all the post in descending order 
                                        $sql2 = "SELECT *
                                        FROM $db_tab_creations
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
                                                echo"
                                                <div class='col-xxl-4 col-xl-12'>
                                                    <div class='card info-card customers-card'>
                                                        <img class='card-img-bottom' alt='...' src='".$external_host_link."'>
                                                            <div class='card-body'>
                                                                <p></p>
                                                                <a class='card-title' title='Link to user's profile' href='visualizeUserProfile.php?Creator_ID=".$Creator_ID."'><h3>$usernameCreator</h3></a>
                                                                <h4 class='card-title'>$title</h4>
                                                                <p class='card-text'>Published: $dateDMY</p>
                                                                <p class='card-text'>Description: $description</p>
                                                                <p class='card-text'>Tag: $tagName</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                ";
                                            }
                                        }
                                    ?>
                        </div><!-- End Creations Card -->
                    </div> 
                </div><!-- End Left side columns -->
            </div>

            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                <form method ="post">
                    <label for="orderingJob">Order companies' posts by date:</label>
                    <select name="orderingJob" id="orderingJob">
                        <option value="desc">Descending order</option>
                        <option value="asc">Ascending order</option>
                    </select>
                    <button class='btn btn-primary' type="submit" name="enter" id="enter_Button">Order post</button>
                </form>

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
                    <form method='post'>
                        <p></p>
                        <div class='box'>
                        <label for='orderingJobTag'>Order companies' posts by job type:</label>
                        <select name=\"tag\">";
                            foreach($tag_list as $tag):
                            echo '<option value="'.$tag.'">'.$tag.'</option>';
                            endforeach;
                        echo"</select>
                        <button class='btn btn-primary' type='submit' name='orderingJobTag' id='enter_Button'>Order posts</button>
                        </form>
                        <p></p>
                        </div>";
                ?>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">

                            <!-- Creation card in desc ordered by default  -->
        
                                <?php //extract all the post in descending order 
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
                                            
                                            echo"<div class='col-xxl-4 col-xl-12'>
                                                    <div class='card info-card customers-card'>
                                                        <div class='card-body'>
                                                            <p></p>
                                                            <a class='link_userprofile' title='Link to user's profile' href='visualizeUserProfile.php?Company_ID=".$company_ID."'><h3 class='usernameCreator'>$companyName</h3></a>
                                                            <p class='card-title'>$title</p>
                                                            <p class='card-text'>Published: $dateDMY</p>
                                                            <p class='card-text'>Required job figure: $type_job</p>
                                                            <p class='card-text'>Location: $location</p>
                                                            <p class='card-text'>Description: $description</p>
                                                        </div>
                                                    </div>
                                                </div>";
                                        }
                                    } 
                                ?>
                        </div><!-- End Creations Card -->
                    </div> 
                </div><!-- End Left side columns -->
            </div>
            </div>

            
                            
                                <?php

                                if(isset($_POST['orderingPost']) ){ 
                                    
                                    $orderType = $_POST['orderingPost'];
                                    if($orderType == 'desc'){
                                        
                                        //extract all the post in descending order 
                                        $sql2 = "SELECT *
                                        FROM $db_tab_creations
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
                                                echo"
                                               
                                                <div class='card'>
                                                <a class='link_userprofile' title='Link to user's profile' href='visualizeUserProfile.php?Creator_ID=".$Creator_ID."'><h1 class='usernameCreator'>$usernameCreator</h1></a>
                                                    <h1 class='title'>$title</h1>
                                                    <h3 class='date'>$dateDMY</h3>
                                                    <h3 class='description'>$description</h3>
                                                    <img class='creaIMG' src='".$external_host_link."' height='500' width='500'>
                                                    <h3 class='tag'>$tagName</h3>
                                                </div>
                                                
                                                ";
                                            }
                                        }

                                    }else{
                                        //extract all the post in descending order 
                                        $sql2 = "SELECT *
                                        FROM $db_tab_creations
                                        ORDER BY date ASC
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
                                                echo"
                                                <div class='card'>
                                                <a class='link_userprofile' title='Link to user's profile' href='visualizeUserProfile.php?Creator_ID=".$Creator_ID."'><h1 class='usernameCreator'>$usernameCreator</h1></a>
                                                    <h1 class='title'>$title</h1>
                                                    <h3 class='date'>$dateDMY</h3>
                                                    <h3 class='description'>$description</h3>
                                                    <img class='creaIMG' src='".$external_host_link."' height='500' width='500'>
                                                    <h3 class='tag'>$tagName</h3>
                                                </div>
                                                ";
                                            }
                                        }
                                    }

                                }

                                

                                        if(isset($_POST['orderingPostTag'])){
                                            
                                            $tag = $_POST['tag'];

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
                                                                echo"<div class='card'>
                                                                <a class='link_userprofile' title='Link to user's profile' href='visualizeUserProfile.php?Creator_ID=".$Creator_ID."'><h1 class='usernameCreator'>$usernameCreator</h1></a>
                                                                    <h1 class='title'>$title</h1>
                                                                    <h3 class='date'>$dateDMY</h3>
                                                                    <h3 class='description'>$description</h3>
                                                                    <img class='creaIMG' src='".$external_host_link."' height='500' width='500'>
                                                                    <h3 class='tag'>$tagName</h3>
                                                                </div>";
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                ?>

                                
                                <?php
                                //companies post visualization and selection

                                if(isset($_POST['orderingJob']) ){ 
                                    
                                    $orderType = $_POST['orderingJob'];
                                    if($orderType == 'desc'){
                                        
                                        //extract all the post in descending order 
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
                                               
                                                echo"<div class='card'>
                                                <a class='link_userprofile' title='Link to user's profile' href='visualizeUserProfile.php?Company_ID=".$company_ID."'><h1 class='usernameCreator'>$companyName</h1></a>
                                                    <h1 class='title'>$title</h1>
                                                    <h3 class='date'>$dateDMY</h3>
                                                    <h3 class='description'>$description</h3>
                                                    <h3 class='typeJob'>$type_job</h3>
                                                    <h3 class='location'>$location</h3>
                                                </div>";
                                            }
                                        }
                                    
                                    }else{
                                        //extract all the post in descending order 
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
                                               
                                                echo"<div class='card'>
                                                <a class='link_userprofile' title='Link to user's profile' href='visualizeUserProfile.php?Company_ID=".$company_ID."'><h1 class='usernameCreator'>$companyName</h1></a>
                                                    <h1 class='title'>$title</h1>
                                                    <h3 class='date'>$dateDMY</h3>
                                                    <h3 class='description'>$description</h3>
                                                    <h3 class='typeJob'>$type_job</h3>
                                                    <h3 class='location'>$location</h3>
                                                </div>";
                                            }
                                        }
                                    }
                                }  

                                        if(isset($_POST['orderingJobTag'])){
                                            
                                            $tagName = $_POST['tag'];

                                            //extract all the post in descending order 
                                        $sql2 = "SELECT *
                                        FROM $db_tab_jobAdv
                                        WHERE type_of_job = '$tagName'
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
                                               
                                                echo"<div class='card'>
                                                <a class='link_userprofile' title='Link to user's profile' href='visualizeUserProfile.php?Company_ID=".$company_ID."'><h1 class='usernameCreator'>$companyName</h1></a>
                                                    <h1 class='title'>$title</h1>
                                                    <h3 class='date'>$dateDMY</h3>
                                                    <h3 class='description'>$description</h3>
                                                    <h3 class='typeJob'>$type_job</h3>
                                                    <h3 class='location'>$location</h3>
                                                </div>";
                                            }
                                        }
                                    }

                                ?>

                            
                        

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>

