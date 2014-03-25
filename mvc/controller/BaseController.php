<?php

include_once basename(__DIR__) . '/../view/ViewDescriptor.php';
//include_once basename(__DIR__) . '/../model/User.php';
//include_once basename(__DIR__) . '/../model/UserFactory.php';

/**
 * Controller di base per tutti gli altri (che quindi lo estendono)
 */
class BaseController 
{ 
    const user = 'user'; //Costante usata come riferimento per l'user nell'array di sessione
    const impersonation = '_imp'; //Costante usata come riferimento per gli utenti impersonati

    //Costruttore
    public function __construct() 
    {
        
    }

    /**
     * Metodo per gestire l'input dell'utente. Le sottoclassi lo sovrascrivono.
     * 
     * @param type $request la richiesta da gestire
     * @param type $session array con le variabili di sessione
     */
    public function handleInput(&$request, &$session) 
    {            

    }

    /**
     * Restituisce l'array contentente la sessione per l'utente corrente 
     * (vero o impersonato). Le sottoclassi lo sovrascrivono
     * 
     * @return array
     */
    public function &getSession() 
    {
        return $_SESSION;
    }
    
    

    /**
     * Verifica se l'utente sia correttamente autenticato
     * 
     * @return true se l'utente era gia' autenticato, false altrimenti
     */
    protected function isLoggedIn() 
    {
        return isset($_SESSION) && array_key_exists(self::user, $_SESSION);
    }

    
    /**
     *  Controlla a che tipo di utente corrisponde l'utente e carica
      * la la pagina appropiata
      * 
     * @param ViewDescriptor $viewDescriptor
     * @param $pSession 
     */
    protected function showPage($viewDescriptor, $pSession) 
    {
        //Controllo se è stato salvato un utente nella sessione...
        if(isset($pSession[self::user]))
        {
            //...ed in tal caso lo recupero
            $user = $pSession[self::user];
                        
            //Controllo il tipo di utente e salvo il titolo ed il path per caricare
            //le parti della home a seconda dell'user
            switch($user->getUserType()) 
            {
                case User::ADMIN:
                    $pageTitle = 'openbook.com';
                    $path = '/../view/admin/';
                    break;

                case User::CUSTOMER:                               
                    $pageTitle = 'openbook.com';
                    $path = '/../view/customer/';
                    break;

                case User::RETAILER:                
                    $pageTitle = 'openbook.com';
                    $path = '/../view/retailer/';
                    break;
            }
        } 
        //Se non è stato salvato un utente in sessione vuol dire che chi sta
        //usando il sito non è loggato, quindi recupero il path per i file dei visitatori
        else
        {
            $pageTitle = 'BelleScarpe';
            $path = '/../view/guest/';
        }
        
        //Se almeno un elemento dello switch è stato eseguito, carico la pagina
        if(isset($path))
        {                 
            $viewDescriptor->setTitle($pageTitle);
            $viewDescriptor->setLogoutFile(basename(__DIR__) . $path . 'logout.php');
            $viewDescriptor->setTabsFile(basename(__DIR__) . $path . 'tabs.php');
            $viewDescriptor->setLeftSidebarFile(basename(__DIR__) . $path . 'leftSidebar.php');
            $viewDescriptor->setRightSidebarFile(basename(__DIR__) . $path . 'rightSidebar.php');
            $viewDescriptor->setContentFile(basename(__DIR__) .  $path . 'content.php');
        }
    }
 
    /**
     * Imposta la variabile del descrittore della vista legato 
     * all'utente da impersonare nel caso sia stato specificato nella richiesta
     * 
     * @param ViewDescriptor $viewDescriptor
     * @param array $request
     */
    protected function setImpToken(ViewDescriptor $viewDescriptor, &$request) 
    {
        if(array_key_exists(self::impersonation, $request)) 
            $viewDescriptor->setImpToken($request[self::impersonation]);
        
    }

    /**
     * Procedura di autenticazione 
     * 
     * @param ViewDescriptor $pViewDescriptor descrittore della vista
     * @param string $username lo username specificato
     * @param string $password la password specificata
     */
    protected function login($pViewDescriptor, $username, $password) 
    {
        //Controllo i dati inseriti corrispondono ad un utente
        $user = UserFactory::loadUser($username, $password);
        
        //Se la variabile user è settata, procedo con il login
        if(isset($user)) 
        {
            //Se l'utente esiste, lo salvo nell'array di sessione...
            $_SESSION[self::user] = $user;
            
            //...segno che la pagina che si visualizzerà è la home dell'utente...
            $pViewDescriptor->setSubpage('home');
            
            //...e carico quindi le parti della pagina
            $this->showPage($pViewDescriptor, $_SESSION);
        } 
        //Altrimenti inserisco un errore da far apparire nella pagina di login e la ricarico
        else 
        {
            $pViewDescriptor->setErrorMessage("Utente sconosciuto o password errata");
            $this->showPage($pViewDescriptor, $_SESSION);
        }
    }

