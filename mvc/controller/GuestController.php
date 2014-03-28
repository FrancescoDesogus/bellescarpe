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
            $user = $session[self::user];

            //...e mostro la sua rispettiva home
            $this->showPage($viewDescriptor, $session);
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
                    
                    if(isset($request["name"])) 
                    {
                        echo "nome: ".$request["name"]."<br>";
                        echo "username: ".$request["username"]."<br>";
                        echo "id: ".$request["id"]."<br>";
                        echo "email: ".$request["email"]."<br>";
                    }
                    else
                        echo "<br> :( <br>";
                    
                    $appid      = '281784095318774';
                    $appsecret  = "cec392f8e3d40ac5e66e366a85a3730f";
                    
                    $facebook   = new Facebook(array(
                        'appId' => $appid,
                        'secret' => $appsecret,
                        'cookie' => true,
                    ));
                    
                    $fbuser = $facebook->getUser();
                    
                    if ($fbuser) {
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
                        
                        echo "<br>".$user_profile["first_name"]."<br>";
                        echo "<br>".$user_profile["last_name"]."<br>";
                        echo "<br>".$user_email."<br>";
         
                        /* Save the user details in your db here */
                    }
                    else
                         echo "<br>".'fbuser era false'."<br>";
                    
                    break;
                
                case 'login':
                    $viewDescriptor->setSubPage('login');
                    
                    break;
                
                case 'registration':
                    $viewDescriptor->setSubPage('registration');
                    
                    
                    echo "lololol";
            
            if ($_REQUEST['signed_request'])
                    {
                        $response = $this->parse_signed_request($_REQUEST['signed_request'], 'cec392f8e3d40ac5e66e366a85a3730f');//secret

                        if($response)
                        {
                            //Fields values
                            $email=$response['registration']['email'];
                            $name=$response['registration']['name'];
                            $gender=$response['registration']['gender'];
                            $user_fb_id=$response['user_id'];
                            $location=$response['registration']['location']['name'];
                            $bday = $response['registration']['birthday'];

                            //print entire array response
                            echo '<h3>Response Array</h3>';
                            echo '<pre>';
                            print_r($response);
                            echo '</pre>';

                            //print values
                            echo '<h3>Fields Values</h3>';
                            echo 'email: ' . $email . '<br />';
                            echo 'Name: ' . $name . '<br />';
                            echo 'Gender: ' . $gender . '<br />';
                            echo 'Facebook Id: ' . $user_fb_id . '<br />';
                            echo 'Location: ' . $location . '<br />';
                            echo 'Birthday: ' . $bday . '<br />';

                        }
                    }
                    
                    
