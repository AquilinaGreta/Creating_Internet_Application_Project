<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    
    <head>
    <link rel="stylesheet" href="form_login.css" type="text/css" />
        <title>Database Creation</title>
    </head>
    
    <body>

        <?php

            error_reporting(E_ALL &~E_NOTICE);

            $db_name = "artfolioDB";

            //table list
            $db_tab_creator = "ContentCreator";
            $db_tab_company = "Company";
            $db_tab_portfolio = "Portfolio";
            $db_tab_creations = "Creations";
            $db_tab_jobAdv = "JobAdvertisement";
            $db_tab_association = "Association";
            $db_tab_tag = "Tag";
            $db_tab_application = "Application";
            $db_tab_message = "Message";

            //enable mysqli error reporting before connection
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $mysqliConnection = new mysqli("localhost", "root", "");

            $queryDatabaseCreation = "CREATE DATABASE $db_name";

            if ($resultQ = mysqli_query($mysqliConnection, $queryDatabaseCreation)) {
                printf("Database is created ...\n");
            }
            else {
                printf("No Database Creation\n");
                exit();
            }

            $mysqliConnection->close();

            //enable mysqli error reporting before connection
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $mysqliConnection = new mysqli("localhost", "root", "", $db_name);


            $sqlQuery1 = "CREATE TABLE if not exists $db_tab_creator (
                UserID int NOT NULL auto_increment, primary key(UserID), 
                name varchar(120) NOT NULL,
                email varchar(120) UNIQUE,
                username varchar(120) NOT NULL UNIQUE,
                password varchar(120) NOT NULL,
                jobFigure varchar(120),
                tools varchar(120)
                )";

            if($result = mysqli_query($mysqliConnection, $sqlQuery1))
            print("Content creator table has been created successfully\n");
            else{
            printf("Error in content creator table creation\n");
            exit();
            }

            $sqlQuery2 = "CREATE TABLE if not exists $db_tab_company (
                UserID int NOT NULL auto_increment, primary key(UserID), 
                name varchar(120) NOT NULL,
                email varchar(120) UNIQUE,
                password varchar(120) NOT NULL,
                VAT_number varchar(120) NOT NULL UNIQUE,
                location varchar(120)
                )";

            if($result = mysqli_query($mysqliConnection, $sqlQuery2))
            print("Company table has been created successfully\n");
            else{
            printf("Error in company table creation\n");
            exit();
            }

            $sqlQuery3 = "CREATE TABLE if not exists $db_tab_portfolio (
                PortfolioID int NOT NULL auto_increment, primary key(PortfolioID),
                creator_ID int NOT NULL
                )";

            if($result = mysqli_query($mysqliConnection, $sqlQuery3))
            print("Table Portfolio created successsfully\n");
            else{
            printf("Error in table Portfolio cretion\n");
            exit();
            }

            $sqlQuery4 = "CREATE TABLE if not exists $db_tab_creations (
                postID int NOT NULL auto_increment, primary key(postID),
                title varchar(120) NOT NULL,
                description varchar(120),
                date DATE NOT NULL, 
                portfolio_ID int NOT NULL,
                external_host_link varchar(120) NOT NULL
                )";

            if($result = mysqli_query($mysqliConnection, $sqlQuery4))
            print("Table Creations created successfully\n");
            else{
            printf("Error in table Creations creation\n");
            exit();
            }

            $sqlQuery5 = "CREATE TABLE if not exists $db_tab_jobAdv (
                postID int NOT NULL auto_increment, primary key(postID),
                title varchar(120) NOT NULL,
                description varchar(120) NOT NULL,
                date DATE NOT NULL, 
                company_ID int NOT NULL,
                type_of_job varchar(120) NOT NULL,
                location varchar(120) NOT NULL
                )";

            if($result = mysqli_query($mysqliConnection, $sqlQuery5))
            print("Table JobAdv created successfully\n");
            else{
            printf("Error in table JobAdv creation\n");
            exit();
            }

            $sqlQuery6 = "CREATE TABLE if not exists $db_tab_association (
                associationID int NOT NULL auto_increment, primary key(associationID),
                postID int NOT NULL,
                tagID int NOT NULL,
                type_content int NOT NULL
                )";

            if($result = mysqli_query($mysqliConnection, $sqlQuery6))
            print("Table Association created successfully\n");
            else{
            printf("Error in table Association creation\n");
            exit();
            }

            $sqlQuery7 = "CREATE TABLE if not exists $db_tab_tag (
                tagID int NOT NULL auto_increment, primary key(tagID),
                tagName varchar(120) NOT NULL
                )";

            if($result = mysqli_query($mysqliConnection, $sqlQuery7))
            print("Table Tag created successfully\n");
            else{
            printf("Error in table Tag creation\n");
            exit();
            }

            $sqlQuery8 = "CREATE TABLE if not exists $db_tab_application (
                applicationID int NOT NULL auto_increment, primary key(applicationID),
                creatorID int NOT NULL,
                job_advID int NOT NULL,
                date DATE NOT NULL,
                viewed bool NOT NULL,
                response int NOT NULL,
                notification_viewed bool NOT NULL,
                notification_response int NOT NULL,
                notification_checked bool NOT NULL
                )";

            if($result = mysqli_query($mysqliConnection, $sqlQuery8))
            print("Table Tag Application successfully\n");
            else{
            printf("Error in table Application creation\n");
            exit();
            }

            $sqlQuery9 = "CREATE TABLE if not exists $db_tab_message (
                messageID int NOT NULL auto_increment, primary key(messageID),
                applicationID int NOT NULL,
                message_text varchar(120) NOT NULL,
                meeting_link varchar(120) NOT NULL
                )";

            if($result = mysqli_query($mysqliConnection, $sqlQuery9))
            print("Table Tag Message successfully\n");
            else{
            printf("Error in table Message creation\n");
            exit();
            }

            mysqli_close($mysqliConnection);
            exit;

        ?>
    </body>
</html> 