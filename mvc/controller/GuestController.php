<?php

include_once basename(__DIR__) . '/../view/ViewDescriptor.php';
//include_once basename(__DIR__) . '/../model/User.php';
//include_once basename(__DIR__) . '/../model/UserFactory.php';
include_once basename(__DIR__) . '/../model/Shoe.php';
include_once basename(__DIR__) . '/../model/ShoeFactory.php';
include_once 'BaseController.php';

//include_once basename(__DIR__) . '/../../facebook-php-sdk/facebook.php';



/**
 * Controller che gestisce i visitatori non loggati al sito
 */
class GuestController extends BaseController 
{  
    public static $FACEBOOK_APP_ID = '281784095318774';
    public static $FACEBOOK_SECRET_ID = 'cec392f8e3d40ac5e66e366a85a3730f';
    
    //Costruttore
    public function __construct() 
    {
        
    }

    /**
     * Metodo per gestire l'input dell'utente.
     * 
     * @param type $request la richiesta da gestire
     * @param type $session array con le variabili di sessione
     */
    public function handleInput(&$request, &$session) 
    {            
        //Creo il descrittore della vista, che verrà riempito a seconda della richiesta corrente
        $viewDescriptor = new ViewDescriptor();

        //Imposto la pagina come quella posta nell'array delle richieste
        $viewDescriptor->setPage($request['page']);
        
        //Se l'utente è loggato...
        if($this->isLoggedIn()) 
        {
            //...lo recupero (variabile usata nella view della home)...
//            $user = $session[self::user];
            
            $controller = new UserController();
            
            $request["subpage"] = null;
            
            $controller->handleInput($request, $session);
            
            return;
            
            //...e mostro la sua rispettiva home
//            $this->showPage($viewDescriptor, $session);
        }
        //Altrimenti controllo dove mi trovo attualmente nel sito
        else if(isset($request["subpage"])) 
        {               
            switch ($request["subpage"]) 
            {
                //Caso in cui bisogna mostrare il catalogo
                case 'shoe_details':                 
                    $viewDescriptor->setSubPage('shoe_details');

                    $shoe = ShoeFactory::getShoeFromId(1);
                    
                    break;
                
                case 'prova':
                    
                    $viewDescriptor->setSubPage('prova');
                    
                    
                    $appid      = '281784095318774';
                    $appsecret  = "cec392f8e3d40ac5e66e366a85a3730f";
                    
                    $facebook   = new Facebook(array(
                        'appId' => $appid,
                        'secret' => $appsecret,
                        'cookie' => true
                    ));
                    
                    $fbuser = $facebook->getUser();
                    
                    if ($fbuser) {
                        echo 'biatch';
                        
                        try {
                            $user_profile = $facebook->api('/me');
                        }
                        catch (Exception $e) {
                            echo $e->getMessage();
                            exit();
                        }
                        
                        $user_fbid  = $fbuser;
                        $user_email = $user_profile["email"];
                        $user_fnmae = $user_profile["first_name"];
                        $user_image = "https://graph.facebook.com/".$user_fbid."/picture?type=large";
                        
                        
                        echo "<br>".$user_email."<br>";
                        /* Save the user details in your db here */
                    }
                    else
                         echo "<br>".'fbuser era false'."<br>";
                    
                    break;
                
                case 'prova2':
                    $viewDescriptor->setSubPage('prova2');
                                        
                    $facebook   = new Facebook(array(
                        'appId' => self::$FACEBOOK_APP_ID,
                        'secret' => self::$FACEBOOK_SECRET_ID,
                        'cookie' => true,
                    ));
                                        
                    $params = array(
                        'client_id' => self::$FACEBOOK_APP_ID,
                        'scope' => 'email',
                        'redirect_uri' => 'http://bellescarpecod.altervista.org/mvc/index.php?page=guest&subpage=login&mode=facebook'
                    );
                                        
                    $loginUrl = $facebook->getLoginUrl($params);
                                        
                    break;
                
                case 'login':
                    $viewDescriptor->setSubPage('login');
                    
                    if(isset($request["mode"]) && $request["mode"] = 'facebook') 
                    {
                        $facebook   = new Facebook(array(
                            'appId' => self::$FACEBOOK_APP_ID,
                            'secret' => self::$FACEBOOK_SECRET_ID,
                            'cookie' => true,
                        ));
                        
                        $userFacebookId = $facebook->getUser();

                        if($userFacebookId)
                        {
                            $user = UserFactory::loadFacebookUser($userFacebookId);
                            
                            //Se la variabile user è settata, procedo con il login
                            if(isset($user)) 
                            {                                
                                //Se l'utente esiste, lo salvo nell'array di sessione...
                                $_SESSION[self::user] = $user;

                                //...segno che la pagina che si visualizzerà è la home dell'utente...
                                $viewDescriptor->setSubpage('prova_user');

                                //...e carico quindi le parti della pagina
                                $this->showPage($viewDescriptor, $_SESSION);
                            } 
                            //Altrimenti inserisco un errore da far apparire nella pagina di login e la ricarico
                            else 
                            {
//                                $pViewDescriptor->setErrorMessage("Utente sconosciuto o password errata");
                                
                                echo "E' la prima volta che ti connetti con Facebook al sito. Crea un nuovo account in modo da associarlo. ";
                                
                                $isReadOnly = 1;
                                
                                $viewDescriptor->setSubPage('registration');
                                
                                try 
                                {
                                    $user_profile = $facebook->api('/me');
                                }
                                catch (Exception $e) 
                                {
                                    echo $e->getMessage();
                                    exit();
                                }

                                $user_fbid  = $fbuser;

                                $username = $user_profile["username"];
                                $email = $user_profile["email"];
                                
//                                $this->showPage($pViewDescriptor, $_SESSION);
                            }
                           
                        }
                        else
                            echo "C'è stato qualche problema... non è stato possibile recuperare l'id facebook dell'utente";
                    }
                    
                    
                    break;
                
                case 'registration':
                    $viewDescriptor->setSubPage('registration');
                    
                    $username = '';
                    $email = '';
                    
                    break;
                
                default:
                    $viewDescriptor->setSubPage('home');
            }
        }
        else
        {                               
            $viewDescriptor->setSubPage('prova2');
        }
        
                
        /* gestione dei comandi; tutte le variabili che vengono create senza essere utilizzate 
           direttamente in questo switch, sono quelle che vengono poi lette
           dalla vista, ed utilizzano le classi del modello */ 
        if(isset($request["cmd"])) 
        {   
            //Se scatta l'if, si è ricevuto un comando; controllo quindi quale
            switch ($request["cmd"]) 
            {
                //Comando per il recupero dei suggerimenti per la barra di ricerca tramite ajax
                case 'search_suggestions_ajax':
                    
                    break;

                //Caso in cui l'utente abbia effettuato una ricerca avanzata
                case 'search':

                    break;

                case 'login':
//                    $username = isset($request['user']) ? $request['user'] : '';
//                    $password = isset($request['password']) ? $request['password'] : '';
//                                        
//                    $this->login($viewDescriptor, $username, $password);
//              
//                    // questa variabile viene poi utilizzata dalla vista
//                    if($this->isLoggedIn())
//                        $user = $_SESSION[self::user];
                    break;
                    
                //Caso in cui il visitatore vuole registrarsi; vale sia per i clienti
                //che per i commercianti
                case 'register':                    
                    //Se il visitatore vuole registrarsi, mi assicuro che tutti i campi
                    //siano occupati e plausibili prima di effettuare la registrazione
                    if(isset($request['username']) && $request['username'] != "") 
                    {
                        $username = htmlentities($request['username']);
                                                
//                        if(UserFactory::isUsernameOccupied($username))
//                            $viewDescriptor->setErrorMessage ("Lo username inserito è già in uso da un altro utente.");
                        if(isset($request['password']) && $request['password'] != "") 
                        {
                            $password = htmlentities($request['password']);
                            
                            if(isset($request['password2']) && $request['password2'] != "") 
                            {
                                $password2 = htmlentities($request['password2']);
                                                                                            
                                if(isset($request['email']) && $request['email'] != "") 
                                {
                                    $email = $request['email'];


                                    $facebook   = new Facebook(array(
                                        'appId' => self::$FACEBOOK_APP_ID,
                                        'secret' => self::$FACEBOOK_SECRET_ID,
                                        'cookie' => true,
                                    ));

                                    $userFacebookId = $facebook->getUser();

                                    if(!$userFacebookId)
                                        $userFacebookId = null;

                                //Controllo altri eventuali errori nel form col metodo apposito
//                                        if(!$this->lookForMistakesInForm($password, $password2, $email, $civicNumber, $cap, $credit, $viewDescriptor))
//                                        {
                                    //Effettuo la registrazione dell'utente vera e propria nel database; 
                                    //il metodo addUser mi ritorna quindi l'utente
                                    $user = UserFactory::addUser($username, $password, $email, $userFacebookId);

                                    /* Se lo user è null, ci sono stati problemi col database; se non fosse null,
                                     * salvo l'utente in sessione; questo vuol dire che la prossima volta che
                                     * verrà caricata la pagina, verrà mostrata la home dell'utente registrato */
                                    if(isset($user))
                                        $session[BaseController::user] = $user;
                                    else
                                        $viewDescriptor->setErrorMessage("Ci sono stati problemi nella registrazione. Riprovare più tardi.");
//                                        }
                                }
                                else
                                    $viewDescriptor->setErrorMessage("Almeno un campo del form è vuoto.");
                            }
                            else
                                $viewDescriptor->setErrorMessage("Almeno un campo del form è vuoto.");
                        }
                        else
                            $viewDescriptor->setErrorMessage("Almeno un campo del form è vuoto.");
                    }
                    else
                        $viewDescriptor->setErrorMessage("Almeno un campo del form è vuoto.");
                              
                    break;
                    
                //Se non è nessuna delle precedenti, riporto il visitatore alla home
                default: 
                    $viewDescriptor->setSubPage('home');
            }
        } 
        
        $this->showPage($viewDescriptor, $session);
        include_once basename(__DIR__) . '/../view/masterPage.php';
    }

}
?>
