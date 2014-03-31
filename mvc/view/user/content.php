<?php

switch($viewDescriptor->getSubPage()) 
{
    case 'prova_user':
        include 'subpages/prova_user.php';

        break;
   
    default:
        include 'subpages/shoe_details.php';
        break; 
}
?>


