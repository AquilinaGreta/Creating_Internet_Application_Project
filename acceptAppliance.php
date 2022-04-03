<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title>Accept job appliance and send meeting information</title>
    </head>
    
    <body>
        <?php

        include("./db_files/connection.php");

        session_start();
        if(isset($_POST['acceptAppliance'])){

            $application_ID = $_POST['acceptAppliance'];
           
            //extract the job adv ID that has to be passed to the prev page for its visualization 
            $sql4 = "SELECT * 
                    FROM $db_tab_application 
                    WHERE  applicationID =  $application_ID       
            ";
            $result4 = mysqli_query($mysqliConnection,$sql4);
            $rowcount4 =mysqli_num_rows($result4);
            $row4 = mysqli_fetch_array($result4);        
            $jobAdv_ID = $row4['job_advID'];
            
        ?>
        

        <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
            <h1>Meeting information</h1>
            <p>Here you can insert all the meeting information</p>

            <input type=hidden name='acceptAppliance' value='<?php echo $application_ID?>'>
            <input type=hidden name='jobID' value='<?php echo $jobAdv_ID?>'>

            <div>
                <label for="meetingInfo"><b>Meeting information</b></label>
                <p>Insert here the hour and date of the meeting, or some general information</p>
                <textarea type="text" rows="9" cols="70" placeholder="Insert meeting information" name="meetingInfo" required></textarea>
            </div>

            <div>
                <label for="linkMeet"><b>Link to image</b></label>
                <p>Insert here the link for the meeting (Zoom, Google Meet etc.)</p>
                <textarea type="text" rows="3" cols="70" placeholder="Insert the link for the meet" name="linkMeet" required></textarea>
            </div>

            <div>
                <button type="submit" name="Send">Send</button>
                <button type="reset">Reset</button>
                <button onclick="goBack()">Go back</button>
            </div>

        </form>

    <script>
        function goBack() {
        window.history.back();
        }
    </script>

    <?php
        if(isset($_POST['Send'])){
            $application_ID = $_POST['acceptAppliance'];
            $jobAdv_ID = $_POST['jobID'];
                
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
            header('Location: ./visualizeJobAdvSubmissions.php?jobAdv_ID='.$jobAdv_ID);
            }
        }
    ?>

    </body>
</html>