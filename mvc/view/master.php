<?php
include_once 'ViewDescriptor.php';
//include_once basename(__DIR__) . '/../Settings.php'; 
?>
<!DOCTYPE html>
<!-- 
     pagina master, contiene tutto il layout della applicazione 
     le varie pagine vengono caricate a "pezzi" a seconda della zona
     del layout:
     - logo (header)
     - menu (i tab)
     - leftBar (sidebar sinistra)
     - content (la parte centrale con il contenuto)
     - rightBar (sidebar destra)
     - footer (footer)

      Queste informazioni sono manentute in una struttura dati, chiamata ViewDescriptor
      la classe contiene anche le stringhe per i messaggi di feedback per 
      l'utente (errori e conferme delle operazioni)
-->
<html>
    <head>
        <title><?= $vd->getTitolo() ?></title>
        <link rel="shortcut icon" href="../../images/favicon.ico">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link href="../../css/bootstrap.css" rel="stylesheet">
        <link href="../../css/login.css" rel="stylesheet">        
        <link href="../../css/sito.css" rel="stylesheet">
        <script type="text/javascript" src="../../js/jquery-2.0.3.js"></script>
        <script type="text/javascript" src="../../js/jquery-ui.js"></script>
        
        <?php
            $scripts = $vd->getScripts();
            require "$scripts";
        ?>
    </head>
    
    <body>
        
        <?php
            $navbar = $vd->getNavBarFile();
            require "$navbar";
        ?>
        <?php
            $header = $vd->getHeaderFile();
            require "$header";
        ?>
        <?php
            $content = $vd->getContentFile();
            require "$content";
        ?>
        

        <script src="../../js/bootstrap.js"></script>
    </body>
</html>
