<?php

include_once 'Dipartimento.php';
include_once 'CorsoDiLaurea.php';

/**
 * Classe per creare oggetti di tipo CorsoDiLaurea
 *
 * @author Davide Spano
 */
class CorsoDiLaureaFactory {

    
    /**
     * Restiuisce la lista di CorsiDiLaurea per un Dipartimento
     * @param Dipartimento $dip il Dipartimento in questione
     * @return array|\CorsoDiLaurea
     */
    public static function &getCorsiDiLaureaPerDipartimento(Dipartimento $dip) {
        $cdl = array();
        if (!isset($dip)) {
            return $cdl;
        }
        switch ($dip->getId()) {
            case 0:
                $c1 = new CorsoDiLaurea();
                $c1->setCodice('INF');
                $c1->setNome('Informatica');

                $c2 = new CorsoDiLaurea();
                $c2->setCodice('MAT');
                $c2->setNome('Matematica');

                $cdl[] = $c1;
                $cdl[] = $c2;
                break;
        }

        return $cdl;
    }

    
    /**
     * Restituisce tutti i CorsiDiLaurea esistenti
     * @return array|\CorsoDiLaurea
     */
    public static function &getCorsiDiLaurea() {
        $cdl = array();
        $c1 = new CorsoDiLaurea();
        $c1->setCodice('INF');
        $c1->setNome('Informatica');

        $c2 = new CorsoDiLaurea();
        $c2->setCodice('MAT');
        $c2->setNome('Matematica');

        $cdl[] = $c1;
        $cdl[] = $c2;
        return $cdl;
    }

}

?>
