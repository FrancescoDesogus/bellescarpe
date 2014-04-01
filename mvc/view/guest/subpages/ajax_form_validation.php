<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

$json = array();

//Salvo i suggerimenti nel campo specificato dell'array associativo che
//"simula" un json
//$json["isValidationOk"] = $isValidationOk;
//$json["formFieldId"] = $formFieldId;
//$json["formFieldMessageId"] = $formFieldMessageId;
//$json["formFieldMessage"] = $formFieldMessage;

$json["isValidationOk"] = $isValidationOk;
$json["usernameMessage"] = $usernameMessage;
$json["passwordMessage"] = $passwordMessage;
$json["password2Message"] = $password2Message;
$json["emailMessage"] = $emailMessage;

//Mando il json al client
echo json_encode($json);

?>


