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

                <p></p>
                <label for="orderingPost">Order creator's posts by date:</label>
                <select name="orderingPost" id="orderingPost" onchange="fetch_order_data_filtered(this)">
                    <option value="desc">Descending order</option>
                    <option value="asc">Ascending order</option>
                </select>
               
                <!--AJAX code for filtering creations in desc asc order -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                <script>
                    
                    function fetch_order_data_filtered(val) {
                        var your_selected_value = $('#orderingPost option:selected').val();

                            $.ajax({ 
                                type: "POST", 
                                url: "./filter_creations.php",
                                data: {
                                    orderingPost: your_selected_value
                                },  
                                dataType:"json",
                                beforeSend: function(){
                                    $('#creation_post').empty();
                                },
                                success: function(data){
                                    
                                    for(var count=0; count<data.length; count++){
                                        
                                    var row = data[count].split("£");
                                   
                                    var html_data = '<div class="col-xxl-4 col-xl-12">';
                                    html_data += '<div class="card info-card customers-card">';
                                    html_data += '<img class="card-img-bottom" src="'+row[4]+'">';
                                    html_data += '<div class="card-body"><p></p>';
                                    html_data += '<a class="card-title" title="Link to user profile" href="visualizeUserProfile.php?Creator_ID='+row[0]+'"><h3>'+row[5]+'</h3></a>';
                                    html_data += '<h4 class="card-title">'+row[1]+'</h4>';
                                    html_data += '<p class="card-text">Published: '+row[3]+'</p>';
                                    html_data += '<p class="card-text">Description: '+row[2]+'</p>';
                                    html_data += '<p class="card-text">Tag: '+row[6]+'</p>';

                                    $('#creation_post').append(html_data);
                                    
                                    }
                                }
                            });
                        }
                </script>
            

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
                    <select  id='orderingPostTag' name=\"tag\"  onchange='fetch_tag_data_filtered(this)'>";
                        foreach($tag_list as $tag):
                        echo '<option value="'.$tag.'">'.$tag.'</option>';
                        endforeach;
                    echo"</select>
                    </form>
                    <p></p>
                    </div>";   
                    ?>

                <!--AJAX code for filtering creations according to tag -->
                <script>
                    
                    function fetch_tag_data_filtered(val) {
                        var selected_value = $('#orderingPostTag option:selected').val();
                        console.log(selected_value);
                            $.ajax({ 
                                type: "POST", 
                                url: "./filter_creations_tag.php",
                                data: {
                                    orderingPostTag: selected_value
                                },  
                                dataType:"json",
                                beforeSend: function(){
                                    $('#creation_post').empty();
                                },
                                success: function(data){
                                    
                                    for(var count1=0; count1<data.length; count1++){
                                        
                                    var row1 = data[count1].split("£");
                                    //console.log(row1);
                                   
                                    var html_data = '<div class="col-xxl-4 col-xl-12">';
                                    html_data += '<div class="card info-card customers-card">';
                                    html_data += '<img class="card-img-bottom" src="'+row1[4]+'">';
                                    html_data += '<div class="card-body"><p></p>';
                                    html_data += '<a class="card-title" title="Link to user profile" href="visualizeUserProfile.php?Creator_ID='+row1[0]+'"><h3>'+row1[5]+'</h3></a>';
                                    html_data += '<h4 class="card-title">'+row1[1]+'</h4>';
                                    html_data += '<p class="card-text">Published: '+row1[3]+'</p>';
                                    html_data += '<p class="card-text">Description: '+row1[2]+'</p>';
                                    html_data += '<p class="card-text">Tag: '+row1[6]+'</p>';

                                    $('#creation_post').append(html_data);
                                    
                                    }
                                }
                            });
                        }
                </script>  
                
                <div class="row">
                    <div class="col-lg-8">
                        <div id="creation_post" class="row">

                            <!-- Creation card in desc ordered by default if no filter is selected -->
        
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

                <label for="orderingJob">Order companies' posts by date:</label>
                <select name="orderingJob" id="orderingJob" onchange="fetch_order_job_filtered(this)">
                    <option value="desc">Descending order</option>
                    <option value="asc">Ascending order</option>
                </select>
               
                <script>
                    
                    function fetch_order_job_filtered(val) {
                        var your_selected_value = $('#orderingJob option:selected').val();
                        console.log(your_selected_value);
                            $.ajax({ 
                                type: "POST", 
                                url: "./filter_job.php",
                                data: {
                                    orderingJob: your_selected_value
                                },  
                                dataType:"json",
                                beforeSend: function(){
                                    $('#jobadv_post').empty();
                                },
                                success: function(data){
                                    console.log(data);
                                    for(var count=0; count<data.length; count++){
                                        
                                    var row = data[count].split("£");
                                    console.log(row);
                                   
                                    var html_data = '<div class="col-xxl-4 col-xl-12">';
                                    html_data += '<div class="card info-card customers-card">';
                                    html_data += '<div class="card-body"><p></p>';
                                    html_data += '<a class="card-title" href="visualizeUserProfile.php?Company_ID='+row[0]+'"><h3>'+row[1]+'</h3></a>';
                                    html_data += '<h4 class="card-title">'+row[2]+'</h4>';
                                    html_data += '<p class="card-text">Published: '+row[4]+'</p>';
                                    html_data += '<p class="card-text">Required job figure: '+row[5]+'</p>';
                                    html_data += '<p class="card-text">Location: '+row[6]+'</p>';
                                    html_data += '<p class="card-text">Description: '+row[3]+'</p>';

                                    $('#jobadv_post').append(html_data);
                                    
                                    }
                                }
                            });
                        }
                </script>

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
                        <select name=\"tag\" id='orderingJobTag' onchange='fetch_tag_job_filtered(this)'>";
                            foreach($tag_list as $tag):
                            echo '<option value="'.$tag.'">'.$tag.'</option>';
                            endforeach;
                        echo"</select>
                        </form>
                        <p></p>
                        </div>";
                ?>

                <script>
                    
                    function fetch_tag_job_filtered(val) {
                        var your_selected_value = $('#orderingJobTag option:selected').val();
                        console.log(your_selected_value);
                            $.ajax({ 
                                type: "POST", 
                                url: "./filter_job_tag.php",
                                data: {
                                    orderingJobTab: your_selected_value
                                },  
                                dataType:"json",
                                beforeSend: function(){
                                    $('#jobadv_post').empty();
                                },
                                success: function(data){
                                    console.log(data);
                                    for(var count=0; count<data.length; count++){
                                        
                                    var row = data[count].split("£");
                                    console.log(row);
                                   
                                    var html_data = '<div class="col-xxl-4 col-xl-12">';
                                    html_data += '<div class="card info-card customers-card">';
                                    html_data += '<div class="card-body"><p></p>';
                                    html_data += '<a class="card-title" href="visualizeUserProfile.php?Company_ID='+row[0]+'"><h3>'+row[1]+'</h3></a>';
                                    html_data += '<h4 class="card-title">'+row[2]+'</h4>';
                                    html_data += '<p class="card-text">Published: '+row[4]+'</p>';
                                    html_data += '<p class="card-text">Required job figure: '+row[5]+'</p>';
                                    html_data += '<p class="card-text">Location: '+row[6]+'</p>';
                                    html_data += '<p class="card-text">Description: '+row[3]+'</p>';

                                    $('#jobadv_post').append(html_data);
                                    
                                    }
                                }
                            });
                        }
                </script>


                <div class="row">
                    <div class="col-lg-8">
                        <div id="jobadv_post" class="row">

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


                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>

