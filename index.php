<?php
    $username = "bellescarpecod";
    $password = "albero";
    $host = "localhost";
    $database = "my_bellescarpecod";

      $db = mysql_connect($host, $username, $password) or die("Errore durante la connessione al database");
    mysql_select_db($database, $db) or die("Errore durante la selezione del database");

    $risultato = mysql_query("SELECT * FROM Scarpa")
    or die("Query non valida: " . mysql_error());

    $poba = mysql_fetch_object($risultato);

    echo $poba->id_scarpa;
    echo $poba->marca;
    echo $poba->modello;
?>

<div id="slideshow" class="carousel slide">
 <div class="carousel-inner">
  <div class="item active">
   <img src="..." alt="...">
   <div class="carousel-caption">
    ...
   </div>
  </div>
  <div class="item active">
   <img src="..." alt="...">
   <div class="carousel-caption">
    ...
   </div>
  </div>
  <div class="item active">
   <img src="..." alt="...">
   <div class="carousel-caption">
    ...
   </div>
  </div>
 </div>
 
<!-- Indicatori di posizione -->
 <ol class="carousel-indicators">
  <li data-target="#slideshow" data-slide-to="0" class="active"></li>
  <li data-target="#slideshow" data-slide-to="1"></li>
  <li data-target="#slideshow" data-slide-to="2"></li>
 </ol>
 
<!-- Controlli -->
 <a class="left carousel-control" href="#slideshow" data-slide="prev">
 <span class="icon-prev"></span>
 </a>
 <a class="right carousel-control" href="#slideshow" data-slide="next">
 <span class="icon-next"></span>
 </a>
</div>