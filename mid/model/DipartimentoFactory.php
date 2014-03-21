<?php

include_once 'Dipartimento.php';

/**
 * Classe per creare oggetti di tipo Dipartimento
 *
 * @author Davide Spano
 */
class DipartimentoFactory {
    
    /**
     * Restituisce la lista di tutti i Dipartimenti
     * @return array|\Dipartimento
     */
    public static function &getDipartimenti(){
        $d1 = new Dipartimento();
        $d1->setId(0);
        $d1->setNome('Matematica e Informatica');
        
        $d2 = new Dipartimento();
        $d2->setId(1);
        $d2->setNome('Ingegneria');
        
        $d3 = new Dipartimento();
        $d3->setId(2);
        $d3->setNome('Architettura');
        
        $d4 = new Dipartimento();
        $d4->setId(3);
        $d4->setNome('Lettere');
        
        $dip = array();
        $dip[] = $d1;
        $dip[] = $d2;
        $dip[] = $d3;
        $dip[] = $d4;
        return $dip;
    }
}

?>
