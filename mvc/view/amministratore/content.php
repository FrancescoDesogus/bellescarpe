<?php

switch ($vd->getPagina()) {
    case 'studente':
        switch ($vd->getSottoPagina()) {
            default:
                include_once 'view/studente/content.php';
                break;
        }
        break;
    
    case 'docente':
        switch ($vd->getSottoPagina()) {
            default:
                include_once 'view/docente/content.php';
                break;
        }
        break;

    case 'amministratore':
        switch ($vd->getSottoPagina()) {
            case 'studenti_cerca':
                include_once 'view/amministratore/studenti_cerca.php';
                break;
            
            case 'docenti_cerca':
                include_once 'view/amministratore/docenti_cerca.php';
                break;
            
            case 'dipartimenti':
                include_once 'view/amministratore/dipartimenti.php';
                break;
            
            case 'cdl':
                include_once 'view/amministratore/cdl.php';
                break;
            
            case 'user':
                include_once 'view/amministratore/user.php';
                break;
            
            case 'esami':
                include_once 'view/amministratore/esami.php';
                break;

            default :
                include_once 'view/amministratore/home.php';
        }
        break;

    default:
        include_once 'view/amministratore/home.php';
        break;
}
?>

