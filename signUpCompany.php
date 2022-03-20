<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Sign up</title>
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
                url: 'check_mail_Comp.php',               //the script to call to get data 
                type: 'post',  
                data: {
                    email: $('#email').val()
                },       
                success: function(response) {       //on reception of reply
                    if(response == 'match') {
                        console.log('match');
                        $('#Error_mail').remove();
                        $("#mail_div").append("<b id=\"Error_mail\">Mail already in use</b>");
                        $("#enter_Button").prop('disabled', true);
                    } else if (response == 'no match') {
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

        function checkVAT(vat) {
            // check to see if the email exists in the database using PHP and MySQL
            $.ajax({                                      
                url: 'check_VAT_Comp.php',               //the script to call to get data 
                type: 'post',  
                data: {
                    vat: $('#VAT').val()
                },       
                success: function(response) {       //on reception of reply
                    if(response == 'match') {
                        console.log('match');
                        $("#VAT_div").append("<b id=\"Error_VAT\">VAT already in use</b>");
                        $("#enter_Button").prop('disabled', true);
                    } else if (response == 'no match') {
                        $('#Error_VAT').remove();
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
                    <div id="mail_div">
                        <label for="email"><b>Email</b></label>
                        <input type="email" id="email" placeholder="Insert email" name="email"  onchange="checkEmail(this.value);" required>
                    </div>
            
                    <div>
                        <label for="psw"><b>Password</b></label>
                        <input id="password" type="password" placeholder="Insert password" name="psw" required>
                        <!-- An element to toggle between password visibility -->
                        <input type="checkbox" onclick="password_Visibility()">Show Password
                    </div>

                    <div id="VAT_div">
                        <label for="VAT"><b>VAT number</b></label>
                        <input type="text" id="VAT" placeholder="Insert VAT number" name="VAT" onchange="checkVAT(this.value);" required>
                    </div>

                    <div>
                        <label for="location"><b>Location</b></label>
                        <input type="text" placeholder="Insert location" name="location" required>
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

    include("db_files/connection.php");

    if(isset($_POST['enter']) ){ 
        if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['psw']) && isset($_POST['VAT']) && isset($_POST['location'])){
                    $name=  $_POST['name'];
                    $email= $_POST['email'];
                    $password=  $_POST['psw'];
                    $vatNumber=  $_POST['VAT'];
                    $location=  $_POST['location'];

                    $hashed_Pass = password_hash($password, PASSWORD_DEFAULT);

                    $sql = "INSERT INTO $db_tab_company 
                        (name,email,password,VAT_number,location)
                        VALUES
                        (\"$name\", \"$email\", \"$hashed_Pass\", \"$vatNumber\", \"$location\")";
                    
                    if (!$result = mysqli_query($mysqliConnection, $sql)) {
                        printf("Error in the query execution\n");
                    exit();
                    }
        }   
        else{
            print("Please, insert all the values");
        }
    }
?>