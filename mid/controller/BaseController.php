<?php

include_once dirname(__FILE__) . '/../view/ViewDescriptor.php';
//include_once basename(__DIR__) . '/../model/User.php';
//include_once basename(__DIR__) . '/../model/UserFactory.php';

/**
 * Controller che gestisce gli utenti non autenticati, 
 * fornendo le funzionalita' comuni anche agli altri controller
 *
 * @author Davide Spano
 */
class BaseController {

    const user = 'user';
    const impersonato = '_imp';

    /**
     * Costruttore
     */
    public function __construct() {
        
    }

    /**
     * Metodo per gestire l'input dell'utente. Le sottoclassi lo sovrascrivono
     * @param type $request la richiesta da gestire
     * @param type $session array con le variabili di sessione
     */
    public function handleInput(&$request, &$session) {
        // creo il descrittore della vista
        $vd = new ViewDescriptor();


        // imposto la pagina
        $vd->setPagina($request['page']);

        // imposto il token per impersonare un utente (nel lo stia facendo)
        $this->setImpToken($vd, $request);

        // gestion dei comandi
        // tutte le variabili che vengono create senza essere utilizzate 
        // direttamente in questo switch, sono quelle che vengono poi lette
        // dalla vista, ed utilizzano le classi del modello

        /*if (isset($request["cmd"])) {
            // abbiamo ricevuto un comando
            switch ($request["cmd"]) {
                case 'login':
                    $username = isset($request['user']) ? $request['user'] : '';
                    $password = isset($request['password']) ? $request['password'] : '';
                    //$this->login($vd, $username, $password);
                    // questa variabile viene poi utilizzata dalla vista
                    //if ($this->loggedIn())
                        //$user = $_SESSION[self::user];
                    break;
                default : $this->showLoginPage();
            }
        } else {
            if ($this->loggedIn()) {
                //utente autenticato
                // questa variabile viene poi utilizzata dalla vista
                $user = $_SESSION[self::user];

                $this->showHomeUtente($vd);
            } else {
                // utente non autenticato
                $this->showLoginPage($vd);
            }
        }*/
        
        $this->showLoginPage($vd);
        // richiamo la vista
        require dirname(__FILE__) . '/../view/master.php';
    }

    /**
     * Restituisce l'array contentente la sessione per l'utente corrente 
     * (vero o impersonato). Le sottoclassi lo sovrascrivono
     * @return array
     */
    public function &getSessione() {
        return $_SESSION;
    }

    /**
     * Verifica se l'utente sia correttamente autenticato
     * @return boolean true se l'utente era gia' autenticato, false altrimenti
     */
    protected function loggedIn() {
        return isset($_SESSION) && array_key_exists(self::user, $_SESSION);
    }

    /**
     * Imposta la vista master.php per visualizzare la pagina di login
     * @param ViewDescriptor $vd il descrittore della vista
     */
    protected function showLoginPage($vd) {
        // mostro la pagina di login
        $vd->setTitolo("Moodle - login");
        $vd->setScripts(dirname(__FILE__) . '/../view/login/scripts.php');
        $vd->setHeaderFile(dirname(__FILE__) . '/../view/login/header.php');
        $vd->setNavBarFile(dirname(__FILE__) . '/../view/login/navbar.php');
        $vd->setContentFile(dirname(__FILE__) . '/../view/login/content.php');
    }

    /**
     * Imposta la vista master.php per visualizzare la pagina di gestione
     * dello studente
     * @param ViewDescriptor $vd il descrittore della vista
     */
    protected function showHomeStudente($vd) {
        // mostro la home degli studenti

        $vd->setTitolo("esAMMi - gestione studente ");
        $vd->setMenuFile(basename(__DIR__) . '/../view/studente/menu.php');
        $vd->setLogoFile(basename(__DIR__) . '/../view/studente/logo.php');
        $vd->setLeftBarFile(basename(__DIR__) . '/../view/studente/leftBar.php');
        $vd->setRightBarFile(basename(__DIR__) . '/../view/studente/rightBar.php');
        $vd->setContentFile(basename(__DIR__) . '/../view/studente/content.php');
    }

     /**
     * Imposta la vista master.php per visualizzare la pagina di gestione
     * del docente
     * @param ViewDescriptor $vd il descrittore della vista
     */
    protected function showHomeDocente($vd) {
        // mostro la home dei docenti
        $vd->setTitolo("esAMMi - gestione docente ");
        $vd->setMenuFile(basename(__DIR__) . '/../view/docente/menu.php');
        $vd->setLogoFile(basename(__DIR__) . '/../view/docente/logo.php');
        $vd->setLeftBarFile(basename(__DIR__) . '/../view/docente/leftBar.php');
        $vd->setRightBarFile(basename(__DIR__) . '/../view/docente/rightBar.php');
        $vd->setContentFile(basename(__DIR__) . '/../view/docente/content.php');
    }

    
     /**
     * Imposta la vista master.php per visualizzare la pagina di gestione
     * dell'amministratore
     * @param ViewDescriptor $vd il descrittore della vista
     */
    protected function showHomeAmministratore($vd) {
        // mostro la home degli amministratori

        $vd->setTitolo("esAMMi - Super User ");
        $vd->setMenuFile(basename(__DIR__) . '/../view/amministratore/menu.php');
        $vd->setLogoFile(basename(__DIR__) . '/../view/amministratore/logo.php');
        $vd->setLeftBarFile(basename(__DIR__) . '/../view/amministratore/leftBar.php');
        $vd->setRightBarFile(basename(__DIR__) . '/../view/amministratore/rightBar.php');
        $vd->setContentFile(basename(__DIR__) . '/../view/amministratore/content.php');
    }

    
     /**
     * Seleziona quale pagina mostrare in base al ruolo dell'utente corrente
     * @param ViewDescriptor $vd il descrittore della vista
     */
    protected function showHomeUtente($vd) {
        $user = $_SESSION[self::user];
        switch ($user->getRuolo()) {
            case User::Studente:
                $this->showHomeStudente($vd);
                break;

            case User::Docente:
                $this->showHomeDocente($vd);
                break;

            case User::Amministratore:
                $this->showHomeAmministratore($vd);
                break;
        }
    }

    
    /**
     * Imposta la variabile del descrittore della vista legato 
     * all'utente da impersonare nel caso sia stato specificato nella richiesta
     * @param ViewDescriptor $vd il descrittore della vista
     * @param array $request la richiesta
     */
    protected function setImpToken(ViewDescriptor $vd, &$request) {

        if (array_key_exists('_imp', $request)) {
            $vd->setImpToken($request['_imp']);
        }
    }

