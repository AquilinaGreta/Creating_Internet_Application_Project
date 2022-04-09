<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    </head>
    
    
    <?php  
        include("./db_files/connection.php");
        include("./base_header.php");
    ?>
<body>
    <main id="main" class="main">

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
<?php



if (isset($_POST['nameSearch'])){

    //$nameToSearch = $_POST['nameSearch'];

    //DA VEDERE: verificare se necessario
    //$tag_Ricercato=strtoupper($tagDaRicercare);


    $sql = "SELECT *
            FROM $db_tab_creator
            WHERE username = \"{$_POST['nameSearch']}\"
            ";

    $result = mysqli_query($mysqliConnection,$sql);
    $rowcount=mysqli_num_rows($result);

        if($rowcount>0){
    
            while($row = mysqli_fetch_array($result)) {

                $Creator_ID = $row['UserID'];
                $jobFigure = $row['jobFigure'];
                $usernameCreator = $row['username'];
                $userCheck = 0;

                echo " <div class='card'>
                        <div class='card-body'>
                            <a class='link_userprofile' title='Link to user's profile' href='visualizeUserProfile.php?Creator_ID=".$Creator_ID."'><h5 class='card-title'>$usernameCreator</h5></a> 
                            <h6 class='card-text'>$jobFigure</h6>
                        </div>
                    </div>
                ";
            }

    }else{

        //$nameToSearch = $_POST['nameSearch'];

        $sql2 = "SELECT *
            FROM $db_tab_company
            WHERE name = \"{$_POST['nameSearch']}\"
            ";
        
        $result2 = mysqli_query($mysqliConnection,$sql2);
        $rowcount2 =mysqli_num_rows($result2);

        if($rowcount2>0){
            while($row2 = mysqli_fetch_array($result2)) {

                $Company_ID = $row2['UserID'];
                $nameCompany = $row2['name'];
                $locationCompany = $row2['location'];
                $userCheck = 1;
            
                echo "<div class='card'>
                        <div class='card-body'>           
                            <a class='link_userprofile' title='Link to user's profile' href='visualizeUserProfile.php?Company_ID=".$Company_ID."'><h5 class='card-title'>$nameCompany</h5></a>             
                            <h6 class='card-text'>$locationCompany</h2>
                        </div>
                    </div>
                ";
            }
        }else{
            echo 'Invalid username or name.';
        }
    }
}

?>
</main>
</body>
</html>