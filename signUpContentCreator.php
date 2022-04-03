<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Content Creator sign up</title> 
        </head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        function goBack() {
        window.history.back();
        }

        function password_Visibility(){
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        function checkEmail(email) {
            // check to see if the email exists in the database using PHP and MySQL
            $.ajax({                                      
                url: 'check_mail_Content_C.php',               //the script to call to get data 
                type: 'post',  
                data: {
                    email: $('#email').val()
                },       
                success: function(response) {       //on reception of reply
                    if(response == 'match') {
                        console.log('match');
                        $('#Error_mail').remove();
                        $("#email_div").append("<b id=\"Error_mail\">Mail already in use</b>");
                        $("#enter_Button").prop('disabled', true);
                    } else if (response == 'no match') {
                        console.log('no_match');
                        $('#Error_mail').remove();
                        $("#enter_Button").prop('disabled', false);
                    } else if (response == 'error') {
                        console.log('error');
                    } else {
                        console.log('who knows');
                    }
                } 
            });

        }

        function checkUsername(vat) {
            // check to see if the email exists in the database using PHP and MySQL
            $.ajax({                                      
                url: 'check_username.php',               //the script to call to get data 
                type: 'post',  
                data: {
                    username: $('#username').val()
                },       
                success: function(response) {       //on reception of reply
                    if(response == 'match') {
                        console.log('match');
                        $("#username_div").append("<b id=\"Error_username\">Username already in use</b>");
                        $("#enter_Button").prop('disabled', true);
                    } else if (response == 'no match') {
                        $('#Error_username').remove();
                        $("#enter_Button").prop('disabled', false);
                    } else if (response == 'error') {
                        console.log('error');
                    } else {
                        console.log('who knows');
                    }
                } 
            });

        }
    </script>
    
    <body>

        <form method="post">
            <h1>Sign Up</h1>
            <p>Please fill the fields</p>
            
            <div>
                <label for="name"><b>Name</b></label>
                <input type="text" placeholder="Insert name" name="name" required>
            </div>
            <div id="email_div">
                <label for="email"><b>Email</b></label>
                <input type="email" id="email" placeholder="Insert email" name="email" onchange="checkEmail(this.value);" required>
            </div>

            <div id="username_div">
                <label for="username"><b>Username</b></label>
                <input type="text" id="username"placeholder="Insert username" name="username" onchange="checkUsername(this.value);"required>
            </div>

            <div>
                <label for="psw"><b>Password</b></label>
                <input id = "password" type="password" placeholder="Insert password" name="psw" required>
                <!-- An element to toggle between password visibility -->
                <input type="checkbox" onclick="password_Visibility()">Show Password
            </div>

            <div>
                <label for="jobFigure"><b>Select the main job figure</b></label>
                <select name="jobFigure" id="jobFigure">
                    <option value="#artist">#Artist</option>
                    <option value="#2D-modeler">#2D-modeler</option>
                    <option value="#3D-modeler">#3D-modeler</option>
                    <option value="#artistModeler">#Artist and Modeler</option>
                </select>
                
            </div>

            <div>
                <label for="tools"><b>Select the prefered tool</b></label>
                <select name="tools" id="tools">
                    <option value="photoshop">Photoshop</option>
                    <option value="ClipStudioPaint">Clip studio paint</option>
                    <option value="zBrush">zBrush</option>
                    <option value="Maya">Maya</option>
                </select>
            </div>
            
            <div>
                <button type="submit" name="enter" id="enter_Button">Sign Up</button>
                <button type="reset" >Cancel</button>
                <button onclick="goBack()">Go back</button>
            </div>
        </form>

    </body>
</html>

<?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    include("./db_files/connection.php");

    if(isset($_POST['enter']) ){ 
        if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['psw']) && isset($_POST['jobFigure']) && isset($_POST['tools'])){
                    $name=  $_POST['name'];
                    $email= $_POST['email'];
                    $username= $_POST['username'];
                    $password=  $_POST['psw'];
                    $jobFigure=  $_POST['jobFigure'];
                    $tools=  $_POST['tools'];

                    $hashed_Pass = password_hash($password, PASSWORD_DEFAULT);

                    $sql = "INSERT INTO $db_tab_creator 
                        (name,email,username,password,jobFigure,tools)
                        VALUES
                        (\"$name\", \"$email\", \"$username\", \"$hashed_Pass\", \"$jobFigure\", \"$tools\")";
                    
                    if (!$result = mysqli_query($mysqliConnection, $sql)) {
                        printf("Error in the query execution\n");
                    exit();
                    }

                    $Id_just_Created = mysqli_insert_id($mysqliConnection);

                    $sql2 = "INSERT INTO $db_tab_portfolio 
                        (creator_ID)
                        VALUES
                        (\"$Id_just_Created\")";
                    
                    if (!$result = mysqli_query($mysqliConnection, $sql2)) {
                        printf("Error in the query execution\n");
                    exit();
                    }
                    
        }   
        else{
            print("Please, insert all the values");
        }
    }
?>