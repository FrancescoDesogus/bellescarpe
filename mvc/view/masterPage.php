<?php
include_once 'ViewDescriptor.php';
include_once basename(__DIR__) . '/../Settings.php'; 
?>

<!DOCTYPE html>
<!-- 
     Pagina master, contiene tutto il layout della applicazione 
     le varie pagine vengono caricate a "pezzi" a seconda della zona
     del layout.

     Queste informazioni sono manentute in una struttura dati, chiamata ViewDescriptor
     la classe contiene anche le stringhe per i messaggi di feedback per 
     l'utente (errori e conferme delle operazioni)
-->
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title><?= $viewDescriptor->getTitle()?></title>
        <base href="<?= Settings::getApplicationPath() ?>"/>
        <meta name="keywords" content="bellescarpe" />
        <meta name="description" content="Negozio di scarpe" />
        <link rel="stylesheet" href="../css/owl.carousel.css">

        <!-- Default Theme -->
        <link rel="stylesheet" href="../css/owl.theme.css">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="../css/demo.css">        

    </head>
    <body>
        <div id="page">
            
            <!--  Header -->
            <div id="header">
                <div id="headerContent">
                    <div id="website_logo">
                        <a id="back_to_top">
                        </a>
                    </div>

                    <div id="logout">
                        <?php
                        $logout = $viewDescriptor->getLogoutFile();

                        if(isset($logout))
                            require "$logout";
                        ?>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div id="content">
                <?php
                if($viewDescriptor->getErrorMessage() != null) 
                {
                ?>
                    <div class="error">
                        <?= htmlentities($viewDescriptor->getErrorMessage()) ?>
                    </div>
                <?php
                }
                ?>
                <?php
                if($viewDescriptor->getConfirmationMessage() != null) 
                {
                ?>
                    <div class="confirm">
                        <?= htmlentities($viewDescriptor->getConfirmationMessage()) ?>
                    </div>
                <?php
                }
                ?>
                <?php
                
                $content = $viewDescriptor->getContentFile();
                require "$content";
                ?>
            </div>

            <div style="clear: both; width: 0px; height: 0px;"></div> 
            
            <!-- Footer -->
            <div id="footer">
                <p>
                    BelleScarpe.com
                </p>
                <p>
                    <a href="http://validator.w3.org/check/referer" class="xhtml" title="Questa pagina contiene HTML valido">
                        <abbr title="eXtensible HyperText Markup Language">HTML</abbr> Valido</a>
                    <a href="http://jigsaw.w3.org/css-validator/check/referer" class="css" title="Questa pagina ha CSS validi">
                        <abbr title="Cascading Style Sheets">CSS</abbr> Valido</a>
                </p>
            </div>
        </div>
    </body>
</html>
