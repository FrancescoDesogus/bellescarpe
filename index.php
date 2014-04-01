<?php

//echo "poba";
//    $username = "bellescarpecod";
//    $password = "albero";
//    $host = "localhost";
//    $database = "my_bellescarpecod";
//
//      $db = mysql_connect($host, $username, $password) or die("Errore durante la connessione al database");
//    mysql_select_db($database, $db) or die("Errore durante la selezione del database");
//
//    $risultato = mysql_query("SELECT * FROM Scarpa")
//    or die("Query non valida: " . mysql_error());
//
//    $poba = mysql_fetch_object($risultato);
//
//    echo $poba->id_scarpa;
//    echo $poba->marca;
//    echo $poba->modello;


     
     //Codice per il QR code preso da qua: http://codematrix.altervista.org/archives/1143
     require("phpqrcode/qrlib.php");
     
     //Genero un id di un modello di scarpa a caso
     $randomId = rand(0, 10);
     
     $data = "http://bellescarpecod.altervista.org/mvc/index.php?page=guest&subpage=shoe_details&id=$randomId";
     
     $filename = 'qrcode'.md5($data.'|'."L".'|'."4").'.png';
     
     QRcode::png($data, $filename, "L", 4, 2);
     
     echo '<img src="'.$filename.'" /><hr/>';
     
     
     
     
//     echo "Dati della scarpa con id pari a 1: <br> <br>";
//     
//     if($shoe == null)
//     {
//        echo "Non ci sono scarpe... coddasa?";
//        
//     }
//     else {
//
//        //Stampo tutti i dati della scarpa con id = 1
//        echo "ID = ";
//        echo $shoe->getId();
//        echo "<br>";
//
//        echo "Marca = ";
//        echo $shoe->getBrand();
//        echo "<br>";
//
//        echo "Modello = ";
//        echo $shoe->getModel();
//        echo "<br>";
//
//        echo "Colore = ";
//        echo $shoe->getColor();
//        echo "<br>";
//
//        echo "Sesso = ";
//        echo $shoe->getSex();
//        echo "<br>";
//
//        echo "Prezzo = ";
//        echo $shoe->getPrice()." euro";
//        echo "<br>";
//
//
//        //Stampo tutte le categorie della scarpa; potrebbero essere più di una
//        $i = 0;
//
//        $categories = $shoe->getCategories();
//
//        for($i = 0; $i < count($categories); $i++) 
//        {
//           echo "Categoria".($i + 1)." = ";
//           echo $categories[$i];
//           echo "<br>";
//        }
//
//        echo "<br>";
//
//
//        //Stampo tutte le taglie presenti del modello, con relativa quantità disponibile per la data misura
//        $sizesAndQuantities = $shoe->getSizesAndQuantities();
//
//        foreach ($sizesAndQuantities as $size => $quantity) 
//        {
//           echo "Taglia".$size." => Quntita': ".$quantity;
//           echo "<br>";
//        }
//
//        echo "<br>";
//
//
//        //Stampo il path dei media della scarpa; di default è null
//        $mediaPath = $shoe->getMediaPath();
//
//        echo "MediaPath = ";
//
//        if(isset($mediaPath))
//            echo "not null";
//        else
//            echo "null";
//
//        echo "<br>";
//        echo "<br>";
//        echo "<br>";
//        
//        
//        
//     }
//     

?>