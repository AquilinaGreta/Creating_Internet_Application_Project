<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    
    <head>
    <title>HOMEPAGE</title>
    </head>
    
    <body >
        <div id="main_page">
            <div >
                <a title="ArtFolio" href="./homepage.php"></a>
            </div>
            <div id="navig" class="navig"> 
                <ul class="navigation">
                <li> <a id="home" title="home" href="./homepage.php"></a> </li>
                <li> <a id="search" title="Search post"></a> </li>


                <?php
                    /* se l'utente è loggato allora viene stampato il suo username 
                    al posto dell'icona signup e il logout al post di login, 
                    altrimenti stampa signup e login*/ 

                    session_start();   
                    if(isset($_SESSION['username'])){

                        
                        $nomeDaVisualizzare=$_SESSION['username'];
                        echo"<li> <a id='AreaPersonale' title='Personal Area' href='profile.php'>$nomeDaVisualizzare</a> </li>
                        <li> <a id='logout' title='logout' href='/logout.php'></a> </li>
                        ";
                    }
                    else{
                        header('Location: ./choose_type_registration.php');;
                    }
                    ?>



                </ul>
            </div>


            <div class="contentwrapper">
                        
                            
                            <?php
                
                            include("CSS/MENUPROVA.css");

                            include("../DB-buono/connection.php");

                            $sql = "SELECT *
                            FROM $db_tab_AreeInt
                        ";

                            if (!$result = mysqli_query($mysqliConnection, $sql)) {
                                printf("Errore nella query di ricerca aree\n");
                            exit();
                            }
                            
                        while( $row = mysqli_fetch_array($result) ) {
                            $ID_Area = $row['areaID'];
                            $nome_Area = $row['nome'];
                            $tag_Area = $row['TAG'];

                            echo "
                                        
                                        <div class='vertical_menu'>
                                            <form method=\"get\" action=\"POST DI AREA DETERMINATA.php\">
                                            <input type=\"hidden\" name=\"ID_AREA\" value=\" $ID_Area \">
                                            <button type \"submit\" value=\"VAI\"> NOME GIOCO: \"$nome_Area\" con TAG: \"$tag_Area\"</button>
                                            </form>
                                        </div>
                                            
                                        
                                    "
                                        ;

                        }

                            
                            
                            ?>
                        
                    </div>
                    <div class="central-column">
                        <div class="postscolumnwidgettop">
                        <img class="popolareIMG" src="./IMMAGINI/post_popolari.png">
                        </div>
                            <div class="postscolumnwidgetbody">
                            
                                <?php

                            
                                    $sql = "SELECT *
                                    FROM $db_tab_post
                                    ";

                                    if (!$result = mysqli_query($mysqliConnection, $sql)) {
                                        printf("Errore nella query di ricerca POST\n");
                                    exit();
                                    }

                                    while( $row = mysqli_fetch_array($result) ) {

                                    $ID_post = $row['postID'];

                                    $ID_AREA_POST = $row['ID_Area'];

                                    $titolo_post = $row['titolo'];
                                    

                                    $testo_post = $row['testo'];


                                    $sql2 = "SELECT TAG
                                    FROM $db_tab_AreeInt
                                    WHERE areaID = $ID_AREA_POST
                                    ";

                                    if (!$result2 = mysqli_query($mysqliConnection, $sql2)) {
                                        printf("Errore nella query di ricerca Aree\n");
                                    exit();
                                    }

                                    $row2 = mysqli_fetch_array($result2);

                                    $tag_post = $row2['TAG'];

                                    echo " <div class='card'>

                                    <a class='link_post' title='Link al post' href='VISUALIZZAZIONE SINGOLO POST CON COMMENTI.php?ID_POST=".$ID_post."'><h1 class='titolo'>$titolo_post</h1></a> 

                                        <h2 class='title_descrip'>TAG: $tag_post </h2>
                                        <p class='text'>$testo_post</p>
                                        </div>
                                    ";

                                    }
                                ?>

                            </div>
                        
                    </div>
                        <div class="rightcolumnwidget">
                            <div class="rightcolumnwidgetbody">
                                <div class="rightcolumnwidgettop">

                                </div>
                                <?php
                                if(isset($_SESSION['username'])){ /* se è settato l'id dell'utente allora visualizza il tasto per la creazione post. Altrimenti visualizza solo la scritta di crea post */
                                    echo"<a href='../creazionePost.php'>
                                
                                    <div class='card'>

                                    <img class='creaIMG' src='./IMMAGINI/creazionePostStelle.png'>
                                        <p class='testo_Creapost'>Crea nuovi post e condividi le tue opinioni con i membri del forum ma, mi raccomando, attento alle regole.</p>
                                    </div>
                                    </a>";
                                }
                                else{
                                    echo"
                                    <div class='card'>

                                    <img class='creaIMG' src='./IMMAGINI/creazionePostStelle.png'>
                                        <p class='testo_Creapost'>Crea nuovi post e condividi le tue opinioni con i membri del forum ma, mi raccomando, attento alle regole.</p>
                                    </div> ";
                                }

                                
                                ?>


                                <div class="card">
                                    <img class="rulesIMG" src='./IMMAGINI/zona_rules.png'>
                                    <p class="desc"> Attento alle nostre regole, &egrave; importante che vengano rispettate nel forum per postare buoni contenuti.</p>
                                </div>
                            </div>
                        </div>
            
            </div>
        </div>
    </body>
</html>