    /**
     * Procedura di autenticazione 
     * @param ViewDescriptor $vd descrittore della vista
     * @param string $username lo username specificato
     * @param string $password la password specificata
     */
    protected function login($vd, $username, $password) {
        // carichiamo i dati dell'utente

        $user = UserFactory::loadUser($username, $password);
        if (isset($user) && $user->esiste()) {
            // utente autenticato

            $_SESSION[self::user] = $user;
            $this->showHomeUtente($vd);
        } else {
            $vd->setMessaggioErrore("Utente sconosciuto o password errata");
            $this->showLoginPage($vd);
        }
    }

    /**
     * Procedura di logout dal sistema 
     * @param type $vd il descrittore della pagina
     */
    protected function logout($vd) {
        // reset array $_SESSION
        $_SESSION = array();
        // termino la validita' del cookie di sessione
        if (session_id() != '' || isset($_COOKIE[session_name()])) {
            // imposto il termine di validita' al mese scorso
            setcookie(session_name(), '', time() - 2592000, '/');
        }
        // distruggo il file di sessione
        session_destroy();
        $this->showLoginPage($vd);
    }

    /**
     * Aggiorno l'indirizzo di un utente (comune a Studente e Docente)
     * @param User $user l'utente da aggiornare
     * @param array $request la richiesta http da gestire
     * @param array $msg riferimento ad un array da riempire con eventuali
     * messaggi d'errore
     */
    protected function aggiornaIndirizzo($user, &$request, &$msg) {

        if (isset($request['via'])) {
            if (!$user->setVia($request['via'])) {
                $msg[] = '<li>La via specificata non &egrave; corretta</li>';
            }
        }
        if (isset($request['civico'])) {
            if (!$user->setNumeroCivico($request['civico'])) {
                $msg[] = '<li>Il formato del numero civico non &egrave; corretto</li>';
            }
        }
        if (isset($request['citta'])) {
            if (!$user->setCitta($request['citta'])) {
                $msg[] = '<li>La citt&agrave; specificata non &egrave; corretta</li>';
            }
        }
        if (isset($request['provincia'])) {
            if (!$user->setProvincia($request['provincia'])) {
                $msg[] = '<li>La provincia specificata &egrave; corretta</li>';
            }
        }
        if (isset($request['cap'])) {
            if (!$user->setCap($request['cap'])) {
                $msg[] = '<li>Il CAP specificato non &egrave; corretto</li>';
            }
        }
    }

    /**
     * Aggiorno l'indirizzo email di un utente (comune a Studente e Docente)
     * @param User $user l'utente da aggiornare
     * @param array $request la richiesta http da gestire
     * @param array $msg riferimento ad un array da riempire con eventuali
     * messaggi d'errore
     */
    protected function aggiornaEmail($user, &$request, &$msg) {
        if (isset($request['email'])) {
            if (!$user->setEmail($request['email'])) {
                $msg[] = '<li>L\'indirizzo email specificato non &egrave; corretto</li>';
            }
        }
    }
    
    
    /**
     * Aggiorno la password di un utente (comune a Studente e Docente)
     * @param User $user l'utente da aggiornare
     * @param array $request la richiesta http da gestire
     * @param array $msg riferimento ad un array da riempire con eventuali
     * messaggi d'errore
     */
    protected function aggiornaPassword($user, &$request, &$msg) {
        if (isset($request['pass1']) && isset($request['pass2'])) {
            if ($request['pass1'] == $request['pass2']) {
                if (!$user->setPassword($request['pass1'])) {
                    $msg[] = '<li>Il formato della password non &egrave; corretto</li>';
                }
            } else {
                $msg[] = '<li>Le due password non coincidono</li>';
            }
        }
    }

    /**
     * Crea un messaggio di feedback per l'utente 
     * @param array $msg lista di messaggi di errore
     * @param ViewDescriptor $vd il descrittore della pagina
     * @param string $okMsg il messaggio da mostrare nel caso non ci siano errori
     */
    protected function creaFeedbackUtente(&$msg, $vd, $okMsg) {
        if (count($msg) > 0) {
            // ci sono messaggi di errore nell'array,
            // qualcosa e' andato storto...
            $error = "Si sono verificati i seguenti errori \n<ul>\n";
            foreach ($msg as $m) {
                $error = $error . $m . "\n";
            }
            // imposto il messaggio di errore
            $vd->setMessaggioErrore($error);
        } else {
            // non ci sono messaggi di errore, la procedura e' andata
            // quindi a buon fine, mostro un messaggio di conferma
            $vd->setMessaggioConferma($okMsg);
        }
    }

}

?>
