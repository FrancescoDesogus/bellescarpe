<?php

include_once 'User.php';
include_once 'Dipartimento.php';

/**
 * Classe che rappresenta un Docente
 *
 * @author Davide Spano
 */
class Docente extends User {

    /**
     * Il Dipartimento di afferenza
     * @var Dipartimento $dipartimento 
     */
    private $dipartimento;
    /**
     * Descrizione dell'orario di ricevimento
     * @var string
     */
    private $ricevimento;

    /**
     * Costruttore
     */
    public function __construct() {
        // richiamiamo il costruttore della superclasse
        parent::__construct();
        $this->setRuolo(User::Docente);
    }

    /**
     * Restituisce il Dipartimento di afferenza
     * @return Dipartimento
     */
    public function getDipartimento() {
        return $this->dipartimento;
    }

    /**
     * Imposta un nuovo Dipartimento di afferenza
     * @param Dipartimento $dipartimento il nuovo Dipartimento di afferenza
     */
    public function setDipartimento(Dipartimento $dipartimento) {
        $this->dipartimento = $dipartimento;
    }

    /**
     * Imposta un nuovo valore per l'orario di ricevimento
     * @param string $ricevimento il nuovo orario di ricevimento
     * @return boolean true se impostato correttamente, false altrimenti
     */
    public function setRicevimento($ricevimento) {
        $this->ricevimento = $ricevimento;
        return true;
    }

    /**
     * Restituisce la descrizione dell'orario di ricevimento
     * @return string
     */
    public function getRicevimento() {
        return $this->ricevimento;
    }

}

?>
