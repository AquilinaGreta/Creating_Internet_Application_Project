<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    
    <head>
    <title>Search</title>
    </head>
    
    <body >

        <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
            <input id="search" name="nameSearch" type="text" placeholder="Type here">
            <button type="submit" value="search" name="search" >Search</button>
        </form>

    </body>
</html>

<?php

include("./db_files/connection.php");

if (isset($_POST['search'])){

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
                $nameCreator = $row['name'];
                $usernameCreator = $row['username'];
                $userCheck = 0;

                echo " <div class='card'>

                <a class='link_userprofile' title='Link to user's profile' href='visualizeUserProfile.php?Creator_ID=".$Creator_ID."'><h1 class='usernameCreator'>$usernameCreator</h1></a> 

                    <h2 class='nameCreator'>$nameCreator</h2>
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
            
                echo " <div class='card'>
            
                <a class='link_userprofile' title='Link to user's profile' href='visualizeUserProfile.php?Company_ID=".$Company_ID."'><h1 class='nameCompany'>$nameCompany</h1></a> 
            
                    <h2 class='location'>$locationCompany</h2>
                    </div>
                ";
            }
        }else{
            echo 'Invalid username or name.';
        }
    }
}

?>