    /**
     * Procedura di logout dal sistema 
     * 
     * @param type $viewDescriptor il descrittore della pagina
     */
    protected function logout($viewDescriptor) 
    {
        //Azzero l'array di sessione
        $_SESSION = array();
        
        //Termino la validita' del cookie di sessione
        if (session_id() != '' || isset($_COOKIE[session_name()])) {
            //Imposto il termine di validita' al mese scorso
            setcookie(session_name(), '', time() - 2592000, '/');
        }
           
        //Distruggo il file di sessione
        session_destroy();
        
        //Adesso carico la pagina della home dei visitatori
        $this->showPage($viewDescriptor, $_SESSION);
        
        require basename(__DIR__) . '/../view/masterPage.php';
    }
    

    
    /**
     * Metodo per calcolare il range di elementi da visualizzare nella sottopagina
     * corrente; serve in pagine come il catalogo che mostrano i risultati
     * pochi per volta, permettendo di visualizzarne altri scorrendo le
     * sottopagine. 
     * 
     * @param $pNumberOfSubpages il numero di sottopagine totali
     * @param $pNumberOfRows il numero effettivo di elementi da visualizzare
     * @param $request l'array delle richieste per recuperare il numero della sottopagina corrente
     * 
     * @return l'indice da cui far partire la ricerca nel database
     */
    protected function calculateSubpageNumberRange($pNumberOfSubpages, $pNumberOfRows, $request) 
    {
        //Controllo a che pagina l'utente è attualmente recuperandola
        //dall'array richieste
        if(isset($request["subpageNumber"])) 
        {
            //Controllo che il valore inserito sia effettivamente un numero
            $currentSubpageNumber = filter_var($request["subpageNumber"], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
            
            //Se il valore è un numero compreso tra 1 ed il numero di pagine del catalogo posso proseguire
            if(isset($currentSubpageNumber) && $currentSubpageNumber > 1 && $currentSubpageNumber <= $pNumberOfSubpages)
            {      
                /* Devo calcolare quali serie di 5 libri devo recuperare; per farlo
                 * considero la pagina corrente meno 1 (dato che nel database gli elementi
                 * sono salvati partendo da 0) moltiplicata per 5: il risultato sarà
                 * l'indice da cui il database deve partire per recuperare i libri */
                $startingIndex = ($currentSubpageNumber-1) * $pNumberOfRows;
            }
            //Se il valore non è un numero, riporto semplicemente alla prima pagina segnalando
            //che dovranno essere presi i libri del catalogo partendo dall'indice 0
            else
                $startingIndex = 0;
        }
        //Se non è specificata la sottopagina, do' per scontato che sia la prima,
        //quindi segno che l'indice da cui iniziare la ricerca nel database è 0
        else
            $startingIndex = 0;
        
        return $startingIndex;
    }

    
    /**
     * Controlla se sono state trovati dei match nella ricerca semplice
     * di un libro.
     * 
     * @param $viewDescriptor descrittore della vista, per mostrare errori
     * @param array $request la richiesta contenente il nome del libro
     * 
     * @return il numero di occorrenze o -1 in caso di problemi
     */
    protected function searchOccurencesOfBookByName($request, $viewDescriptor)
    {        
        if(isset($request["searchBar"]) && $request["searchBar"] != "")
        {
            //Se non ci sono stati problemi con l'input inserito nella barra di 
            //ricerca, lo recupero e controllo con l'appposito metodo il numero di occorrenze
            $bookName = $request["searchBar"];
                        
            $occurences = BookFactory::countOccurencesByName($bookName);
          
            return $occurences;
        }
        else
        {
            $viewDescriptor->setErrorMessage("Inserire il nome del libro da cercare!");
        
            return -1; 
        }   
    }

    
    /**
     * Controlla se sono state trovati dei match nella ricerca avanzata
     * di un libro.
     * 
     * @param $viewDescriptor descrittore della vista, per mostrare errori
     * @param array $request la richiesta contenente il nome del libro
     * @param array $searchParams in cui inserire i parametri inseriti dall'utente
     * 
     * @return il numero di occorrenze o -1 in caso di problemi
     */
    protected function searchOccurencesOfAdvancedSearch($request, $viewDescriptor, &$searchParams)
    {         
        $searchParams['genre'] = $request["genre"];
        $searchParams['bookName'] = htmlentities($request["bookName"]);
        $searchParams['author'] = htmlentities($request["author"]);
        $searchParams['publisher'] = htmlentities($request["publisher"]);
        $searchParams['year'] = $request["year"];

        if($searchParams['genre'] == -1)
            $searchParams['genre'] = null;

        if($searchParams['year'] == "")
            $searchParams['year'] = null;


        $occurences = BookFactory::countOccurencesOfAdvancedSearch($searchParams['bookName'], $searchParams['author'], $searchParams['publisher'],
                                                                   $searchParams['year'], $searchParams['genre']);
        
        return $occurences;
    }  
    
    /**
     * Aggiorna i dati personali di un utente.
     * 
     * @param User $user l'utente da aggiornare
     * @param array $request la richiesta http da gestire
     * 
     * @return boolean, true in caso di successo; false altrimenti
     */
    protected function changePersonalData(&$user, &$request, ViewDescriptor $viewDescriptor) 
    {
        $hasSucceeded = false;
        
        //Per ogni campo del form, controllo se è vuoto e se è plausibile
        if(isset($request['email']) && $request['email'] != "") 
        {
            if(!$user->setEmail(html_entity_decode($request['email'])))
                $viewDescriptor->setErrorMessage("L'email inserita non è valida.");
            else
            {
                if(isset($request['adress']) && $request['adress'] != "") 
                {       
                    if(!$user->setAdress(html_entity_decode($request['adress'])))
                        $viewDescriptor->setErrorMessage("L'indirizzo inserito non è valido.");
                    else
                    {
                        if(isset($request['civicNumber']) && $request['civicNumber'] != "") 
                        {       
                            if(!$user->setCivicNumber($request['civicNumber']))
                                $viewDescriptor->setErrorMessage("Il numero civico inserito non è valido.");
                            else
                            {
                                if(isset($request['city']) && $request['city'] != "") 
                                {       
                                    if(!$user->setCity(html_entity_decode($request['city'])))
                                        $viewDescriptor->setErrorMessage("La città inserita non è valida.");
                                    else
                                    {
                                        if(isset($request['cap']) && $request['cap'] != "") 
                                        {       
                                            if(!$user->setCap($request['cap']))
                                                $viewDescriptor->setErrorMessage("Il cap inserito non è valido.");
                                            else
                                            {
                                                if(isset($request['company']) && $request['company'] != "")
                                                {
                                                    if($user->setCompany(html_entity_decode($request['company'])))
                                                        $hasSucceeded = true;
                                                    else
                                                        $viewDescriptor->setErrorMessage("Inserire il nome della compagnia.");
                                                }
                                                //Se a modificare i dati è un cliente, la compagnia non c'è; quindi se non esiste
                                                //quel campo, si può procedere lo stesso
                                                else if(!isset($request['company']))
                                                    $hasSucceeded = true;   
                                            } 
                                        }
                                        else
                                            $viewDescriptor->setErrorMessage("Il campo cap è vuoto.");
                                    }
                                }
                                else
                                    $viewDescriptor->setErrorMessage("Il campo città è vuoto.");
                            }
                        }
                        else
                            $viewDescriptor->setErrorMessage("Il campo del numero civico è vuoto.");
                    }
                }
                else
                    $viewDescriptor->setErrorMessage("Il campo del'indirizzo è vuoto.");
            }
        }
        else
            $viewDescriptor->setErrorMessage("Il campo dell'email è vuoto.");
        
        
        return $hasSucceeded;
    }

    /**
     * Aggiorna la password di un utente.
     * 
     * @param User $user l'utente in questione
     * @param array $request la richiesta http da gestire
     * @param ViewDescriptor $viewDescriptor descrittore della vista, per mostrare errori
     */
    protected function changePassword(&$user, &$request, ViewDescriptor $viewDescriptor) 
    {
        $hasSucceeded = false;
        
        if(isset($request['password']) && $request['password'] != "") 
        {
            $password = $request['password'];
            
            if(isset($request['password2']) && $request['password2'] != "") 
            {   
                $password2 = $request['password2'];
                
                if($password == $password2)
                {
                    $user->setPassword($password);
                    
                    $hasSucceeded = true;
                }
                else
                    $viewDescriptor->setErrorMessage ("La conferma della password non è corretta.");
            }
            else
                $viewDescriptor->setErrorMessage ("Il campo per la conferma della password è vuoto."); 
        }
        else
            $viewDescriptor->setErrorMessage ("Il campo per la la password è vuoto.");
        
        
        return $hasSucceeded;
    }
}

?>