//                    if ($_REQUEST['signed_request'])
//                    {
//                        $response = parse_signed_request($_REQUEST['signed_request'], 'cec392f8e3d40ac5e66e366a85a3730f');//secret
//
//                        if($response)
//                        {
//                            //Fields values
//                            $email=$response['registration']['email'];
//                            $name=$response['registration']['name'];
//                            $gender=$response['registration']['gender'];
//                            $user_fb_id=$response['user_id'];
//                            $location=$response['registration']['location']['name'];
//                            $bday = $response['registration']['birthday'];
//
//                            //print entire array response
//                            echo '<h3>Response Array</h3>';
//                            echo '<pre>';
//                            print_r($response);
//                            echo '</pre>';
//
//                            //print values
//                            echo '<h3>Fields Values</h3>';
//                            echo 'email: ' . $email . '<br />';
//                            echo 'Name: ' . $name . '<br />';
//                            echo 'Gender: ' . $gender . '<br />';
//                            echo 'Facebook Id: ' . $user_fb_id . '<br />';
//                            echo 'Location: ' . $location . '<br />';
//                            echo 'Birthday: ' . $bday . '<br />';
//
//                        }
//                    }
                    
                    break;
                
                default:
                    $viewDescriptor->setSubPage('home');
            }
        }
        else
        {
            $viewDescriptor->setSubPage('shoe_details');
        }
        
                
        /* gestione dei comandi; tutte le variabili che vengono create senza essere utilizzate 
           direttamente in questo switch, sono quelle che vengono poi lette
           dalla vista, ed utilizzano le classi del modello */ 
        if(isset($request["cmd"])) 
        {   
            //Se scatta l'if, si è ricevuto un comando; controllo quindi quale
            switch ($request["cmd"]) 
            {
                //Comando per mostare un libro generico dal catalogo
                case 'show_book':
                    if(isset($request["bookId"]) && filter_var($request["bookId"], FILTER_VALIDATE_INT) && 
                       isset($request["retailerId"]) && filter_var($request["retailerId"], FILTER_VALIDATE_INT))
                    {
                        //Recupero l'id del libro da mostrare
                        $bookId = $request["bookId"];

                        //Controllo che il libro sia effettivamente nel catalogo e nel caso lo recupero
                        $book = BookFactory::findBookViaId($bookId);

                        //Se il libro è stato trovato nel catalogo procedo
                        if(isset($book))      
                        {
                            $retailerId = $request["retailerId"];

                            //Recupero  il numero di copie che il commerciante ha
                            //disponibili per questo libro
                            $bookQuantity = BookFactory::getBookQuantityByRetailerId($bookId, $retailerId);

                            /* Se il risultato è >= 0 vuol dire che è tutto ok; altrimenti c'è
                             * un errore (ad esempio l'id del commerciante non esiste, oppure
                             * esiste ma il commerciante che risulta non vende questo determinato libro);
                             * se è tutto ok salvo la quantità disponibile, da visualizzare nella view */
                            if($bookQuantity >= 0)
                            {
                                $book->setQuantity($bookQuantity);

                                //Recupero anche il prezzo del libro stabilito dal commerciante
                                $book->setPrice(BookFactory::getBookPriceByRetailer($book->getId(), $retailerId));


                                //Recupero anche il prezzo dell'offerta che questo commerciante ha di questo libro, 
                                //qualora esistesse; se non ci fosse, viene settato null
                                $offerPrice = OfferFactory::getBookOfferPriceByRetailer($book->getId(), $retailerId);
                            }
                            else 
                            {  
                                //Imposto il libro a null, in modo da mostrare solo il messaggio
                                //di errore nella view
                                $book = null;

                                $viewDescriptor->setErrorMessage("Il commerciante in questione non esiste oppure non vende copie di questo libro!");  
                            }
                        }
                        else
                             $viewDescriptor->setErrorMessage("Il libro specificato non è presente nel catalogo!");     
                    }
                    //Se l'id del libro o del commerciante non è stato settato, lo segnalo all'user
                    else
                        $viewDescriptor->setErrorMessage("Non è stato specificato un libro o un commerciante!");

                    break;
                    
                //Comando per il recupero dei suggerimenti per la barra di ricerca tramite ajax
                case 'search_suggestions_ajax':
                    //Controllo che il parametro della search bar passato tramite ajax esista
                    if(isset($request['searchBar']))
                    {
                        //Recupero l'input utente
                        $inputText = $request['searchBar'];
                                     
                        /* $suggestions è il valore che passo al json. E' una unica stringa 
                         * contenente la lista dei libri; ogni elemento è un link html 
                         * al corrispondente libro del catalogo */
                        $suggestions = "";

                        //Recupero la lista dei libri che corrisponde al testo inserito
                        $occurences = BookFactory::searchBookByName($inputText);

                        
                        foreach($occurences as $book)
                        {
                            /* Inserisco il codice html all'interno della variabile suggestions, in modo da
                             * mostrare una lista di link. Devo quindi concatenare tutte le stringhe del ciclo 
                             * in modo tale che il risultato visualizzato sia corretto */
                            if($suggestions == "")
                                $suggestions = "<a href='guest/book_by_retailers?bookId=".$book->getId()."' class='suggestion' >".$book->getName()."</a>";
                            else
                                $suggestions = $suggestions."</br><a href='guest/book_by_retailers?bookId=".$book->getId()."' class='suggestion' >".$book->getName()."</a>";
                        }
                    }
                    
                    //Stabilisco che si sta usando ajax; servirà dopo questo switch per richiamare
                    //la vista ajax
                    $isAjaxActive = true;
                    
                    break;

                //Caso in cui l'utente abbia effettuato una ricerca avanzata
                case 'search':
                    $searchParams = array();

                    //Controllo se sono state trovate corrispondenze
                    $numberOfResults = $this->searchOccurencesOfAdvancedSearch($request, $viewDescriptor, $searchParams);

                    //Se il risultato è > 0 proseguo con il recupero dei libri trovati
                    if($numberOfResults > 0)
                    {
                        //Setto la pagina dei risultati
                        $viewDescriptor->setSubPage('search_result');

                        //Infine recupero la lista dei libri trovati, che verrà visualizzata nella view 
                        $booksFoundList = BookFactory::searchBookAdvanced($searchParams['bookName'], $searchParams['author'], $searchParams['publisher'],
                                                                          $searchParams['year'], $searchParams['genre']);                
                    }
                    else if($numberOfResults == 0)
                        $viewDescriptor->setErrorMessage("Non sono state trovate corrispondenze.");

                    break;

                case 'login':
                    $username = isset($request['user']) ? $request['user'] : '';
                    $password = isset($request['password']) ? $request['password'] : '';
                                        
                    $this->login($viewDescriptor, $username, $password);
              
                    // questa variabile viene poi utilizzata dalla vista
                    if($this->isLoggedIn())
                        $user = $_SESSION[self::user];
                    break;
                    
                //Caso in cui il visitatore vuole registrarsi; vale sia per i clienti
                //che per i commercianti
                case 'register':                    
                    //Se il visitatore vuole registrarsi, mi assicuro che tutti i campi
                    //siano occupati e plausibili prima di effettuare la registrazione
                    if(isset($request['username']) && $request['username'] != "") 
                    {
                        $username = htmlentities($request['username']);
                                                
                        if(UserFactory::isUsernameOccupied($username))
                            $viewDescriptor->setErrorMessage ("Lo username inserito è già in uso da un altro utente.");
                        else if(isset($request['password']) && $request['password'] != "") 
                        {
                            $password = htmlentities($request['password']);
                            
                            if(isset($request['password2']) && $request['password2'] != "") 
                            {
                                $password2 = htmlentities($request['password2']);
                                                                
                                if(isset($request['name']) && $request['name'] != "") 
                                {
                                    $name = htmlentities($request['name']);
                                    
                                    if(isset($request['surname']) && $request['surname'] != "") 
                                    {
                                        $surname = htmlentities($request['surname']);
                                        
                                        if(isset($request['email']) && $request['email'] != "") 
                                        {
                                            $email = $request['email'];
                                            
                                            if(isset($request['adress']) && $request['adress'] != "") 
                                            {
                                                $adress = htmlentities($request['adress']);
                                                
                                                if(isset($request['civicNumber']) && $request['civicNumber'] != "")
                                                {
                                                    $civicNumber = $request['civicNumber'];
                                                    
                                                    if(isset($request['city']) && $request['city'] != "")
                                                    {
                                                        $city = htmlentities($request['city']);
                                                        
                                                        if(isset($request['cap']) && $request['cap'] != "")
                                                        {
                                                            $cap = $request['cap'];
                                                            
                                                            //Per accorpare la registrazione di clienti e commercianti, controllo 
                                                            //l'unica differenza tra loro, per capire con chi ho a che fare
                                                            if((isset($request['credit']) && $request['credit'] != "") || (isset($request['company']) && $request['company'] != ""))
                                                            {
                                                                if(isset($request['credit']))
                                                                {
                                                                    $credit = $request['credit'];
                                                                    $company = null;
                                                                }
                                                                else
                                                                {
                                                                    $company = htmlentities($request['company']);
                                                                    $credit = 0;
                                                                }
                                                                
                                                                //Controllo altri eventuali errori nel form col metodo apposito
                                                                if(!$this->lookForMistakesInForm($password, $password2, $email, $civicNumber, $cap, $credit, $viewDescriptor))
                                                                {
                                                                    //Effettuo la registrazione dell'utente vera e propria nel database; 
                                                                    //il metodo addUser mi ritorna quindi l'utente
                                                                    $user = UserFactory::addUser($username, $password, $userType, $name, 
                                                                                                 $surname, $email, $adress, $civicNumber, 
                                                                                                 $city, $cap, $company, $credit);
                                                                    
                                                                    /* Se lo user è null, ci sono stati problemi col database; se non fosse null,
                                                                     * salvo l'utente in sessione; questo vuol dire che la prossima volta che
                                                                     * verrà caricata la pagina, verrà mostrata la home dell'utente registrato */
                                                                    if(isset($user))
                                                                        $session[BaseController::user] = $user;
                                                                    else
                                                                        $viewDescriptor->setErrorMessage("Ci sono stati problemi nella registrazione. Riprovare più tardi.");
                                                                }
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

    
    public function parse_signed_request($signed_request, $secret)
    {
        list($encoded_sig, $payload) = explode('.', $signed_request, 2); 

        // decode the data
        $sig = $this->base64_url_decode($encoded_sig);
        $data = json_decode($this->base64_url_decode($payload), true);

        // confirm the signature
        $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
        
        if ($sig !== $expected_sig) 
        {
            error_log('Bad Signed JSON signature!');
            return null;
        }

        return $data;
    }

    public function base64_url_decode($input) 
    {
        return base64_decode(strtr($input, '-_', '+/'));
    }
}

?>
