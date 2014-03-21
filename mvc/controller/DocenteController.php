<?php

include_once 'BaseController.php';
include_once basename(__DIR__) . '/../model/ElencoEsami.php';
include_once basename(__DIR__) . '/../model/DipartimentoFactory.php';
include_once basename(__DIR__) . '/../model/UserFactory.php';

/**
 * Controller che gestisce la modifica dei dati dell'applicazione relativa ai 
 * Docenti da parte di utenti con ruolo Docente o Amministratore 
 *
 * @author Davide Spano
 */
class DocenteController extends BaseController {

    const appelli = 'appelli';
    const elenco = 'elenco';

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
                        $dipartimenti = DipartimentoFactory::getDipartimenti();
                        $vd->setSottoPagina('anagrafica');
                        break;

                    // inserimento di una lista di appelli
                    case 'appelli':
                        // simuliamo un po' di persistenza ponendo la lista degli
                        // appelli in sessione
                        // quando inseriremo il db andra' eliminata
                        $this->initAppelli($user, $session);
                        $appelli = $session[self::appelli];
                        $insegnamenti = InsegnamentoFactory::getListaInsegnamentiPerDocente($user);
                        $vd->setSottoPagina('appelli');
                        break;

                    // modifica di un appello
                    case 'appelli_modifica':
                        $msg = array();
                        $this->initAppelli($user, $session);
                        $appelli = $session[self::appelli];
                        $mod_appello = $this->getAppello($request, $msg, $session);
                        $insegnamenti = InsegnamentoFactory::getListaInsegnamentiPerDocente($user);
                        if (!isset($mod_appello)) {
                            $vd->setSottoPagina('appelli');
                        } else {
                            $vd->setSottoPagina('appelli_modifica');
                        }
                        break;

                    // creazione di un appello
                    case 'appelli_crea':
                        $msg = array();
                        $this->initAppelli($user, $session);
                        $appelli = $session[self::appelli];
                        $insegnamenti = InsegnamentoFactory::getListaInsegnamentiPerDocente($user);
                        if (!isset($request['cmd'])) {
                            $vd->setSottoPagina('appelli');
                        } else {
                            $vd->setSottoPagina('appelli_crea');
                        }

                        break;

                    // visualizzazione della lista di iscritti ad un appello
                    case 'appelli_iscritti':
                        $msg = array();
                        $this->initAppelli($user, $session);
                        $appelli = $session[self::appelli];
                        $mod_appello = $this->getAppello($request, $msg, $session);
                        if (!isset($mod_appello)) {
                            $vd->setSottoPagina('appelli');
                        } else {
                            $vd->setSottoPagina('appelli_iscritti');
                        }
                        break;

                    // registrazione degli esami
                    // con visualizzazione delle liste attive
                    case 'reg_esami':
                        if (!isset($session[self::elenco])) {
                            $session[self::elenco] = array();
                        }
                        $elenco_id = $this->getIdElenco($request, $msg, $session);
                        $elenchi_attivi = $session[self::elenco];
                        $vd->setSottoPagina('reg_esami');
                        break;

                    // registrazione degli esami, passo 1:
                    // selezione dell'insegnamento
                    case 'reg_esami_step1':
                        $msg = array();

                        // ricerco l'elenco da modificare, e' possibile gestirne 
                        // piu' di uno con lo stesso browser
                        $elenco_id = $this->getIdElenco($request, $msg, $session);
                        $insegnamenti = InsegnamentoFactory::getListaInsegnamentiPerDocente($user);
                        $docenti = UserFactory::getListaDocenti();

                        if (isset($elenco_id)) {
                            $sel_insegnamento = $session[self::elenco][$elenco_id]->getTemplate()->getInsegnamento();
                        }
                        $vd->setSottoPagina('reg_esami_step1');
                        break;

                    // registrazione degli esami, passo 2:
                    // selezione della commissione
                    case 'reg_esami_step2':
                        $msg = array();
                        $docenti = UserFactory::getListaDocenti();

                        // ricerco l'elenco da modificare, e' possibile gestirne 
                        // piu' di uno con lo stesso browser
                        $elenco_id = $this->getIdElenco($request, $msg, $session);
                        $insegnamenti = InsegnamentoFactory::getListaInsegnamentiPerDocente($user);
                        $elenchi_attivi = $session[self::elenco];

