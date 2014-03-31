<?php

include_once 'controller/BaseController.php';
//include_once 'controller/AdminController.php';
//include_once 'controller/CustomerController.php';
//include_once 'controller/RetailerController.php';
include_once 'controller/GuestController.php';
include_once 'controller/UserController.php';
include_once 'view/ViewDescriptor.php';


//Punto unico di accesso al sito
FrontController::dispatch($_REQUEST);

/**
 * Classe che controlla il punto unico di accesso all'applicazione
 */
class FrontController 
{
    
    //Costruttore
    public function __construct() 
    {
        
    }

    /**
     * Gestore delle richieste al punto unico di accesso all'applicazione
     * 
     * @param array $request contenente i parametri della richiesta
     */
    public static function dispatch(&$request) 
    {
        //Inizializzo la sessione come prima cosa (o riprendo quella precedente se c'è)
        session_start();
                
//        $_SESSION[BaseController::user] = null;
        
        if(isset($_REQUEST["page"])) 
        {
            switch($_REQUEST["page"]) 
            {
                case "guest":
                    //Se si è nella pagina di login, creo il controller di base
                    //per la ricezione degli input
                    $controller = new GuestController();
                    $controller->handleInput($request, $_SESSION);
                    break;
                
                case 'user':
                    //Se la pagina è della categoria user, creo il controller adeguato
                    $controller = new UserController();
                    
                    $session = &$controller->getSession($request);
                    
                    if(!isset($session)) 
                        self::write403();
                    
                    $controller->handleInput($request, $session);
                    break;

//                case 'admin':
//                    //Se la pagina è della categoria admin, creo il controller
//                    //per gli admin che si occupa di controllare gli input
//                    $controller = new AdminController();
//                                       
//                    $session = &$controller->getSession();
//                    
//                    if(!isset($session)) 
//                        self::write403();
//                    
//                    $controller->handleInput($request, $session);
//                    break;
//
//                case 'customer':
//                    //Se la pagina è della categoria customer, creo il controller
//                    //per i clienti che si occupa di controllare gli input
//                    $controller = new CustomerController();
//    
//                    $session = &$controller->getSession($request);
//                    
//                    if(!isset($session)) 
//                        self::write403();
//                    
//                    $controller->handleInput($request, $session);
//                    break;
//
//                case 'retailer':
//                    //Se la pagina è della categoria retailer, creo il controller
//                    //per i commercianti che si occupa di controllare gli input
//                    $controller = new RetailerController();
//                    
//                    $session = &$controller->getSession($request);
//  
//                    if(!isset($session)) 
//                        self::write403();
//                    
//                    $controller->handleInput($request, $session);
//                    break;

                default:
                    self::write404();
                    break;                    
            }
        } else 
        {
            self::write404();
        }
    }

    /**
     * Crea una pagina di errore quando il path specificato non esiste
     */
    public static function write404() 
    {
        header('HTTP/1.0 404 Not Found');
        $title = "File non trovato!";
        $message = "La pagina che hai richiesto non &egrave; disponibile";
        include_once('error.php');
        exit();
    }

    /**
     * Mostra un errore quando l'utente non ha i privilegi 
     * per accedere alla data pagina
     */
    public static function write403() 
    {
        header('HTTP/1.0 403 Forbidden');

        $viewDescriptor = new ViewDescriptor();
        
        $viewDescriptor->setTitle("Accesso negato");
        $viewDescriptor->setLogoutFile(basename(__DIR__) . '/../view/guest/logout.php');
        $viewDescriptor->setTabsFile(basename(__DIR__) . '/../view/guest/tabs.php');
        $viewDescriptor->setLeftSidebarFile(basename(__DIR__) . '/../view/guest/leftSidebar.php');
        $viewDescriptor->setRightSidebarFile(basename(__DIR__) . '/../view/guest/rightSidebar.php');
        $viewDescriptor->setContentFile(basename(__DIR__) .  '/../view/guest/content.php');
        
        $viewDescriptor->setErrorMessage("Accesso negato!");
         
        require basename(__DIR__) . '/../view/masterPage.php';
        
        exit();
    }

}

?>
