<?php

switch($viewDescriptor->getSubPage()) 
{
    case 'shoe_details':
        include 'subpages/shoe_details.php';

        break;
    
    case 'prova':
        include 'subpages/prova.php';

        break;
    
    case 'prova2':
        include 'subpages/prova2.php';

        break;
    
    case 'registration':
        include 'subpages/registration.php';

        break;
    
    default:
        include 'subpages/home.php';
        break; 
}
?>