                        if (isset($elenco_id)) {
                            $commissione = $session[self::elenco][$elenco_id]->getTemplate()->getCommissione();
                            $sel_insegnamento = $session[self::elenco][$elenco_id]->getTemplate()->getInsegnamento();
                            $sel_esami = $session[self::elenco][$elenco_id]->getEsami();
                            // se l'insegnamento non e' stato specificato lo rimandiamo
                            // al passo precedente
                            if (!isset($sel_insegnamento)) {
                                $vd->setSottoPagina('reg_esami_step1');
                            } else {
                                $vd->setSottoPagina('reg_esami_step2');
                            }
                        } else {
                            $vd->setSottoPagina('reg_esami');
                        }
                        break;

                    // registrazione degli esami, passo 3:
                    // inserimento statini
                    case 'reg_esami_step3':
                        $msg = array();
                        $docenti = UserFactory::getListaDocenti();

                        // ricerco l'elenco da modificare, e' possibile gestirne 
                        // piu' di uno con lo stesso browser
                        $elenco_id = $this->getIdElenco($request, $msg, $session);
                        $elenchi_attivi = $session[self::elenco];
                        if (isset($elenco_id)) {
                            $commissione = $session[self::elenco][$elenco_id]->getTemplate()->getCommissione();
                            $sel_insegnamento = $session[self::elenco][$elenco_id]->getTemplate()->getInsegnamento();
                            $sel_esami = $session[self::elenco][$elenco_id]->getEsami();

                            // se l'insegnamento non e' stato specificato lo 
                            // rimandiamo al passo 1
                            if (!isset($sel_insegnamento)) {
                                $vd->setSottoPagina('reg_esami_step1');
                                // se la commissione non e' valida lo rimandiamo al passo 2
                            } else if (!isset($commissione) ||
                                    !$session[self::elenco][$elenco_id]->getTemplate()->commissioneValida()) {
                                $vd->setSottoPagina('reg_esami_step2');
                            } else {
                                // tutto ok, passo 3
                                $vd->setSottoPagina('reg_esami_step3');
                            }
                        } else {
                            $vd->setSottoPagina('reg_esami');
                        }
                        break;

                    // visualizzazione dell'elenco esami
                    case 'el_esami':
                        $insegnamenti = InsegnamentoFactory::getListaInsegnamentiPerDocente($user);
                        $el_esami = EsameFactory::esamePerDocente($user);
                        $vd->setSottoPagina('el_esami');
                        break;

