<?php

include_once 'Studente.php';
include_once 'Insegnamento.php';

/**
 * Rappresenta un appello di esame, che viene pubblicato da un Docente per
 * un Insegnamento. Uno Studente puo' iscriversi ad ad un appello.
 *
 * @author Davide Spano
 */
class Appello {

    /**
     * La data dell'appello
     * @var DateTime 
     */
    private $data;
    
    /**
     * Lista degli iscritti
     * @var array 
     */
    private $iscritti;
    
    /**
     * L'insegnamento oggetto dell'appello
     * @var Insegnamento 
     */
    private $insegnamento;
    
    /**
     * Quanti studenti si possono iscrivere al massimo per questo appello
     * @var int
     */
    private $capienza;
    
    /**
     * Identificatore dell'appello
     * @var int
     */
    private $id;

    
    /**
     * Costrutture dell'appello
     */
    public function __construct() {
        $this->iscritti = array();
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
    public function getData() {
        return $this->data;
    }

    /**
     * Modifica il valore della data dell'appello
     * @param DateTime $data il nuovo valore della data
     * @return boolean true se il nuovo valore della data e' stato impostato,
     * false nel caso il valore non sia ammissibile
     */
    public function setData(DateTime $data) {
        $this->data = $data;
        return true;
    }

    
    /**
     * Iscrive uno studente ad un appello
     * @param Studente $studente lo studente da iscrivere
     * @return boolean true se l'iscrizione e' andata a buon fine, false altrimenti
     */
    public function iscrivi(Studente $studente) {
        if (count($this->iscritti) >= $this->capienza) {
            return false;
        }
        $this->iscritti[] = $studente;
        return true;
    }

    /**
     * Rimuove l'iscrizione di uno studente dall'appello
     * @param Studente $studente lo studente da cancellare
     * @return boolean true se l'iscrizione e' stata cancellata, false altrimenti
     * es. quando lo studente non era stato iscritto precedentemente
     */
    public function cancella(Studente $studente) {

        $pos = $this->posizione($studente);
        if ($pos > -1) {
            array_splice($this->iscritti, $pos, 1);
            return true;
        }

        return false;
    }

    /**
     * Restituisce la lista di iscritti (per riferimento)
     * @return array
     */
    public function &getIscritti() {
        return $this->iscritti;
    }
    
    /**
     * Restituisce il numero di iscritti
     * @return int
     */
    public function numeroIscritti(){
        return count($this->iscritti);
    }

    /**
     * Restituisce il numero massimo di iscritti per l'appello
     * @return int
     */
    public function getCapienza() {
        return $this->capienza;
    }

    /**
     * Modifica il valore massimo per il numero di iscritti all'appello
     * @param int $capienza la nuova capienza del corso
     * @return boolean true se il valore e' stato impostato correttamente, false
     * altrimenti (per esempio se ci sono gia' piu' iscritti del valore passato)
     */
    public function setCapienza($capienza) {
        $intVal = filter_var($capienza, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intVal)) {
            return false;
        }
        if ($intVal < count($this->iscritti)) {
            return false;
        }
        $this->capienza = $intVal;
        return true;
    }

    /**
     * Restiuisce il numero di posti ancora disponibili per l'appello
     * @return int 
     */
    public function getPostiLiberi() {
        return $this->capienza - count($this->iscritti);
    }

    /**
     * Verifica se uno studente sia gia' nella lista di iscritti o meno
     * @param Studente $studente lo studente da ricercare
     * @return boolean true se e' gia' in lista, false altrimenti
     */
    public function inLista(Studente $studente) {
        $pos = $this->posizione($studente);
        if ($pos > -1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Restituisce l'insegnamento per l'appello
     * @return Insegnamento
     */
    public function getInsegnamento() {
        return $this->insegnamento;
    }

    /**
     * Imposta l'insegnamento per l'appello
     * @param Insegnamento $insegnamento il nuovo insegnamento
     */
    public function setInsegnamento(Insegnamento $insegnamento) {
        $this->insegnamento = $insegnamento;
    }

    /**
     * Calcola la posizione di uno studente all'interno della lista
     * @param Studente $studente lo studente da ricercare
     * @return int la posizione dello studente nella lista, -1 se non e' stato 
     * inserito
     */
    private function posizione(Studente $studente) {
        for ($i = 0; $i < count($this->iscritti); $i++) {
            if ($this->iscritti[$i]->equals($studente)) {
                return $i;
            }
        }
        return -1;
    }

}

?>
