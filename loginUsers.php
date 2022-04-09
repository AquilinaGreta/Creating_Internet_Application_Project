<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pages / Login - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

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

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.2.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>
    
    <body class="container">
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
    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
    <p class="text-center small">Enter your email & password to login</p>
  </div>

    
        <form class="row g-3 needs-validation" method="post">
        <div class="col-12">
            <label for="email" class="form-label"><b>Email</b></label>
            <div class="input-group has-validation">
            <span class="input-group-text" id="inputGroupPrepend">@</span>
            <input type="email" class="form-control" placeholder="Insert email" name="email" required>
            </div>
        </div>

        <div class="col-12">
            <label for="psw" class="form-label"><b>Password</b></label>
            <input type="password" class="form-control" placeholder="Insert password" name="psw" required>
            </div>

            <button type="submit" class="btn btn-primary w-100" class="login" name="login">Login</button>
            <div class="col-12">
                <p class="small mb-0">Don't have account? <a href="./chooseProfileTypeSignup.php">Choose Account</a></p>
            </div>
              
    
        </form>

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
            echo "No user found";
        }

    }


}



?>