                    default:
                        $vd->setSottoPagina('home');
                        break;
                }
            }


            // gestione dei comandi inviati dall'utente
            if (isset($request["cmd"])) {

                switch ($request["cmd"]) {

                    // logout
                    case 'logout':
                        $this->logout($vd);
                        break;

                    // modifica delle informazioni sull'indirizzo dell'ufficio
                    case 'ufficio':
                        $msg = array();
                        if (isset($request['dipartimento'])) {
                            $intVal = filter_var($request['dipartimento'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (!isset($intVal) || $intVal < 0 || $intVal > count($dipartimenti)
                                    || $user->setDipartimento($dipartimenti[$intVal])) {
                                $msg[] = '<li>Il dipartimento specificato non &egrave; corretto</li>';
                            }
                        }
                        $this->aggiornaIndirizzo($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Indirizzo ufficio aggiornato");
                        $this->showHomeUtente($vd);
                        break;

                    // modifica delle informazioni di contatto
                    case 'contatti':
                        $msg = array();
                        $this->aggiornaEmail($user, $request, $msg);
                        if (isset($request['ricevimento'])) {
                            if (!$user->setRicevimento($request['ricevimento'])) {
                                $msg[] = '<li>Il ricevimento specificato non &egrave; corretto</li>';
                            }
                        }
                        $this->creaFeedbackUtente($msg, $vd, "Contatti aggiornati");
                        $this->showHomeUtente($vd);
                        break;

                    // modifica della password
                    case 'password':
                        $msg = array();
                        $this->aggiornaPassword($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Password aggiornata");
                        $this->showHomeUtente($vd);
                        break;

                    // richiesta modifica di un appello esistente,
                    // dobbiamo mostrare le informazioni
                    case 'a_modifica':
                        $appelli = $session[self::appelli];
                        if (isset($request['appello'])) {
                            $intVal = filter_var($request['appello'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($intVal)) {
                                $mod_appello = $this->cercaAppelloPerId($intVal, $appelli);
                                $insegnamenti = InsegnamentoFactory::getListaInsegnamentiPerDocente($user);
                                $vd->setStato('a_modifica');
                            }
                        }
                        $this->showHomeUtente($vd);
                        break;

                    // salvataggio delle modifiche ad un appello esistente
                    case 'a_salva':
                        $msg = array();
                        if (isset($request['appello'])) {
                            $intVal = filter_var($request['appello'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($intVal)) {
                                $mod_appello = $this->cercaAppelloPerId($intVal, $appelli);
                                $this->updateAppello($mod_appello, $request, $msg);
                                $this->creaFeedbackUtente($msg, $vd, "Appello aggiornato");
                                if (count($msg) == 0) {
                                    $vd->setSottoPagina('appelli');
                                }
                            }
                        } else {
                            $msg[] = '<li> Appello non specificato </li>';
                        }
                        $this->showHomeUtente($vd);
                        break;

                    // l'utente non vuole modificare l'appello selezionato
                    case 'a_annulla':
                        $vd->setSottoPagina('appelli');
                        $this->showHomeUtente($vd);
                        break;

                    // richesta di visualizzazione del form per la creazione di un nuovo
                    // appello
                    case 'a_crea':
                        $appelli = $session[self::appelli];
                        $vd->setSottoPagina('appelli_crea');
                        $this->showHomeUtente($vd);
                        break;

                    // creazione di un nuovo appello
                    case 'a_nuovo':
                        $appelli = $session[self::appelli];
                        $msg = array();
                        $nuovo = new Appello();
                        $nuovo->setId($this->prossimoIdAppelli($appelli));
                        $this->updateAppello($nuovo, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Appello creato");
                        if (count($msg) == 0) {
                            $vd->setSottoPagina('appelli');
                            $appelli[] = $nuovo;
                            // faccio la copia in sessione
                            $session[self::appelli] = $appelli;
                        }
                        $this->showHomeUtente($vd);
                        break;

                    // mostra la lista degli iscritti
                    case 'a_iscritti':
                        $appelli = $session[self::appelli];
                        if (isset($request['appello'])) {
                            $intVal = filter_var($request['appello'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($intVal)) {
                                $mod_appello = $this->cercaAppelloPerId($intVal, $appelli);
                                $vd->setStato('a_iscritti');
                            }
                        }
                        $this->showHomeUtente($vd);
                        break;

                    // cancella un appello
                    case 'a_cancella':
                        $appelli = $session[self::appelli];
                        if (isset($request['appello'])) {
                            $intVal = filter_var($request['appello'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($intVal)) {
                                $mod_appello = $this->cercaAppelloPerId($intVal, $appelli);
                                $key = array_search($mod_appello, $appelli);
                                if ($key !== false) {
                                    unset($appelli[$key]);
                                    // faccio la copia in sessione
                                    $session[self::appelli] = $appelli;
                                }
                                $this->creaFeedbackUtente($msg, $vd, "Appello eliminato");
                            }
                        }
                        $this->showHomeUtente($vd);
                        break;

                    // richiesta di creazione di un nuovo elenco di esami
                    case 'r_nuovo':
                        $elenco_id = $this->prossimoIndiceElencoListe($session[self::elenco]);
                        // per ora salviamo gli oggetti interi in sessione
                        // quando avremo la persistenza bastano semplicemente gli id
                        $el = new ElencoEsami($elenco_id);
                        $session[self::elenco][$elenco_id] = $el;
                        $elenchi_attivi = $session[self::elenco];

                        $this->showHomeUtente($vd);
                        break;

                    // selezione dell'insegnamento
                    case 'r_sel_insegnamento':
                        if (isset($elenco_id)) {
                            $commissione = $session[self::elenco][$elenco_id]->getTemplate()->getCommissione();
                            // richiesta di andare al passo successivo
                            if (!isset($request['insegnamento'])) {
                                $msg[] = "<li> Non &egrave; stato selezionato un insegnamento</li>";
                            } else {
                                $insegnamento = InsegnamentoFactory::creaInsegnamentoDaCodice($request['insegnamento']);
                                if (!isset($insegnamento)) {
                                    $msg[] = "<li> L'insegnamento specificato non &egrave; corretto</li>";
                                }
                            }
                            if (count($msg) == 0) {
                                // nessun errore, impostiamo l'insegnamento
                                $session[self::elenco][$elenco_id]->getTemplate()->setInsegnamento($insegnamento);
                                $sel_insegnamento = $session[self::elenco][$elenco_id]->getTemplate()->getInsegnamento();
                                $vd->setSottoPagina('reg_esami_step2');
                            } else {
                                $vd->setSottoPagina('reg_esami_step1');
                            }
                            $this->creaFeedbackUtente($msg, $vd, "Insegnamento selezionato");
                        }
                        $this->showHomeUtente($vd);
                        break;

                    // aggiunta di un membro della  commissione
                    case 'r_add_commissione':
                        if (isset($elenco_id)) {
                            // richiesta di aggiungere un nuovo membro
                            $index = filter_var($request['nuovo-membro'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($index) && ($new_docente = UserFactory::cercaUtentePerId($index)) != null) {
                                // docente trovato
                                // aggiungiamo il docente alla lista
                                if (!$session[self::elenco][$elenco_id]->getTemplate()->aggiungiMembroCommissione($new_docente)) {
                                    $msg[] = '<li>Il docente specificato &egrave; gi&agrave; in lista </li>';
                                } else {
                                    // copiamo la nuova commissione nella variabile della vista
                                    $commissione = $session[self::elenco][$elenco_id]->getTemplate()->getCommissione();
                                }
                            } else {
                                // docente non trovato
                                $msg[] = '<li>Impossibile trovare il  docente specificato </li>';
                            }
                            $this->creaFeedbackUtente($msg, $vd, "Membro aggiunto in commissione");
                        }
                        $this->showHomeUtente($vd);
                        break;


                    // rimozione di un membro della commissione
                    case 'r_del_commissione':
                        if (isset($elenco_id)) {
                            $index = filter_var($request['index'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($index) && $index >= 0 && $index < count($commissione)) {
                                $old_docente = $session[self::elenco][$elenco_id]->getTemplate()->getCommissione()[$index];
                                if (!$session[self::elenco][$elenco_id]->getTemplate()->rimuoviMembroCommissione($old_docente)) {
                                    $msg[] = '<li>Il docente specificato non &egrave; in lista </li>';
                                } else {
                                    // copiamo la nuova commissione nella variabile della vista
                                    $commissione = $session[self::elenco][$elenco_id]->getTemplate()->getCommissione();
                                }
                            } else {
                                $msg[] = '<li>Impossibile trovare il membro specificato </li>';
                            }
                        }
                        $this->creaFeedbackUtente($msg, $vd, "Membro rimosso dalla commissione");
                        $this->showHomeUtente($vd);
                        break;


                    // salvataggio della commissione per l'elenco
                    case 'r_save_commissione':
                        if (isset($elenco_id)) {
                            if (!$session[self::elenco][$elenco_id]->getTemplate()->commissioneValida()) {
                                $msg[] = '<li>Ci devono essere almeno due membri in commissione</li>';
                            }
                            $this->creaFeedbackUtente($msg, $vd, "Commissione inserita correttamente");
                            if (count($msg) > 0) {
                                $vd->setSottoPagina('reg_esami_step2');
                            }
                        }
                        $this->showHomeUtente($vd);
                        break;

                    // aggiunta di uno statino
                    case 'r_add_esame':
                        if (isset($elenco_id)) {
                            $new_esame = new Esame();
                            $new_esame->setInsegnamento($session[self::elenco][$elenco_id]->getTemplate()->getInsegnamento());
                            $new_esame->setCommissione($session[self::elenco][$elenco_id]->getTemplate()->getCommissione());
                            // aggiungiamo un esame alla lista
                            if (isset($request['matricola'])) {
                                $studente = UserFactory::cercaStudentePerMatricola($request['matricola']);
                                if (!isset($studente)) {
                                    $msg[] = '<li>La matricola specificata non &egrave; associata ad uno studente</li>';
                                } else {
                                    // impostiamo lo studente
                                    $new_esame->setStudente($studente);
                                }
                            } else {
                                $msg[] = '<li>Specificare una matricola</li>';
                            }

                            if (isset($request['voto'])) {
                                if (!$new_esame->setVoto($request['voto'])) {
                                    $msg[] = '<li>Il voto specificato non &egrave; corretto</li>';
                                }
                            } else {
                                $msg[] = '<li>Specificare un voto </li>';
                            }

                            if (count($msg) == 0
                                    && !$session[self::elenco][$elenco_id]->aggiungiEsame($new_esame)) {
                                // esame duplicato
                                $msg[] = '<li>Lo statino specificato &egrave; gi&agrave; presente in elenco </li>';
                            } else {
                                // facciamo una copia aggiornata dell'elenco esami per la vista
                                $sel_esami = $session[self::elenco][$elenco_id]->getEsami();
                            }
                            $this->creaFeedbackUtente($msg, $vd, "Statino inserito in elenco");
                        }
                        $this->showHomeUtente($vd);
                        break;

                    // rimozione di uno statino
                    case 'r_del_esame':
                        if (isset($elenco_id)) {
                            $index = filter_var($request['index'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($index) && $index >= 0 && $index < count($sel_esami)) {
                                $old_statino = $session[self::elenco][$elenco_id]->getEsami()[$index];
                                if (!$session[self::elenco][$elenco_id]->rimuoviEsame($old_statino)) {
                                    $msg[] = '<li>L\'esame specificato non &egrave; in lista </li>';
                                } else {
                                    // facciamo una copia aggiornata dell'elenco esami per la vista
                                    $sel_esami = $session[self::elenco][$elenco_id]->getEsami();
                                }
                            } else {
                                $msg[] = '<li>Impossibile trovare lo statino specificato </li>';
                            }
                            $this->creaFeedbackUtente($msg, $vd, "Statino eliminato correttamente");
                        }
                        $this->showHomeUtente($vd);
                        break;

                    // salvataggio permanente dell'elenco
                    case 'r_salva_elenco':
                        if (isset($elenco_id)) {
                            // simuliamo la persistenza nel db
                            // in realta' cancelliamo l'elenco per il momento
                            if (count($session[self::elenco][$elenco_id]->getEsami()) > 0) {
                                $vd->setStato(null);
                                unset($session[self::elenco][$elenco_id]);
                            } else {
                                $msg[] = '<li> &Egrave; necessario inserire almeno un esame</li>';
                            }
                            $this->creaFeedbackUtente($msg, $vd, "Esami registrati correttamente");
                        }
                        $this->showHomeUtente($vd);
                        break;

                    // cancellazione di un elenco
                    case 'r_del_elenco':
                        if (isset($elenco_id) && array_key_exists($elenco_id, $session[self::elenco])) {
                            unset($session[self::elenco][$elenco_id]);
                            $this->creaFeedbackUtente($msg, $vd, "Elenco cancellato");
                            $elenchi_attivi = $session[self::elenco];
                        }
                        $this->showHomeUtente($vd);
                        break;

                    // ricerca di un esame
                    case 'e_cerca':
                        $msg = array();
                        $this->creaFeedbackUtente($msg, $vd, "Lo implementiamo con il db, fai conto che abbia funzionato ;)");
                        $this->showHomeUtente($vd);
                        break;

                    // default
                    default:
                        $this->showHomeUtente($vd);
                        break;
                }
            } else {
                // nessun comando, dobbiamo semplicemente visualizzare 
                // la vista
                $user = $session[BaseController::user];
                $this->showHomeUtente($vd);
            }
        }


        // richiamo la vista
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

            // l'utente e' un docente, consentiamo l'accesso
            case User::Docente:
                return $_SESSION;

            // l'utente e' un amministratore
            case User::Amministratore:
                if (isset($request[BaseController::impersonato])) {
                    // ha richiesto di impersonare un utente
                    $index = $request[parent::impersonato];
                    if (array_key_exists($index, $_SESSION) &&
                            $_SESSION[$index][BaseController::user]->getRuolo() == User::Docente) {
                        // l'utente che sta impersonando e' un docente,
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

    /**
     * Aggiorna i dati relativi ad un appello in base ai parametri specificati
     * dall'utente
     * @param Appello $mod_appello l'appello da modificare
     * @param array $request la richiesta da gestire 
     * @param array $msg array dove inserire eventuali messaggi d'errore
     */
    private function updateAppello($mod_appello, &$request, &$msg) {
        if (isset($request['insegnamento'])) {
            $insegnamento = InsegnamentoFactory::creaInsegnamentoDaCodice($request['insegnamento']);
            if (isset($insegnamento)) {
                $mod_appello->setInsegnamento($insegnamento);
            } else {
                $msg[] = "<li>Insegnamento non trovato</li>";
            }
        }
        if (isset($request['data'])) {
            $data = DateTime::createFromFormat("d/m/Y", $request['data']);
            if (isset($data) && $data != false) {
                $mod_appello->setData($data);
            } else {
                $msg[] = "<li>La data specificata non &egrave; corretta</li>";
            }
        }
        if (isset($request['posti'])) {
            if (!$mod_appello->setCapienza($request['posti'])) {
                $msg[] = "<li>La capienza specificata non &egrave; corretta</li>";
            }
        }
    }

    /**
     * Ricerca un apperllo per id all'interno di una lista
     * @param int $id l'id da cercare
     * @param array $appelli un array di appelli
     * @return Appello l'appello con l'id specificato se presente nella lista,
     * null altrimenti
     */
    private function cercaAppelloPerId($id, &$appelli) {
        foreach ($appelli as $appello) {
            if ($appello->getId() == $id) {
                return $appello;
            }
        }

        return null;
    }

    /**
     * Calcola l'id per un nuovo appello
     * @param array $appelli una lista di appelli
     * @return int il prossimo id degli appelli
     */
    private function prossimoIdAppelli(&$appelli) {
        $max = -1;
        foreach ($appelli as $a) {
            if ($a->getId() > $max) {
                $max = $a->getId();
            }
        }
        return $max + 1;
    }

    /**
     * Restituisce il prossimo id per gli elenchi degli esami
     * @param array $elenco un elenco di esami
     * @return int il prossimo identificatore
     */
    private function prossimoIndiceElencoListe(&$elenco) {
        if (!isset($elenco)) {
            return 0;
        }

        if (count($elenco) == 0) {
            return 0;
        }

        return max(array_keys($elenco)) + 1;
    }

    /**
     * Restituisce l'identificatore dell'elenco specificato in una richiesta HTTP
     * @param array $request la richiesta HTTP
     * @param array $msg un array per inserire eventuali messaggi d'errore
     * @param array $session la sessione corrente
     * @return l'identificatore dell'elenco selezionato
     */
    private function getIdElenco(&$request, &$msg, &$session) {
        if (!isset($request['elenco'])) {
            $msg[] = "<li> Non &egrave; stato selezionato un elenco</li>";
        } else {
            // recuperiamo l'elenco dalla sessione
            $elenco_id = filter_var($request['elenco'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
            if (!isset($elenco_id) || !array_key_exists($elenco_id, $session[self::elenco])
                    || $elenco_id < 0) {
                $msg[] = "L'elenco selezionato non &egrave; corretto</li>";
                return null;
            }
            return $elenco_id;
        }
        return null;
    }

    
    /**
     * Restituisce l'appello specificato dall'utente tramite una richiesta HTTP
     * @param array $request la richiesta HTTP
     * @param array $msg un array dove inserire eventuali messaggi d'errore
     * @param array $session la sessione corrente
     * @return Appello l'appello selezionato, null se non e' stato trovato
     */
    private function getAppello(&$request, &$msg, &$session) {
        if (!isset($request['appello'])) {
            
        } else {
            $appello_id = filter_var($request['appello'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
            $appello = $this->cercaAppelloPerId($appello_id, $session[self::appelli]);
            if ($appello == null) {
                $msg[] = "L'appello selezionato non &egrave; corretto</li>";
            }
            return $appello;
        }
        return null;
    }

    /**
     * Inizializza la variabile di sessione che contiene gli appelli
     * @param User $user l'utente corrente
     * @param array $session la sessione corrente
     */
    private function initAppelli($user, &$session) {
        if (!isset($session[self::appelli])) {
            $appelli = AppelloFactory::getAppelliPerDocente($user);
            $session[self::appelli] = $appelli;
        }
    }

}

?>
