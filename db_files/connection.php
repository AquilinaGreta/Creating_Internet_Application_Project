<?php

$db_name = "artfolioDB";

            //table list
            $db_tab_creator = "ContentCreator";
            $db_tab_company = "company";
            $db_tab_portfolio = "Portfolio";
            $db_tab_creations = "Creations";
            $db_tab_jobAdv = "JobAdvertisement";
            $db_tab_association = "Association";
            $db_tab_tag = "Tag";
            $db_tab_application = "Application";
            $db_tab_message = "Message";

//enable mysqli error reporting before connection
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$mysqliConnection = new mysqli("localhost", "root", "", $db_name);

?>