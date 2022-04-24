<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Content Creator sign up</title> 

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
                    <h5 class="card-title text-center pb-0 fs-4">Create a Content Creator Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
                  </div>

                <form method="post" >
                    
                    <div class="col-12">
                        <label for="name" class="form-label"><b>Your Name</b></label>
                        <input type="text" class="form-control" placeholder="Insert name" name="name" required>
                    </div>

                    <div class="col-12" id="email_div">
                        <label for="email"  class="form-label"><b>Your Email</b></label>
                        <input type="email" class="form-control" id="email" placeholder="Insert email" name="email" onchange="checkEmail(this.value);" required>
                    </div>

                    <div class="col-12" id="username_div">
                        <label for="username" class="form-label"><b>Username</b></label>
                        <input type="text" class="form-control" id="username"placeholder="Insert username" name="username" onchange="checkUsername(this.value);"required>
                    </div>

                    <div class="col-12">
                        <label for="psw" class="form-label"><b>Password</b></label>
                        <input id = "password" class="form-control" type="password" placeholder="Insert password" name="psw" required>
                        <!-- An element to toggle between password visibility -->
                        <input class="form-check-input" type="checkbox" onclick="password_Visibility()"> Show Password
                    </div>


                    <div>
                        <label for="jobFigure"><b>Select the main job figure</b></label>
                        <br>

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
                                <select class=\"form-select\" name='jobFigure' id='jobFigure'>";
                                    foreach($tag_list as $tag):
                                    echo '<option value="'.$tag.'">'.$tag.'</option>';
                                    endforeach;
                                echo"</select>
                                    ";    
                            ?>
                    </div>

                    <div>
                        <label for="tools"><b>Select the prefered tool</b></label>
                        <select class="form-select" name="tools" id="tools">
                            <option value="photoshop">Photoshop</option>
                            <option value="ClipStudioPaint">Clip studio paint</option>
                            <option value="zBrush">zBrush</option>
                            <option value="Maya">Maya</option>
                        </select>
                    </div>
                    
                    <div>
                        <button type="submit" class="btn btn-primary w-100" name="enter" id="enter_Button">Create Account</button>
                        <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="loginUsers.php">Log in</a></p>
                    
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
                    echo"<script >
                    window.location.href=(\"./loginUsers.php\");
                    </script>";
        }   
        else{
            print("Please, insert all the values");
        }
    }
?>