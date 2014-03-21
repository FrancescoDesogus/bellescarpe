<?php
/**
 * Classe che rappresenta un Dipartimento
 * @author Davide Spano
 */
class Dipartimento {

    /**
     * Il nome del Dipartimento
     * @var string 
     */
    private $nome;
    /**
     * L'identificatore del Dipartimento
     * @var int
     */
    private $id;

    
    /**
     * Costrutture di un Dipartimento
     */
    public function __construct() {
        
    }

    /**
     * Imposta il nome di un Dipartimento
     * @param string $nome il nuovo nome per il Dipartimento
     */
    public function setNome($nome){
        $this->nome = $nome;
    }
    
    /**
     * Restituisce il nome di un Dipartimento
     * @return string
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Restituisce l'identificatore del Dipartimento
     * @return int
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Imposta un nuovo identificatore per il Dipartimento
     * @param int $id
     */
    public function setId($id){
        $this->id = $id;
    }

    /**
     * Verifica se due oggetti Dipartimento sono logicamente uguali
     * @param Dipartimento $other l'oggetto con cui confrontare $this
     * @return boolean true se i due oggetti sono logicamente uguali, false 
     * altrimenti
     */
    public function equals(Dipartimento $other) {
        return $other->id == $this->id;
    }
    
    

}

?>
