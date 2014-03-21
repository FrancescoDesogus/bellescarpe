<?php

include_once 'Esame.php';
/**
 * Classe che rappresenta un elenco di esami da inserire da parte di un Docente
 *
 * @author Davide Spano
 */
class ElencoEsami {

    
    /**
     * Un template per la costruzione degli esami da inserire in lista
     * (la lista di esami e' omogenea, cioe' ha la stessa commissione,
     * lo stesso docente, lo stesso insegnamento)
     * @var Esame 
     */
    private $template;
    
    /**
     * La lista degli esami inseriti
     * @var array
     */
    private $esami;
    
    /**
     * Costruttore della lista di esami
     * @var int un identificatore per la lista
     */
    private $id;

    public function __construct($id) {
        $this->id = intval($id);
        $this->template = new Esame();
        $this->esami = array();
    }
    
    /**
     * Restituisce l'esame che fa da matrice (per commissione, docente e 
     * insegnamento) a tutti gli esami inseriti nella lista
     * @return Esame
     */
    public function getTemplate(){
        return $this->template;
    }
    
    /**
     * Restituisce l'indentificatore unico 
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Aggiunge un esame alla lista
     * @param Esame $esame l'esame da aggiungere
     * @return boolean true se l'esame e' stato aggiunto correttamente,
     * false se era gia' presente in lista e non e' stato aggiunto
     */
    public function aggiungiEsame(Esame $esame) {
        $pos = $this->posizione($esame);
        if($pos > -1){
            // esame gia' inserito
            return false;
        }
        $this->esami[] = $esame;
        return true;
    }

    
    /**
     * Rimuove un esame dalla lista
     * @param Esame $esame l'esame della lista
     * @return boolean true se l'esame e' stato rimosso, false altrimenti (es. 
     * non era in lista)
     */
    public function rimuoviEsame(Esame $esame) {
        $pos = $this->posizione($esame);
        echo var_dump($pos);
        if ($pos > -1) {
            array_splice($this->esami, $pos, 1);
            return true;
        }

        return false;
    }

    
    /**
     * Restituisce la lista di esami
     * @return array
     */
    public function &getEsami() {
        return $this->esami;
    }

    /**
     * Trova la posizione di un esame nella lista
     * @param Esame $esame l'esame da trovare
     * @return int la posizione dell'esame se presente, false altrimenti
     */
    private function posizione(Esame $esame) {
        for ($i = 0; $i < count($this->esami); $i++) {
            if ($this->esami[$i]->equals($esame)) {
                return $i;
            }
        }
        return -1;
    }

}

?>
