<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>homepage</title>
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

    <?php  
        include("./db_files/connection.php");
        
    ?>

    <body>
    <div class="container">

<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

        <div class="d-flex justify-content-center py-4">
          <a class="logo d-flex align-items-center w-auto">
            <img src="assets/img/logo.png" alt="">
            <span class="d-none d-lg-block">ArtFolio</span>
          </a>
        </div><!-- End Logo -->

        <div class="card mb-3">

          <div class="card-body">

            <div class="pt-4 pb-2">
              <h5 class="card-title text-center pb-0 fs-4">Choose your profile type and sign-up</h5>
              <p class="text-center small">Select your type of user</p>
            </div>

            <form class="row g-3 needs-validation" novalidate>

              <div class="col-12">
                <button class="btn btn-primary w-100" onclick="location.href='./signUpCompany.php'" type="button">
                        Company</button>
              </div>
              <div class="col-12">
                <button class="btn btn-primary w-100" onclick="location.href='./signUpContentCreator.php'" type="button">
                        Creator</button>
              </div>
              <div class="col-12">
                <p class="small mb-0">Do you already have an account? <a href="./loginUsers.php">Log-in</a></p>
              </div>
            </form>

          </div>
        </div>

      </div>
    </div>
  </div>

</section>

</div>
        </main>
</body>