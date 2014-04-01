<?php

include_once basename(__DIR__) . '/../view/ViewDescriptor.php';
//include_once basename(__DIR__) . '/../model/User.php';
//include_once basename(__DIR__) . '/../model/UserFactory.php';
include_once basename(__DIR__) . '/../model/Shoe.php';
include_once basename(__DIR__) . '/../model/ShoeFactory.php';
include_once 'BaseController.php';

include_once basename(__DIR__) . '/../../facebook-php-sdk/facebook.php';



/**
 * Controller che gestisce i visitatori non loggati al sito
 */
class GuestController extends BaseController 
{  
    //Gli id del sito registrato su Facebook
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
        
        
        /* Setto inizialmente che ajax non è attivo; se invece lo fosse, il valore
         * reale verrà settato più in basso nel codice. Questo è per assicurarmi che
         * in caso non sia attivo venga caricata la vista corretta */
        $isAjaxActive = false;
        
        
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
                
                //Pagina di prova che contiene il form per il login (sia normale che con facebook) o manda alla pagina di registrazione
                case 'prova2':
                    $viewDescriptor->setSubPage('prova2');
                                        
                    //Creo l'oggetto Facebook, dal quale posso recuperare il link per il login attraverso facebook. Per creare l'oggetto inserisco
                    //gli id specifici del sito
                    $facebook   = new Facebook(array(
                        'appId' => self::$FACEBOOK_APP_ID,
                        'secret' => self::$FACEBOOK_SECRET_ID,
                        'cookie' => true,
                    ));
                                        
                    /* Creo i parametri da usare per poter recuperare la url per il login con Facebook, passando l'id dell'app, i dati che si richiederà 
                     * all'utente di utilizzare (in questo caso solo l'email, oltre i valori di default come nome, cognome ecc.), e il link a cui Facebook
                     * deve reindirizzare l'utente dopo il login (in questo caso una pagina del nostro sito per il login */
                    $params = array(
                        'client_id' => self::$FACEBOOK_APP_ID,
                        'scope' => 'email',
                        'redirect_uri' => 'http://bellescarpecod.altervista.org/mvc/index.php?page=guest&subpage=prova2&cmd=login&mode=facebook'
                    );
                                        
                    //Recupero quindi la url per il login tramite Facebook, che verrà usata nella view
                    $loginUrl = $facebook->getLoginUrl($params);
                                        
                    break;
                
                //Pagina che contiene il form per la registrazione
                case 'registration':
                    $viewDescriptor->setSubPage('registration');
                    
                    //I valori dello username e dell'email potrebbero essere già completati se si sta facendo una registrazione tramite facebook; per questo 
                    //motivo i valori dei rispettivi form devono essere recueprati in php. Di default sono stringhe vuote
                    $username = '';
                    $email = '';
                    
                    //Se la registraizone è fatta tramite facebook, deve essere impedita la modifica dell'email; una variabile nella view si occuperà di bloccare
                    //la modifica del campo del form in tal caso. Di default la variabile è una stringa vuota, in modo da permettere la modifica
                    $isReadOnly = "";
                    
                    break;
                
