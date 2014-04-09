<?php

include_once 'mvc/model/Arduino.php';
     
//     //Codice per il QR code preso da qua: http://codematrix.altervista.org/archives/1143
//     require("phpqrcode/qrlib.php");
//     
//     //Genero un id di un modello di scarpa a caso
//     $randomId = rand(0, 10);
//     
//     $data = "http://bellescarpecod.altervista.org/mvc/index.php?page=guest&subpage=shoe_details&id=$randomId";
//     
//     $filename = 'qrcode'.md5($data.'|'."L".'|'."4").'.png';
//     
//     QRcode::png($data, $filename, "L", 4, 2);
//     
//     echo '<img src="'.$filename.'" /><hr/>';
//echo "doing";

    

//  
    if(isset($_REQUEST['albero'])) 
        Arduino::light($_REQUEST['albero']);

//    $string = '#!po"po£po$po%po&po/po(poIpoKpo;poMpoNpoBpoVpoCpoXpoZpoApoQpo!';
//
//    while(true)
//        Arduino::light($string);


?>

<div class="input-form">
    <h2 class="icon-title h-registration">Registrazione</h2>

    <form method="post" id="registration_form" action="index.php">
        <div class="username_form_div">
            <label for="form_username"><strong>Albero: </strong></label>
            <input class="inputBar" type="text" name="albero" id="form_albero" value=""/>
            
        </div>
        
        <div class="buttonCenter" id="registration_button">
            <input class="buttonBigger saveChangesButton" type="submit" value="Send"/>
        </div>
    </form>
</div>
