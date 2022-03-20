<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="createUser.css">
        
        <title>Log-in</title>
    </head>
    
    <body>
    
        <form method="post">
                
            <h1>Log-in</h1>
            <p>Please fill the fields</p>

            
            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Insert email" name="email" required>
            

            
            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Insert password" name="psw" required>
            

            <button type="submit" class="login" name="login">Log-in</button>
            <button type="reset" class="cancel">Cancel</button>
            <button onclick="goBack()">Go back</button> 
              
    
        </form>

        <script>
            function goBack() {
            window.history.back();
            }
        </script>
    </body>
    
</html>

<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include("./db_files/connection.php");

if (isset($_POST['login'])){
    
  
    $sql = "SELECT *
            FROM $db_tab_creator
            WHERE email = \"{$_POST['email']}\"
		    ";
    
    $result = mysqli_query($mysqliConnection,$sql);
    $rowcount=mysqli_num_rows($result);

    if ($rowcount>0) {
        $row = mysqli_fetch_array($result);

        $hashed_Pass = $row['password'];
        $password = $_POST['psw'];

        if (password_verify($password, $hashed_Pass)) {
            session_start();
            $_SESSION['UserID']=$row['UserID'];
            $_SESSION['name']=$row['username'];
            $_SESSION['type_User'] = 0;
            header('Location: ./homepage.php');    
            exit();
            
        } 
        else {
            echo 'Invalid password.';
        }
    }

    else{
        $sql2 = "SELECT *
                FROM $db_tab_company
                WHERE email = \"{$_POST['email']}\"
                ";

        $result2 = mysqli_query($mysqliConnection,$sql2);
        $rowcount2=mysqli_num_rows($result2);

        if($rowcount2>0){
            $row = mysqli_fetch_array($result2);

            $hashed_Pass = $row['password'];
            $password = $_POST['psw'];

            if (password_verify($password, $hashed_Pass)) {
                session_start();
                $_SESSION['UserID']=$row['UserID'];
                $_SESSION['name']=$row['name'];
                $_SESSION['type_User'] = 1;
                header('Location: ./homepage.php');    
                exit();
            
            } 
            else {
                echo 'Invalid password.';
            }

        }
        else{
            echo "No users found in db";
        }

    }


}










    //}

    //$row = mysqli_fetch_array($resultQ);

    //ERROR: fix session, fix header
    //if ($row) {  
       //$name = $row['name'];
       //echo"name: $name";
      //session_start();
      //$_SESSION['name']=$row['name'];
      //$_SESSION['UserID']=$row['UserID'];
      //FIX
      //header('Location: ./casa.php');    
      //exit();
    //}
  
       // else{
         //   echo"
            
        //    <p>You inserted wrong password or email. Retry</p>
    
      //  </script>";
      //  }  

?>