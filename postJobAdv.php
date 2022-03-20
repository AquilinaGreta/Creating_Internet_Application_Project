<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Job advertisement creation</title>
</head>

<body>
   
        <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
        <h1>Creazione post</h1>

        <div>
            <label for="Title"><b>Title</b></label>
            <br>
            <input type="text" placeholder="Insert title" name="title" required>
        </div>

       
        <div>
            <label for="description"><b>Description</b></label>
            <br>
            <textarea type="text" rows="9" cols="70" name="description" required></textarea>
        </div>

        <div>
            <label for="jobType"><b>Type of job</b></label>
            <br>
            <textarea type="text" rows="2" cols="70" name="jobType" required></textarea>
        </div>

        <div>
            <label for="location"><b>Location</b></label>
            <br>
            <textarea type="text" rows="1" cols="70" name="location" required></textarea>
        </div>

        <div>
            <button type="submit" name="enter">Create</button>
            <button type="reset">Reset</button>
            <button onclick="goBack()">Go back</button>
        </div>

        </form>

    <script>
        function goBack() {
        window.history.back();
        }
    </script>
</body>

</html>

<?php

include("./db_files/connection.php");

session_start();

if (isset($_POST['enter'])){

    $title = $_POST['title'];
    $description = $_POST['description'];
    $jobType = $_POST['jobType'];
    $location = $_POST['location'];

    //MANCANTE: da inserire la company creation 
    $company_ID = $_SESSION['UserID']; 
    $dateJobAdv = date("d-m-Y");
    
    $sql = "INSERT INTO $db_tab_jobAdv (title, description, date, company_ID, type_of_job, location)
    VALUES
    ('$title', ' $description', '$dateJobAdv', '$company_ID', '$jobType', '$location' )
    ";

    if (!$result = mysqli_query($mysqliConnection, $sql)) {
        print(mysqli_error($mysqliConnection));
    exit();
    }
	
}

?>