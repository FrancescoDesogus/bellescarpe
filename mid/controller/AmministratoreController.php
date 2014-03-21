<?php

include_once 'BaseController.php';
include_once 'StudenteController.php';
include_once basename(__DIR__) . '/../model/UserFactory.php';
include_once basename(__DIR__) . '/../model/DipartimentoFactory.php';
include_once basename(__DIR__) . '/../model/CorsoDiLaureaFactory.php';
include_once basename(__DIR__) . '/../model/InsegnamentoFactory.php';
include_once basename(__DIR__) . '/../model/EsameFactory.php';

/**
 * Classe che gestisce contorlla l'interazione tra un utente 
 * Amministratore ed il sistema
 */
class AmministratoreController extends BaseController {

    /**
     * Costruttore
     */
    public function __construct() {
        // richiamo il costruttore della superclasse
        parent::__construct();
    }

    /**
     * Metodo per gestire l'input dell'utente
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

        if (!$this->loggedIn()) {
            // utente non autenticato, rimando alla home

            $this->showLoginPage($vd);
        } else {
            // utente autenticato
            $user = $session[BaseController::user];

            // verifico quale sia la sottopagina della categoria
            // Amministratore da servire ed imposto il descrittore 
            // della vista per caricare i "pezzi" delle pagine corretti

            // tutte le variabili che vengono create senza essere utilizzate 
            // direttamente in questo switch, sono quelle che vengono poi lette
            // dalla vista, ed utilizzano le classi del modello
            if (isset($request["subpage"])) {
                switch ($request["subpage"]) {

                    // ricerca di uno studente
                    case 'studenti_cerca':
                        $el_studenti = UserFactory::getListaStudenti();
                        $url = 'amministratore/studenti_cerca';
                        $vd->setSottoPagina('studenti_cerca');
                        $this->showHomeUtente($vd);
                        break;

                    // ricerca di un docente
                    case 'docenti_cerca':
                        $el_docenti = UserFactory::getListaDocenti();
                        $url = 'amministratore/docenti_cerca';
                        $vd->setSottoPagina('docenti_cerca');
                        $this->showHomeUtente($vd);
                        break;

                    // visualizzazione dei dipartimenti
                    case 'dipartimenti':
                        $el_dipartimenti = DipartimentoFactory::getDipartimenti();
                        $vd->setSottoPagina('dipartimenti');
                        $this->showHomeUtente($vd);
                        break;

                    // visualizzazione dei corsi di laurea
                    case 'cdl':
                        $el_dipartimenti = DipartimentoFactory::getDipartimenti();
                        $el_cdl = CorsoDiLaureaFactory::getCorsiDiLaurea();
                        $vd->setSottoPagina('cdl');
                        $this->showHomeUtente($vd);
                        break;

                    // creazione di un nuovo utente
                    case 'user':
                        $el_dipartimenti = DipartimentoFactory::getDipartimenti();
                        $el_cdl = CorsoDiLaureaFactory::getCorsiDiLaurea();
                        $vd->setSottoPagina('user');
                        $this->showHomeUtente($vd);
                        break;

                    // visualizzazione della lista degli esami
                    case 'esami':
                        $el_esami = EsameFactory::getEsami();
                        $insegnamenti = InsegnamentoFactory::getListaInsegnamenti();
                        $vd->setSottoPagina('esami');
                        $this->showHomeUtente($vd);
                        break;

                    // senza valore della sottopagina mostro il 
                    // pannello di navigazione
                    default:
                        $vd->setSottoPagina('home');
                        break;
                }
            }

            // gestione dei comandi che mi arrivano dall'utente
            
            // tutte le variabili che vengono create senza essere utilizzate 
            // direttamente in questo switch, sono quelle che vengono poi lette
            // dalla vista, ed utilizzano le classi del modello
            
            
            if (isset($request["cmd"])) {
                switch ($request["cmd"]) {

                    // comando di logout
                    case 'logout':
                        $this->logout($vd);
                        break;

                    // modifica dei dati relaviti ad uno studente
                    case 's_mod':
                        if (isset($request[BaseController::impersonato])) {
                            // l'amministratore ha selezionato uno studente
                            // di cui vuole modificare i dati in sua vece.
                            // ottengo l'identificatore dell'utente
                            $index = str_replace('obj', '', $request[BaseController::impersonato]);

                            // cerco quale sia lo studente da impersonare
                            $sessionIndex = $request[BaseController::impersonato];
                            $s = UserFactory::cercaUtentePerId($index);

                            // lo impersono e passo il compito al controller di 
                            // tipo studente
                            if ($this->impersonaUtente(
                                            $s, 'studente', 'home', $sessionIndex, $session)) {
                                return;
                            }
                        }
                        break;

                    // ricerca e cancellazione di uno studente
                    case 's_cerca':
                    case 's_del':
                        // TODO da implementare
                        $msg = array();
                        $this->creaFeedbackUtente($msg, $vd, "Lo implementiamo con il db :)");
                        break;

                    // modifica dei dati relaviti ad un docente
                    case 'd_mod':
                        if (isset($request[BaseController::impersonato])) {
                            // l'amministratore ha selezionato un docente
                            // di cui vuole modificare i dati in sua vece.
                            // ottengo l'identificatore dell'utente
                            $index = str_replace('obj', '', $request[BaseController::impersonato]);

                            // cerco quale sia il docente da impersonare
                            $sessionIndex = $request[BaseController::impersonato];
                            $s = UserFactory::cercaUtentePerId($index);

                            // lo impersono e passo il compito al controller di 
                            // tipo studente
                            if ($this->impersonaUtente(
                                            $s, 'docente', 'home', $sessionIndex, $session)) {
                                return;
                            }
                        }
                        break;

                    // cancellazione di un esame
                    case 'e_del':
                    // ricerca di un esame
                    case 'e_cerca':
                    // ricerca di un utente
                    case 'user_crea':
                    // cancellazione di un corso di laurea
                    case 'cdl_del':
                    // creazione di un corso di laurea
                    case 'cdl_crea':
                    // cancellazione di un dipartimento
                    case 'dip_del':
                    // creazione di un dipartimento
                    case 'dip_crea':
                    // ricerca di un docente
                    case 'd_cerca':
                    // cancellazione di un docente
                    case 'd_del':
                        // TODO tutte da implementare con il db 
                        $msg = array();
                        $this->creaFeedbackUtente($msg, $vd, "Lo implementiamo con il db :)");
                        break;
                }
            } else {
                // nessun comando, dobbiamo semplicemente visualizzare 
                // la vista
                $user = $session[BaseController::user];
                $this->showHomeUtente($vd);
            }
        }
        
        // richiamiamo la vista
        require basename(__DIR__) . '/../view/master.php';
    }

    /**
     * Permette all'Amministratore di impersonare un utente per modificarne i 
     * dati in sua vece
     * @param User $utente l'utente da impersonare
     * @param string $pagina la pagina da visualizzare
     * @param string $sottoPagina la sottopagina da visualizzare
     * @param string $sessionIndex l'indice dell'array allocato per contenenere
     * la sessione (finta) dell'utente impersonato
     * @param array $session la sessione dell'amministratore corrente
     * @return boolean true se la procedura va a buon fine, false altrimenti
     */
    private function impersonaUtente(
    $utente, $pagina, $sottoPagina, $sessionIndex, &$session) {
        if (isset($utente)) {
            // creo un sotto-array nella sessione corrente per 
            // impersonarlo. Viene utilizzato come se fosse la 
            // sessione utilizzata dallo studente nel caso si
            // autenticasse nel sistema realmente
            $session[$sessionIndex] = array();

            // mimo il login dell'utente impersonato
            $session[$sessionIndex][BaseController::user] = $utente;

            switch ($pagina) {
                case 'docente':
                    // sto impersonando un docente, creo il controller
                    // apposito
                    $delegate = new DocenteController();
                    break;

                case 'studente':
                    // sto impersonando uno studente, creo il controller
                    // apposito
                    $delegate = new StudenteController();
                    break;
            }

            // creo la richiesta per raggiungere la sottopagina specificata
            // impostando gli indici di un array nuovo
            $new_request = array();
            $new_request["page"] = $pagina;
            $new_request["subpage"] = $sottoPagina;

            // imposto il token per ricordarmi per ogni get e per ogni
            // post quale utente stia impersonando. N.B. Non imposto 
            // una variabile di sessione per questo scopo in modo che si possano
            // impersonare piu' utenti in contemporanea durante la stessa
            // sessione (per esempio aprendo piu' schede del browser).
            // Infatti, impostando una sola variabile di sessione, due schede
            // sovrascriverebbero la stessa variabile, mescolando i dati
            $new_request[BaseController::impersonato] = $sessionIndex;

            // delego la gestione dell'input al controller della tipologia 
            // di utente impersonato, senza reimplementare le funzionalita'
            // che gia' ci sono...
            $delegate->handleInput($new_request, $session[$sessionIndex]);
            return true;
        }

        return false;
    }

    /**
     * Restituisce l'array contentente la sessione per l'utente corrente 
     * (vero o impersonato)
     * @return array
     */
    public function &getSessione() {
        $null = null;
        if (isset($_SESSION) && array_key_exists(BaseController::user, $_SESSION)) {
            $user = $_SESSION[BaseController::user];
            
            // controllo degli accessi, restituisco qualcosa solo se e' un
            // amministratore
            if (isset($user) && $user->getRuolo() == User::Amministratore) {
                return $_SESSION;
            }
        }
        return $null;
    }

}

?>
