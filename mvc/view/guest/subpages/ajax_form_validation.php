<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

$json = array();

//Salvo i valori risultanti dalla validazione nei rispettivi campi dell'array associativo che "simula" un json e che verrà restituito da ajax
$json["isValidationOk"] = $isValidationOk;
$json["usernameMessage"] = $usernameMessage;
$json["passwordMessage"] = $passwordMessage;
$json["password2Message"] = $password2Message;
$json["emailMessage"] = $emailMessage;

//Mando il json al client
echo json_encode($json);

?>


