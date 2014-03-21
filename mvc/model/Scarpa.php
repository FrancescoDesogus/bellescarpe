<?php

/**
 * Rappresenta un appello di esame, che viene pubblicato da un Docente per
 * un Insegnamento. Uno Studente puo' iscriversi ad ad un appello.
 *
 * @author Davide Spano
 */
class Scarpa {

    /**
     * Identificatore della scarpa
     */
    private $id;
    
    /**
     * La data dell'appello
     * @var DateTime 
     */
    private $marca;
    
    /**
     * Lista degli iscritti
     * @var array 
     */
    private $modello;
    
    /**
     * L'insegnamento oggetto dell'appello
     * @var Insegnamento 
     */
    private $colore;
    
    /**
     * Quanti studenti si possono iscrivere al massimo per questo appello
     * @var int
     */
    private $prezzo;
    
    /**
     * Identificatore dell'appello
     * @var int
     */
    private $categoria;
    
    
    /*
     * Array di taglie disponibili
     */
    private $taglie;
    
    /**
     * Costrutture dell'appello
     */
    public function __construct() {
        $this->taglie = array();
    }

    /**
     * Restituisce l'indentificatore dell'appello
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Modifica il valore dell'identificatore 
     * @param int $id il nuovo id per l'appello
     * @return boolean true se il valore e' stato modificato, 
     *                 false altrimenti
     */
    public function setId($id) {
        $intVal = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intVal)) {
            return false;
        }
        $this->id = $intVal;
        return true;
    }

    /**
     * Restituisce la data dell'appello
     * @return DateTime
     */
    public function getMarca() {
        return $this->marca;
    }

    /**
     * Modifica il valore della data dell'appello
     * @param DateTime $data il nuovo valore della data
     * @return boolean true se il nuovo valore della data e' stato impostato,
     * false nel caso il valore non sia ammissibile
     */
    public function setMarca($marca) {
        $this->marca = $marca;
        return true;
    }

    /**
     * Restituisce la lista di iscritti (per riferimento)
     * @return array
     */
    public function &getTaglie() {
        return $this->taglie;
    }
    
    public function setTaglie($taglie){
        $this->taglie = $taglie;
    }
    
    /**
     * Restituisce il numero di iscritti
     * @return int
     */
    public function numeroTaglie(){
        return count($this->taglie);
    }

    /**
     * Restituisce l'insegnamento per l'appello
     * @return Insegnamento
     */
    public function getModello() {
        return $this->modello;
    }

    /**
     * Imposta l'insegnamento per l'appello
     * @param Insegnamento $insegnamento il nuovo insegnamento
     */
    public function setModello($modello) {
        $this->modello = $modello;
    }
    
    public function getPrezzo(){
        return $this->prezzo;
    }
    
    public function setPrezzo($prezzo){
        $this->prezzo = $prezzo;
    }
    
    public function getColore(){
        return $this->colore;
    }
    
    public function setColore($colore){
        $this->colore = $colore;
    }
    
    public function getCategoria(){
        return $this->categoria;
    }
    
    public function setCategoria($categoria){
        $this->categoria = $categoria;
    }

}

?>
