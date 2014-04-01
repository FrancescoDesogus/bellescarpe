<?php

include_once 'BaseController.php';
include_once basename(__DIR__) . '/../model/UserFactory.php';
include_once basename(__DIR__) . '/../model/ShoeFactory.php';
include_once basename(__DIR__) . '/../model/Shoe.php';

/**
 * Classe che gestisce gli input di un utente di tipo cliente
 */
class UserController extends BaseController 
{
    //Costruttore
    public function __construct() 
    {
        parent::__construct();
    }

    
    /**
     * Metodo per gestire l'input dell'utente
     * 
     * @param type $request la richiesta da gestire
     * @param type $session array con le variabili di sessione
     */
    public function handleInput(&$request, &$session) 
    {                
        //Creo il descrittore della vista, dato che bisognerà caricare una pagina
        $viewDescriptor = new ViewDescriptor();

        //Imposto la pagina come quella posta nell'array delle richieste
        $viewDescriptor->setPage($request['page']);

        //Imposto il token per impersonare un utente (nel caso lo stia facendo)
        $this->setImpToken($viewDescriptor, $request);
 
        //Controllo se la sessione è attiva e l'utente è loggato
        if($this->isLoggedIn()) 
        {       
            //Recupero l'utente
            $user = $session[BaseController::user]; 
            
            
            /* Controllo a quale sotto pagina corrisponde
             * la pagina da visualizzare, per settare il viewDescriptor
             * in modo tale che carichi correntemente le sue parti.
             * Recupero quindi l'eventuale valore contenuto per la subpage
             * nell'array delle richieste e controllo a cosa corrisponde */
            
            if(isset($request["subpage"])) 
            {
                
                switch($request["subpage"]) 
                {
                    //Caso in cui bisogna mostrare il catalogo
                    case 'shoe_details':                 

                        break;

                    //Nel caso in cui la sottopagina non fosse nessuna delle precedenti, riporto alla home
                    default:
                        $viewDescriptor->setSubPage('home');
                        break;
                }
            }
            else
                $viewDescriptor->setSubPage('prova_user');
            

             //Controllo ora quale comando eseguire (se definito)
            if(isset($request["cmd"])) 
            {
                switch($request["cmd"]) 
                {
                    //Comando per il logout
                    case 'logout':
                        //Uso il metodo apposito e concludo la funzione del controller
                        $this->logout($viewDescriptor);
                                                
                        $controller = new GuestController();
                        
                        //Brutta cosa
                        $request["subpage"] = "prova2";

                        
                        $controller->handleInput($request, $session);
                    
                        return;
                        
                        break;

                    

                    //Se il comando specificato non è nessuno di quelli sopra, riporto alla home
                    default:
                        $viewDescriptor->setSubPage("home");
                }
            } 
        }
        
        
        $this->showPage($viewDescriptor, $session);
        include_once basename(__DIR__) . '/../view/masterPage.php';
    }
    

    /**
     * Restituisce l'array contentente la sessione per l'utente corrente 
     * (vero o impersonato)
     * 
     * @return array
     */
    public function &getSession($pRequest) 
    {             
        //Se l'array di sessione è settato e lo è anche l'elemento 'user' di esso,
        //vuol dire che l'utente è loggato
        if(isset($_SESSION) && array_key_exists(BaseController::user, $_SESSION)) 
        {            
            //Recupero l'user dall'array
            $user = $_SESSION[BaseController::user];
            
            if(isset($user))
            {    
                switch($user->getUserType())
                {
                    //Se l'utente è un cliente normale, ritorno semplicemente la sessione
                    case User::USER:
                        return $_SESSION;
                        
                    //Se l'utente è un'admin, vuol dire che lo sta impersonando
                    case User::ADMIN:                 
//                        if(isset($pRequest[BaseController::impersonation])) 
//                        {  
//                            //Recupero quindi l'indice salvato nella url
//                            $sessionIndex = $pRequest[BaseController::impersonation];
//                            
//                            //Recupero quindi l'utente a cui corrisponde tale indice
//                            $user = $_SESSION[$sessionIndex][BaseController::user]; 
//                            
//                            //Se nell'array di sessione esiste l'indice corrispondente al dato utente che si sta impersonando
//                            //e se l'utente è effettivamente un cliente, restituisco il suo array di sessione da usare nel CustomerController
//                            if(array_key_exists($sessionIndex, $_SESSION) && $user->getUserType() == User::CUSTOMER) 
//                                return $_SESSION[$sessionIndex];
//                        }   
                }
            }

        }
        
        $null = null;
        
        return $null;
    }

}

?>
