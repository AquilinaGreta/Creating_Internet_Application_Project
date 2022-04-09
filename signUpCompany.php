<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Company sign up</title> 

        <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dropdowns/">
        <!-- Favicons -->
        <link href="assets/img/favicon.png" rel="icon">
        <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

        <!-- Google Fonts -->
        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
        <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
        <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
        <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
        <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <main>
            <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <span class="d-none d-lg-block">ArtFolio</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create a Company Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
                  </div>
        
        <form method="post">
                    
                    <div>
                        <label for="name" class="form-label"><b>Name</b></label>
                        <input type="text" class="form-control" placeholder="Insert name" name="name" required>
                    </div>
                    <div id="mail_div">
                        <label for="email" class="form-label"><b>Email</b></label>
                        <input type="email" class="form-control" id="email" placeholder="Insert email" name="email"  onchange="checkEmail(this.value);" required>
                    </div>
            
                    <div>
                        <label for="psw" class="form-label"><b>Password</b></label>
                        <input id="password" class="form-control" type="password" placeholder="Insert password" name="psw" required>
                        <!-- An element to toggle between password visibility -->
                        <input type="checkbox" class="form-check-input" onclick="password_Visibility()"> Show Password
                    </div>

                    <div id="VAT_div">
                        <label for="VAT" class="form-label"><b>VAT number</b></label>
                        <input type="text" class="form-control" id="VAT" placeholder="Insert VAT number" name="VAT" onchange="checkVAT(this.value);" required>
                    </div>

                    <div>
                        <label for="location" class="form-label"><b>Location</b></label>
                        <input type="text" class="form-control" placeholder="Insert location" name="location" required>
                    </div>
                    
                    <div>
                        <button type="submit" class="btn btn-primary w-100" name="enter" id="enter_Button">Sign Up</button>
                        <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="loginUsers.php">Log in</a></p>
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

                    echo"<script >
                        window.location.href=(\"./loginUsers.php\");
                        </script>";
        }   
        else{
            print("Please, insert all the values");
        }
        
    }
?>