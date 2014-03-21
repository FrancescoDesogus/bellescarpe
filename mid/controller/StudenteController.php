<?php

include_once 'BaseController.php';
include_once basename(__DIR__) . '/../model/EsameFactory.php';
include_once basename(__DIR__) . '/../model/AppelloFactory.php';

/**
 * Controller che gestisce la modifica dei dati dell'applicazione relativa agli 
 * Studenti da parte di utenti con ruolo Studente o Amministratore 
 *
 * @author Davide Spano
 */
class StudenteController extends BaseController {

    const appelli = 'appelli';

    /**
     * Costruttore
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Metodo per gestire l'input dell'utente. 
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

        if (!$this->loggedIn()) {
            // utente non autenticato, rimando alla home

            $this->showLoginPage($vd);
        } else {
            // utente autenticato
            $user = $session[BaseController::user];

            // verifico quale sia la sottopagina della categoria
            // Docente da servire ed imposto il descrittore 
            // della vista per caricare i "pezzi" delle pagine corretti
            // tutte le variabili che vengono create senza essere utilizzate 
            // direttamente in questo switch, sono quelle che vengono poi lette
            // dalla vista, ed utilizzano le classi del modello
            if (isset($request["subpage"])) {
                switch ($request["subpage"]) {

                    // modifica dei dati anagrafici
                    case 'anagrafica':
                        $vd->setSottoPagina('anagrafica');
                        break;

                    // visualizzazione degli esami sostenuti
                    case 'esami':
                        $esami = EsameFactory::esamiPerStudente($user);
                        $vd->setSottoPagina('esami');
                        break;

                    // iscrizione ad un appello
                    case 'iscrizione':
                        // simuliamo un po' di persistenza ponendo la lista degli
                        // appelli in sessione
                        // quando inseriremo il db andra' eliminata
                        if (isset($session[self::appelli])) {
                            $appelli = $session[self::appelli];
                        } else {
                            $appelli = AppelloFactory::getAppelliPerStudente($user);
                            $session[self::appelli] = $appelli;
                        }
                        $vd->setSottoPagina('iscrizione');
                        break;
                    default:

                        $vd->setSottoPagina('home');
                        break;
                }
            }



            // gestione dei comandi inviati dall'utente
            if (isset($request["cmd"])) {
                // abbiamo ricevuto un comando
                switch ($request["cmd"]) {

                    // logout
                    case 'logout':
                        $this->logout($vd);
                        break;

                    // aggiornamento indirizzo
                    case 'indirizzo':

                        // in questo array inserisco i messaggi di 
                        // cio' che non viene validato
                        $msg = array();
                        $this->aggiornaIndirizzo($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Indirizzo aggiornato");
                        $this->showHomeUtente($vd);
                        break;

                    // cambio email
                    case 'email':
                        // in questo array inserisco i messaggi di 
                        // cio' che non viene validato
                        $msg = array();
                        $this->aggiornaEmail($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Email aggiornata");
                        $this->showHomeUtente($vd);
                        break;

                    // cambio password
                    case 'password':
                        // in questo array inserisco i messaggi di 
                        // cio' che non viene validato
                        $msg = array();
                        $this->aggiornaPassword($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Password aggiornata");
                        $this->showHomeStudente($vd);
                        break;

                    // iscrizione ad un appello
                    case 'iscrivi':
                        // recuperiamo l'indice 
                        $msg = array();
                        $a = $this->getAppelloPerIndice($appelli, $request, $msg);
                        if (isset($a) && !$a->iscrivi($user)) {
                            $msg[] = "<li> Impossibile iscriverti all'appello specificato. Verifica la capienza del corso </li>";
                        }
                        $this->creaFeedbackUtente($msg, $vd, "Ti sei iscritto all'appello specificato");
                        $this->showHomeStudente($vd);
                        break;

                    // cancellazione da un appello
                    case 'cancella':
                        // recuperiamo l'indice 
                        $msg = array();
                        $a = $this->getAppelloPerIndice($appelli, $request, $msg);
                        if (isset($a) && !$a->cancella($user)) {
                            $msg[] = "<li> Impossibile cancellarti dall'appello specificato </li>";
                        }
                        $this->creaFeedbackUtente($msg, $vd, "Ti sei cancellato dall'appello specificato");
                        $this->showHomeUtente($vd);
                        break;
                    default : $this->showLoginPage($vd);
                }
            } else {
                // nessun comando
                $user = $session[BaseController::user];
                $this->showHomeUtente($vd);
            }
        }

        // includo la vista
        require basename(__DIR__) . '/../view/master.php';
    }

    /**
     * Restituisce l'array contentente la sessione per l'utente corrente 
     * (vero o impersonato)
     * @return array
     */
    public function &getSessione(&$request) {
        $null = null;
        if (!isset($_SESSION) || !array_key_exists(BaseController::user, $_SESSION)) {
            // la sessione deve essere inizializzata
            return $null;
        }

        // verifico chi sia l'utente correntemente autenticato
        $user = $_SESSION[BaseController::user];

        // controllo degli accessi
        switch ($user->getRuolo()) {

            // l'utente e' uno studente, consentiamo l'accesso
            case User::Studente:
                return $_SESSION;

            // l'utente e' un amministratore
            case User::Amministratore:
                if (isset($request[BaseController::impersonato])) {
                    
                    // ha richiesto di impersonare un utente
                    $index = $request[parent::impersonato];
                    if (array_key_exists($index, $_SESSION) &&
                            $_SESSION[$index][BaseController::user]->getRuolo() == User::Studente) {
                         // l'utente che sta impersonando e' uno studente,
                        // consentiamo l'accesso
                        return $_SESSION[$index];
                    } else {
                        return $null;
                    }
                }
                return $null;

            default:
                return $null;
        }
    }

    private function getAppelloPerIndice(&$appelli, &$request, &$msg) {
        if (isset($request['appello'])) {
            // indice per l'appello definito, verifichiamo che sia un intero
            $intVal = filter_var($request['appello'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
            if (isset($intVal) && $intVal > -1 && $intVal < count($appelli)) {
                return $appelli[$intVal];
            } else {
                $msg[] = "<li> L'appello specificato non esiste </li>";
                return null;
            }
        } else {
            $msg[] = '<li>Appello non specificato<li>';
            return null;
        }
    }

}

?>
