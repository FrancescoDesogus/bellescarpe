<?php

/**
 * Classe che rappresenta un generico utente del sistema
 */
class User {

    /**
     * Costante che definisce il ruolo amministratore
     */
    const Amministratore = 0;
    
    /**
     * Costante che definisce il ruolo docente
     */
    const Docente = 1;
    
    /**
     * Costante che definisce il ruolo studente
     */
    const Studente = 2;

    
    /**
     * Username per l'autenticazione
     * @var string
     */
    private $username;
    
    /**
     * Password per l'autenticazione
     * @var string
     */
    private $password;
    
    /**
     * Nome dell'utente
     * @var string
     */
    private $nome;
    
    /**
     * Cognome dell'utente
     * @var string 
     */
    private $cognome;
    
    /** 
     * email dell'utente
     * @var string
     */
    private $email;
    
    /**
     * Il ruolo dell'utente nell'applicazione.
     * Lo utilizzo per implementare il controllo degli accessi
     * @var int 
     */
    private $ruolo;
    /**
     * Via dell'abitazione dell'utente
     * @var string
     */
    private $via;
    
    /**
     * Numero civico dell'abitazione. Consideriamo interi, quindi non 1a, 1b ecc.
     * @var int 
     */
    private $numeroCivico;
    
    /**
     * Citta di residenza dell'utente. Anche qui permettiamo l'inserimento
     * di citta' anche inventate
     * @var string
     */
    private $citta;
    
    /**
     * Provincia di residenza dell'utente
     * @var string
     */
    private $provincia;
    /**
     * Cap dell'utente. Lo vogliamo max di cinque cifre
     * @var int 
     */
    private $cap;
    
    /**
     * Identificatore dell'utente
     * @var int
     */
    private $id;

    /**
     * Costruttore
     */
    public function __construct() {
        
    }

    /**
     * Verifica se l'utente esista per il sistema
     * @return boolean true se l'utente esiste, false altrimenti
     */
    public function esiste() {
        // implementazione di comodo, va fatto con il db
        return isset($this->ruolo);
    }

    /**
     * Restituisce lo username dell'utente
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Imposta lo username per l'autenticazione dell'utente. 
     * I nomi che si ritengono validi contengono solo lettere maiuscole e minuscole.
     * La lunghezza del nome deve essere superiore a 5
     * @param string $username
     * @return boolean true se lo username e' ammissibile ed e' stato impostato,
     * false altrimenti
     */
    public function setUsername($username) {
        // utilizzo la funzione filter var specificando un'espressione regolare
        // che implementa la validazione personalizzata
        if (!filter_var($username, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/[a-zA-Z]{5,}/')))) {
            return false;
        }
        $this->username = $username;
        return true;
    }

    /**
     * Restituisce la password per l'utente corrente
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Imposta la password per l'utente corrente
     * @param string $password
     * @return boolean true se la password e' stata impostata correttamente,
     * false altrimenti
     */
    public function setPassword($password) {
        $this->password = $password;
        return true;
    }

    /**
     * Restituisce il nome dell'utente
     * @return string
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Imposta il nome dell'utente
     * @param string $nome
     * @return boolean true se il nome e' stato impostato correttamente, 
     * false altrimenti 
     */
    public function setNome($nome) {
        $this->nome = $nome;
        return true;
    }

    /**
     * Restituisce il cognome dell'utente
     * @return string
     */
    public function getCognome() {
        return $this->cognome;
    }

    /**
     * Imposta il cognome dell'utente
     * @param string $cognome
     * @return boolean true se il cognome e' stato impostato correttamente,
     * false altrimenti
     */
    public function setCognome($cognome) {
        $this->cognome = $cognome;
        return true;
    }

    /**
     * Restituisce un intero 
     * @return int
     */
    public function getRuolo() {
        return $this->ruolo;
    }

    /**
     * Imposta un ruolo per un dato utente
     * @param int $ruolo
     * @return boolean true se il valore e' ammissibile ed e' stato impostato,
     * false altrimenti
     */
    public function setRuolo($ruolo) {
        switch ($ruolo) {
            case self::Amministratore:
            case self::Docente:
            case self::Studente:
                $this->ruolo = $ruolo;
                return true;
            default:
                return false;
        }
    }

    /**
     * Restituisce l'email dell'utente
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Imposta una nuova email per l'utente
     * @param string $email la nuova email dell'utente
     * @return boolean true il nuovo l
     */
    public function setEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        $this->email = $email;
        return true;
    }