                default:
                    $viewDescriptor->setSubPage('home');
            }
        }
        else
        {                               
            $viewDescriptor->setSubPage('prova2');
        }
        
                
        /* Gestione degli eventuali comandi contenuti nella richiesta */ 
        if(isset($request["cmd"])) 
        {   
            //Se scatta l'if, è stato ricevuto un comando; controllo quindi quale
            switch ($request["cmd"]) 
            {
                //Caso in cui si deve eseguire il login dell'utente
               case 'login':
                    //Controllo se per il login era stato specificato "facebook" come modalità; in tal caso provo ad eseguirlo in questo modo
                    if(isset($request["mode"]) && $request["mode"] = 'facebook') 
                    {
                        //Creo l'oggetto Facebook, dal quale posso prendere le informazioni sull'utente
                        $facebook   = new Facebook(array(
                            'appId' => self::$FACEBOOK_APP_ID,
                            'secret' => self::$FACEBOOK_SECRET_ID,
                            'cookie' => true,
                        ));
                        
                        //Recupero l'id dell'utente attualmente connesso a Facebook 
                        $userFacebookId = $facebook->getUser();

                        //Se l'id è valido, scatta questa if e so che è l'id dell'utente facebook che mi interessa
                        if($userFacebookId)
                        {
                            //Provo a recuperare l'utente con l'id facebook specificato dal db
                            $user = UserFactory::loadFacebookUser($userFacebookId);
                            
                            //Se la variabile user è settata, procedo con il login
                            if(isset($user)) 
                            {                                
                                //Lo salvo nell'array di sessione...
                                $_SESSION[self::user] = $user;

                                //...segno che la pagina che si visualizzerà è la home dell'utente...
                                $viewDescriptor->setSubpage('prova_user');

                                //...e carico quindi le parti della pagina
                                $this->showPage($viewDescriptor, $_SESSION);
                            } 
                            /* Altrimenti vuol dire che l'id di facebook è valido, ma l'utente al quale corrisponde non si è ancora registrato al nostro sito
                             * utilizzando quell'account, quindi devo mandare alla pagina di registrazione */
                            else 
                            {
                                //Messaggio temporaneo per dire all'utente di registrarsi
                                echo "E' la prima volta che ti connetti con Facebook al sito. Crea un nuovo account in modo da associarlo. ";
                                
                                //Questa variabile è usata nella view per bloccare la modifica del campo dell'email, che dovrà rimanere uguale
                                //all'email che l'utente ha usato per registrarsi a Facebook
                                $isReadOnly = "readonly";
                                
                                //Setto come sottopagina quella della registrazione
                                $viewDescriptor->setSubPage('registration');
                                
                                try 
                                {
                                    //Provo a recuperare le informazion dell'utente
                                    $user_profile = $facebook->api('/me');
                                }
                                catch (Exception $e) 
                                {
                                    //Bisogna far qualcosa di diverso qua per la gestione dell'errore
                                    echo $e->getMessage();
                                    exit();
                                }

                                //Recupero username e email in modo da riempire i relativi form nella vista registration.php
                                $username = $user_profile["username"];
                                $email = $user_profile["email"];
                            }
                        }
                        //Da fare: gestire l'errore
                        else
                            echo "C'è stato qualche problema... non è stato possibile recuperare l'id facebook dell'utente";
                    }
                    else
                    {
                        $username = isset($request['user']) ? $request['user'] : '';
                        $password = isset($request['password']) ? $request['password'] : '';

//                        $this->login($viewDescriptor, $username, $password);
                        
                        //Controllo i dati inseriti corrispondono ad un utente
                        $user = UserFactory::loadUser($username, $password);

                        //Se la variabile user è settata, procedo con il login
                        if(isset($user)) 
                        {
                            //Se l'utente esiste, lo salvo nell'array di sessione...
                            $_SESSION[self::user] = $user;

                            //...segno che la pagina che si visualizzerà è la home dell'utente...
                            $viewDescriptor->setSubpage('prova_user');

                            //...e carico quindi le parti della pagina
                            $this->showPage($viewDescriptor, $session);
                        } 
                        //Altrimenti inserisco un errore da far apparire nella pagina di login e la ricarico
                        else 
                        {
                            $pViewDescriptor->setErrorMessage("Utente sconosciuto o password errata");
                            $this->showPage($viewDescriptor, $session);
                        }
                    }
                  
                    break;
                    
                //Caso in cui il visitatore vuole registrarsi; vale sia per i clienti
                //che per i commercianti
                case 'register':                    
                    //Se il visitatore vuole registrarsi, mi assicuro che tutti i campi
                    //siano occupati e plausibili prima di effettuare la registrazione
                    if(!isset($request['username']) || $request['username'] == "" || UserFactory::isUsernameOccupied($request['username'])) 
                    {
                        $viewDescriptor->setErrorMessage("Il campo dello username non è valido o è già in uso");
                    }
                    else if(!isset($request['password']) || $request['password'] == "")
                    {
                        $viewDescriptor->setErrorMessage("Il campo della password è vuoto");
                    }
                    else if(!isset($request['password2']) || $request['password2'] == "" || ($request['password'] != $request['password2']))
                    {
                        $viewDescriptor->setErrorMessage("Le due password inserite non sono uguali");
                    }
                    else if(!isset($request['email']) || $request['email'] != "" || !filter_var($request['email'], FILTER_VALIDATE_EMAIL) || UserFactory::isEmailAlreadyUsed($request['email'])) 
                    {
                        $viewDescriptor->setErrorMessage("L'email inserita non è valida o è già in uso da un account");
                    }
                    else
                    {
                        $username = htmlentities($request['username']);
                        $password = htmlentities($request['password']);
                        $password2 = htmlentities($request['password2']);
                        $email = $request['email'];      


                        $facebook   = new Facebook(array(
                            'appId' => self::$FACEBOOK_APP_ID,
                            'secret' => self::$FACEBOOK_SECRET_ID,
                            'cookie' => true,
                        ));

                        $userFacebookId = $facebook->getUser();

                        if(!$userFacebookId)
                            $userFacebookId = null;

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
                         
                    }
                    
                    
//                    //Se il visitatore vuole registrarsi, mi assicuro che tutti i campi
//                    //siano occupati e plausibili prima di effettuare la registrazione
//                    if(isset($request['username']) && $request['username'] != "") 
//                    {
//                        $username = htmlentities($request['username']);
//                                                
////                        if(UserFactory::isUsernameOccupied($username))
////                            $viewDescriptor->setErrorMessage ("Lo username inserito è già in uso da un altro utente.");
//                        if(isset($request['password']) && $request['password'] != "") 
//                        {
//                            $password = htmlentities($request['password']);
//                            
//                            if(isset($request['password2']) && $request['password2'] != "") 
//                            {
//                                $password2 = htmlentities($request['password2']);
//                                                                                            
//                                if(isset($request['email']) && $request['email'] != "") 
//                                {
//                                    $email = $request['email'];
//
//
//                                    $facebook   = new Facebook(array(
//                                        'appId' => self::$FACEBOOK_APP_ID,
//                                        'secret' => self::$FACEBOOK_SECRET_ID,
//                                        'cookie' => true,
//                                    ));
//
//                                    $userFacebookId = $facebook->getUser();
//
//                                    if(!$userFacebookId)
//                                        $userFacebookId = null;
//
//                                //Controllo altri eventuali errori nel form col metodo apposito
////                                        if(!$this->lookForMistakesInForm($password, $password2, $email, $civicNumber, $cap, $credit, $viewDescriptor))
////                                        {
//                                    //Effettuo la registrazione dell'utente vera e propria nel database; 
//                                    //il metodo addUser mi ritorna quindi l'utente
//                                    $user = UserFactory::addUser($username, $password, $email, $userFacebookId);
//
//                                    /* Se lo user è null, ci sono stati problemi col database; se non fosse null,
//                                     * salvo l'utente in sessione; questo vuol dire che la prossima volta che
//                                     * verrà caricata la pagina, verrà mostrata la home dell'utente registrato */
//                                    if(isset($user))
//                                        $session[BaseController::user] = $user;
//                                    else
//                                        $viewDescriptor->setErrorMessage("Ci sono stati problemi nella registrazione. Riprovare più tardi.");
////                                        }
//                                }
//                                else
//                                    $viewDescriptor->setErrorMessage("Almeno un campo del form è vuoto.");
//                            }
//                            else
//                                $viewDescriptor->setErrorMessage("Almeno un campo del form è vuoto.");
//                        }
//                        else
//                            $viewDescriptor->setErrorMessage("Almeno un campo del form è vuoto.");
//                    }
//                    else
//                        $viewDescriptor->setErrorMessage("Almeno un campo del form è vuoto.");
                              
                    break;
                    
                //Comando per il recupero dei suggerimenti per la barra di ricerca tramite ajax
                case 'username_validation_ajax':
                    //Controllo che il parametro della search bar passato tramite ajax esista
                    if(isset($request['form_fields']))
                    {
                        parse_str($request['form_fields'], $form_fields);
                        
                        $isValidationOk = true;
                        $usernameMessage = '';
                        $passwordMessage = '';
                        $password2Message = '';
                        $emailMessage = '';
                        
                        $username = $form_fields['username'];
                        $password = $form_fields['password'];
                        $password2 = $form_fields['password2'];
                        $email = $form_fields['email'];
                        
                        if($username == '')
                        {
                            $isValidationOk = false;
                            
                            $usernameMessage = "Inserisci un cazzo di username, pezzo di merda";
                        }
                        else if(UserFactory::isUsernameOccupied($username))
                        {
                            $isValidationOk = false;
                            
                            $usernameMessage = "Il fottuto username è già in uso, coglione";
                        }
                        
                        
                        if($password == '')
                        {
                            $isValidationOk = false;
                            
                            $passwordMessage = "Inserisci una password, conchè minca";
                        }
                        else if($password != $password2)
                        {
                            $isValidationOk = false;
                            
                            $password2Message = "La password non coincide con l'altra, vattene a fanculo";
                        }
                        
                        if($email == '')
                        {
                            $isValidationOk = false;
                            
                            $emailMessage = "Brutto mettere una cazzo di email quando ti viene chiesto??";
                        }
                        else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                        {
                            $isValidationOk = false;
                            
                            $emailMessage = "L'email inserita non è valida, figlio di buona donna";
                        }
                        else if(UserFactory::isEmailAlreadyUsed($email))
                        {
                            $isValidationOk = false;
                            
                            $emailMessage = "L'email è già registrata al sito, fill'e bagassa";
                        }
                        
//                        //Recupero l'input utente
//                        $inputText = $request['username'];
//                                     
//                        /* $suggestions è il valore che passo al json. E' una unica stringa 
//                         * contenente la lista dei libri; ogni elemento è un link html 
//                         * al corrispondente libro del catalogo */
//                        $formFieldMessage = "";
//                        
//                        $formFieldId = "form_username";
//                        
//                        $formFieldMessageId = "validation_username_info";
//
//                        //Recupero la lista dei libri che corrisponde al testo inserito
//                        $isValidationOk = !UserFactory::isUsernameOccupied($inputText);
//
//                        if(!$isValidationOk)
//                        {
//                            $formFieldMessage = "poba, username occupato bitch";
//                        }
                        //Stabilisco che si sta usando ajax; servirà dopo questo switch per richiamare
                        //la vista ajax
                        $isAjaxActive = true;
                    } 
                    
                    break;
                    
                //Se non è nessuna delle precedenti, riporto il visitatore alla home
                default: 
                    $viewDescriptor->setSubPage('home');
            }
        } 
        
//        $this->showPage($viewDescriptor, $session);
//        include_once basename(__DIR__) . '/../view/masterPage.php';
        
        
        //Controllo se ajax è attivo; in tal caso invece di caricare la pagina vera e propria
        //devo caricare la pagina specifica per ajax
        if($isAjaxActive) 
            include_once basename(__DIR__) . '/../view/guest/subpages/ajax_form_validation.php';
        else 
        {
            $this->showPage($viewDescriptor, $session);
            include_once basename(__DIR__) . '/../view/masterPage.php';
        }
    }

}
?>
