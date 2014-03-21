<?php

include_once 'Dipartimento.php';

/**
 * Classe che rappresenta un corso di laurea
 * @author Davide Spano
 */
class CorsoDiLaurea {

    /**
     * Il nome di un corso di laurea
     * @var string
     */
    private $nome;

    /**
     * Un codice breve per il corso di laurea
     * @var string 
     */
    private $codice;

    /**
     * Un identificatore per il corso di laura
     * @var int
     */
    private $id;

    /**
     * Il Diparmento di afferenza
     * @var Dipartimento $dipartimento 
     */
    private $dipartimento;

    /**
     * Costruttore
     */
    public function __construct() {
        
    }

    /**
     * Imposta l'identificatore del CorsoDiLaurea
     * @param int $id il nuovo identificatore
     * @return boolean true se l'identificatore e' stato impostato, false altrimenti
     */
    public function setId($id) {
        $intVal = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (isset($intVal)) {
            $this->id = $intVal;
            return true;
        }

        return false;
    }

    /**
     * Restiusce l'identificatore del CorsoDiLaurea
     * @return int l'identificatore del CorsoDiLaurea
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Restituisce il codice del CorsoDiLaurea
     * @return string
     */
    public function getCodice() {
        return $this->codice;
    }

    /**
     * Imposta il codice del CorsoDiLaurea
     * @param string $codice il nuovo codice del CorsoDiLaurea
     */
    public function setCodice($codice) {
        $this->codice = $codice;
    }

    /**
     * Restituisce il nome del CorsoDiLaurea
     * @return string
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Imposta il nome del CorsoDiLaurea
     * @param string $nome
     */
    public function setNome($nome) {
        $this->nome = $nome;
    }

    /**
     * Restituisce il Dipartimento di afferenza
     * @return Dipartimento
     */
    public function getDipartimento() {
        return $this->dipartimento;
    }

    /**
     * Imposta il Dipartimento di afferenza
     * @param Dipartimento $dip il nuovo Dipartimento di afferenza
     */
    public function setDipartimento(Dipartimento $dip) {
        $this->dipartimento = $dip;
    }

    /**
     * Restituisce la relazione di uguaglianza logica fra due CorsiDiLaurea
     * @param CorsoDiLaurea $other il CorsoDiLaurea con cui confrontare $this
     * @return boolean true se sono logicamente uguali, false altrimenti
     */
    public function equals(CorsoDiLaurea $other) {
        return $other->codice == $this->codice;
    }

}

?>
