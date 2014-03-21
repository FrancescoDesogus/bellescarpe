<?php
    
switch($viewDescriptor->getSubPage()) 
{
    case 'shoe_details':
        include 'subpages/shoe_details.php';

        break;
    
    default:
        include 'subpages/home.php';
        break; 
}
?>


