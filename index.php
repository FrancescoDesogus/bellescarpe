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