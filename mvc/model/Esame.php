<?php

include_once 'Studente.php';
include_once 'Docente.php';
include_once 'Insegnamento.php';


/**
 * Classe che rappresenta un Esame
 * @author Davide Spano
 */
class Esame {

    /**
     * Il voto di un esame e' troppo alto
     */
    const Alto = 1;
    /**
     * Il voto di un esame e' troppo basso
     */
    const Basso = 2;
    /**
     * Il voto di un esame e' ammissibile
     */
    const Ok = 0;
    /**
     * Il voto dell'esame non e' ammissibile
     */
    const Inammissibile = 3;

    /**
     *
     * @var Studente $studente
     */
    private $studente;
    private $voto;

    /**
     *
     * @var Docente $presidente
     */
//    private $presidente;

    private $commissione;

    /**
     *
     * @var Insegnamento $insegnamento
     */
    private $insegnamento;

    /**
     *
     * @var DateTime $data
     */
    private $data;
    
    private $id;

    public function __construct() {
        $this->commissione = array();
    }

    public function getStudente() {
        return $this->studente;
    }

    public function setStudente(Studente $studente) {
        $this->studente = $studente;
    }

    public function getInsegnamento() {
        return $this->insegnamento;
    }

    public function setInsegnamento(Insegnamento $insegnamento) {
        $this->insegnamento = $insegnamento;
    }

    public function getId(){
        return $this->id;
    }
    
    public function setId($id){
        $intVal = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if(isset($intVal)){
            $this->id = $intVal;
            return true;
        }
        
        return false;
    }

    public function aggiungiMembroCommissione(Docente $membro) {
        // non inseriamo duplicati
        foreach ($this->commissione as $docente) {
            if ($docente->equals($membro)) {
                return false;
            }
        }
        $this->commissione[] = $membro;
        return true;
    }

    public function rimuoviMembroCommissione(Docente $membro) {
        $pos = $this->posizione($membro);
        if ($pos > -1) {
            array_splice($this->commissione, $pos, 1);
            return true;
        }

        return false;
    }

    public function &getCommissione() {
        return $this->commissione;
    }
    
    public function setCommissione(&$commissione){
        $this->commissione = $commissione;
    }

    public function getVoto() {
        return $this->voto;
    }

    public function setVoto($voto) {
        if ($this->checkVoto($voto) == self::Ok) {
            $this->voto = $voto;
            return true;
        }
        return false;
    }

    public function setData(DateTime $data) {
        $this->data = $data;
    }

    public function getData() {
        return $this->data;
    }

    public function checkVoto($voto) {
        $intVal = filter_var($voto, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (isset($intVal)) {
            if ($intVal > 31) {
                return self::Alto;
            }
            if ($intVal < 18) {
                return self::Basso;
            }
            return self::Ok;
        }
        return self::Inammissibile;
    }

    public function commissioneValida() {
        return count($this->commissione) >= 2;
    }
    
    public function equals(Esame $esame){
        if(!isset($esame)){
            return false;
        }
        
        return $this->getStudente()->equals($esame->getStudente()) &&
                $this->getInsegnamento()->equals($esame->getInsegnamento());
    }

    private function posizione(Docente $membro) {
        for ($i = 0; $i < count($this->commissione); $i++) {
            if ($this->commissione[$i]->equals($membro)) {
                return $i;
            }
        }
        return -1;
    }
    
    

}

?>
