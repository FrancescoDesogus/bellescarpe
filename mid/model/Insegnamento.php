<?php

include_once 'Docente.php';
include_once 'CorsoDiLaurea.php';

/**
 * Classe che rappresenta un insegnamento
 * @author Davide Spano
 */
class Insegnamento {

    /**
     * Il docente titolare dell'insegnamento
     * @var Docente
     */
    private $docente;
    /**
     * Il CorsoDiLaurea dell'insegnamento
     * @var CorsoDiLaurea
     */
    private $cdl;
    
    /**
     * Il nome dell'insegnamento
     * @var string 
     */
    private $titolo;
    
    /**
     * Un codice breve per l'insegnamento, univoco
     * @var 
     */
    private $codice;
    
    /**
     * Numer di CFU per il corso
     * @var int
     */
    private $cfu;

    /**
     * Costruttore
     * @param string il codice per l'insegnamento
     */
    public function __construct($codice) {
        $this->codice = $codice;
    }

    /**
     * Restituisce il Docente titolare del corso
     * @return Docente
     */
    public function getDocente() {
        return $this->docente;
    }

    /**
     * Imposta il nuovo docente titolare del corso
     * @param Docente $docente il nuovo titolare del corso
     */
    public function setDocente(Docente $docente) {
        $this->docente = $docente;
    }

    /**
     * Restituisce il CorsoDiLaurea cui l'insegnamento afferisce
     * @return CorsoDiLaurea
     */
    public function getCorsoDiLaurea() {
        return $this->cdl;
    }
    
    /**
     * Imposta un nuovo CorsoDiLaurea per l'insegnamento
     * @param CorsoDiLaurea $cdl il nuovo corso di laurea
     */
    public function setCorsoDiLaurea(CorsoDiLaurea $cdl) {
        $this->cdl = $cdl;
    }

    /**
     * Restituisce il nome dell'Insegnamento
     * @return string
     */
    public function getTitolo() {
        return $this->titolo;
    }

    /**
     * Imposta il nome dell'Insegnamento
     * @param string $titolo il nuovo nome per l'Insegnamento
     */
    public function setTitolo($titolo) {
        $this->titolo = $titolo;
    }

  
    /**
     * Restituisce il codice dell'insegnamento
     * @return string
     */
    public function getCodice() {
        return $this->codice;
    }

    /**
     * Imposta un nuovo codice per l'Insegnamento
     * @param string $codice
     */
    public function setCodice($codice) {
        $this->codice = $codice;
    }

    /**
     * Restituisce il numero di CFU per l'insegnamento
     * @return int
     */
    public function getCfu() {
        return $this->cfu;
    }
    
    /**
     * Imposta il numero di cfu per l'Insegnamento
     * @param int $cfu il nuovo numero di CFU
     * @return boolean true se il valore e' ammissibile ed e' stato impostato,
     * false altrimenti
     */
    public function setCfu($cfu) {
        $intVal = filter_var($cfu, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if ($intVal != false) {
            $this->cfu = $intVal;
            return true;
        }
        return false;
    }
    
    /**
     * Compara due insegnamenti verificando l'uguaglianza logica
     * @param Insegnamento $insegnamento l'insegnamento con cui comparare $this
     * @return boolean true se sono logicamente uguali, false altrimenti
     */
    public function equals(Insegnamento $insegnamento){
        if(!isset($insegnamento)){
            return false;
        }
        return $this->codice == $insegnamento->codice;
    }

}

?>
