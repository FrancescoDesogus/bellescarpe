<?php

include_once 'User.php';
include_once 'CorsoDiLaurea.php';

/**
 * Classe che rappresenta uno Studente
 * @author Davide Spano
 */
class Studente extends User {

    /**
     * Matricola dello studente
     * @var int
     */
    private $matricola;

    /**
     * CorsoDiLaurea a cui lo studente e' iscritto
     * @var CorsoDiLaurea cdl
     */
    private $cdl;

    /**
     * Costruttore della classe
     */
    public function __construct() {
        // richiamiamo il costruttore della superclasse
        parent::__construct();
        $this->setRuolo(User::Studente);
        
    }

    /**
     * Restituisce la matricola per lo studente
     * @return int
     */
    public function getMatricola() {
        return $this->matricola;
    }

    /**
     * Imposta un nuovo valore per la matricola dello studente
     * @param int $matricola la nuova matricola dello studente
     * @return boolean true se il nuovo valore della matricola e' ammissibile
     * ed e' stato impostato, false altrimenti
     */
    public function setMatricola($matricola) {
        $intVal = filter_var($matricola, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (isset($intVal)) {
            $this->matricola = $intVal;
            return true;
        }
        return false;
    }
    
    /**
     * Restituisce il CorsoDiLaurea a cui lo studente e' iscritto
     * @return CorsoDiLaurea
     */
    public function getCorsoDiLaurea() {
        return $this->cdl;
    }

    /**
     * Imposta il CorsoDiLaurea a cui lo studente e' iscritto
     * @param CorsoDiLaurea $cdl il nuovo CorsoDiLaurea
     */
    public function setCorsoDiLaurea(CorsoDiLaurea $cdl) {
        $this->cdl = $cdl;
    }

}

?>
