<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create job appliance and send meeting information</title>
    </head>
    <?php  
        include("./db_files/connection.php");
        include("./base_header.php");
    ?>


    <body>
        <main id="main" class="main">
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-body">


<?php


if(isset($_POST['insertCandidate'])){
    

    ?>

<form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
            <h3 class="card-title">Meeting information</h3>
            <p class="card-text">Here you can insert all the meeting information</p>

            <input type=hidden name='insertCandidate' value='<?php echo $_POST['insertCandidate']?>'>
            <input type=hidden name='jobID' value='<?php echo $_POST['jobID']?>'>

            <div class="row mb-3">
                <label for="meetingInfo" class="col-sm-6 col-form-label"><b>Meeting information</b></label>
                <p class="card-text">Insert here the hour and date of the meeting, or some general information</p>
                <textarea class="form-control" type="text" rows="9" cols="70" placeholder="Insert meeting information" name="meetingInfo" required></textarea>
            </div>

            <div class="row mb-3">
                <label for="linkMeet" class="col-sm-6 col-form-label"><b>Link to image</b></label>
                <p class="card-text">Insert here the link for the meeting (Zoom, Google Meet etc.)</p>
                <textarea class="form-control" type="text" rows="3" cols="70" placeholder="Insert the link for the meet" name="linkMeet" required></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-sm-10">
                    <button class="btn btn-primary" type="submit" name="Send">Send</button>
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <button class="btn btn-primary" onclick="goBack()">Go back</button>
                </div>
            </div>

        </form>

    <script>
        function goBack() {
        window.history.back();
        }
    </script>


    <?php

if(isset($_POST['Send'])){


    $creatorID = $_POST['insertCandidate'];
    $jobAdvID = $_POST['jobID'];
    $dateApplication = date("Y-m-d");

    $sql = "INSERT INTO $db_tab_application (creatorID, job_advID, date, viewed, response, notification_viewed, notification_response, notification_checked)
            VALUES
            ('$creatorID', ' $jobAdvID', '$dateApplication', '0', '0', '0', '0', '0')
            ";

    if (mysqli_query($mysqliConnection, $sql)) {

        $application_ID = mysqli_insert_id($mysqliConnection);
        
    }

    //extract the job adv ID that has to be passed to the prev page for its visualization 
    $sql4 = "SELECT * 
    FROM $db_tab_application 
    WHERE  applicationID =  $application_ID       
    ";

    $result4 = mysqli_query($mysqliConnection,$sql4);
    $rowcount4 =mysqli_num_rows($result4);
    $row4 = mysqli_fetch_array($result4);        
    $jobAdv_ID = $row4['job_advID'];




        
    $messageText = $_POST['meetingInfo'];
    $linkMeet = mysqli_real_escape_string($mysqliConnection, urlencode($_POST['linkMeet']));

    //update the value response and notification 
    $sql5 = "UPDATE $db_tab_application
    SET response = 1, notification_response = 1
    WHERE applicationID = $application_ID";

    $result5 = mysqli_query($mysqliConnection,$sql5);

    //insert the message with meeting info
    $sql0 = "INSERT INTO $db_tab_message (applicationID, message_text, meeting_link)
    VALUES
    ('$application_ID', '$messageText', '$linkMeet')
    ";

    $result0 = mysqli_query($mysqliConnection,$sql0);
    echo"<script >
    window.history.go(-2);
    </script>";
    
    }


}

?>
</div>
</div>
</div>
    </main>
 </body>
</html>