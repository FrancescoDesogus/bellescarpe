<?php

include_once 'Docente.php';
include_once 'UserFactory.php';
include_once 'Insegnamento.php';

/**
 * Classe per creare liste di Insegnamenti
 *
 * @author amm
 */
class InsegnamentoFactory {

    /**
     * Restituisce la lista di tutti gli insegnamenti presenti nel sistema
     * @return array|\Insegnamento
     */
    public static function &getListaInsegnamenti() {
        // simuliamo il caricamento dal db
        $d = UserFactory::getListaDocenti();

        $i1 = new Insegnamento('PR1');
        $i1->setTitolo("Programmazione 1");
        $i1->setDocente($d[0]);
        $i1->setCfu(9);

        $i2 = new Insegnamento('RC');
        $i2->setTitolo("Reti di Calcolatori");
        $i2->setDocente($d[1]);
        $i2->setCfu(6);

        $i3 = new Insegnamento('AMM');
        $i3->setTitolo("Amministrazione di Sistema");
        $i3->setDocente($d[2]);
        $i3->setCfu(6);

        $insegnamenti = array();
        $insegnamenti[] = $i1;
        $insegnamenti[] = $i2;
        $insegnamenti[] = $i3;
        return $insegnamenti;
    }

    /**
     * Crea un insegnamento a partire dal codice
     * @param string $codice
     * @return Insegnamento
     */
    public static function creaInsegnamentoDaCodice($codice) {
        // simuliamo il caricamento dal db
        $d = UserFactory::getListaDocenti();

        switch ($codice) {
            case 'HCI':
                $i2 = new Insegnamento('HCI');
                $i2->setTitolo("Human Computer Interaction");
                $i2->setDocente($d[2]);
                $i2->setCfu(6);
                return $i2;

            case 'AMM':
                $i3 = new Insegnamento('AMM');
                $i3->setTitolo("Amministrazione di Sistema");
                $i3->setDocente($d[2]);
                $i3->setCfu(6);
                return $i3;
        }

        return null;
    }

    /**
     * Restituisce la lista di Insegnamenti associati ad un Docente
     * @param Docente $docente il Docente in questione
     * @return \Insegnamento
     */
    public static function &getListaInsegnamentiPerDocente(Docente $docente) {
        // simuliamo il caricamento dal db
        $d = UserFactory::getListaDocenti();
        $insegnamenti = array();
        switch ($docente->getCognome()) {
            case 'Spano':

                $i2 = new Insegnamento('HCI');
                $i2->setTitolo("Human Computer Interaction");
                $i2->setDocente($d[2]);
                $i2->setCfu(6);

                $i3 = new Insegnamento('AMM');
                $i3->setTitolo("Amministrazione di Sistema");
                $i3->setDocente($d[2]);
                $i3->setCfu(6);


                $insegnamenti[] = $i2;
                $insegnamenti[] = $i3;
                break;
        }
        return $insegnamenti;
    }

}

?>