    /**
     * Restituisce la via di abitazione dell'utente
     * @return string
     */
    public function getVia() {
        return $this->via;
    }

    /**
     * Imposta un nuovo valore per la via
     * @param type $via
     * @return boolean true se la via e' stata impostata correttamente, false
     * altrimenti
     */
    public function setVia($via) {
        $this->via = $via;
        return true;
    }

    
    /**
     * Restituisce il valore del numero civico di abitazione dell'utente
     * @return int
     */
    public function getNumeroCivico() {
        return $this->numeroCivico;
    }

    /**
     * Imposta il valore del numero civico dell'utente
     * @param string $civico il nuovo numero civico
     * @return boolean true se il valore e' ammissibile ed e' stato aggiornato
     * correttamente, false altrimenti
     */
    public function setNumeroCivico($civico) {
        $intVal = filter_var($civico, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (isset($intVal)) {
            $this->numeroCivico = $intVal;
            return true;
        }
        return false;
    }

    /**
     * Imposta la citta di abitazione dell'utente
     * @param string $citta la nuova citta' di abitazione dell'utente
     * @return boolean true se il valore e' stato aggiornato correttamente,
     * false altrimenti
     */
    public function setCitta($citta) {
        $this->citta = $citta;
        return true;
    }

    /**
     * Restituisce la citta' di abitazione dell'utente
     * @return string
     */
    public function getCitta() {
        return $this->citta;
    }

    /**
     * Imposta la provincia di abitazione dell'utente
     * @param string $provincia la nuova provincia di abitazione dell'utente
     * @return boolean true se il valore e' stato aggiornato correttamente,
     * false altrimenti
     */
    public function setProvincia($provincia) {
        $this->provincia = $provincia;
        return true;
    }

    /**
     * Restituisce la provincia di abitazione dell'utente
     * @return string
     */
    public function getProvincia() {
        return $this->provincia;
    }

    /**
     * Restituisce il cap di abitazione dell'utente
     * @return int
     */
    public function getCap() {
        return $this->cap;
    }

    /**
     * Imposta il cap di abitazione dell'utente
     * @param int $cap
     * @return boolean true se il nuovo valore e' ammissibile ed e' stato 
     * impostato, false altrimenti
     */
    public function setCap($cap) {
        if (!filter_var($cap, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/[0-9]{5}/')))) {
            return false;
        }
        $this->cap = $cap;
        return true;
    }

    
    /**
     * Restituisce un identificatore unico per l'utente
     * @return int
     */
    public function getId(){
        return $this->id;
    }
    
    /**
     * Imposta un identificatore unico per l'utente
     * @param int $id
     * @return boolean true se il valore e' stato aggiornato correttamente,
     * false altrimenti
     */
    public function setId($id){
        $intVal = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if(!isset($intVal)){
            return false;
        }
        $this->id = $intVal;
    }
    
    /**
     * Compara due utenti, verificandone l'uguaglianza logica
     * @param User $user l'utente con cui comparare $this
     * @return boolean true se i due oggetti sono logicamente uguali, 
     * false altrimenti
     */
    public function equals(User $user) {

        return  $this->id == $user->id &&
                $this->nome == $user->nome &&
                $this->cognome == $user->cognome &&
                $this->ruolo == $user->ruolo;
    }

}

?>
