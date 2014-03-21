<?php

include_once 'Appello.php';
include_once 'UserFactory.php';
include_once 'InsegnamentoFactory.php';
include_once 'Studente.php';
include_once 'Docente.php';
include_once 'User.php';

/**
 * Classe per creare oggetti di tipo Appello
 *
 * @author Davide Spano
 */
class AppelloFactory {

    
    /**
     * Restituisce tutti gli appelli a cui uno studente e' iscritto
     * @param Studente $studente lo studente per la ricerca
     * @return array una lista di appelli (riferimento)
     */
    public static function &getAppelliPerStudente(Studente $studente) {
        // simuliamo il caricamento dal db
        $i = InsegnamentoFactory::getListaInsegnamenti();

        $appelli = array();
        switch ($studente->getMatricola()) {
            case 253662:
                // creo un appello a cui sono gia' iscritto
                $a1 = new Appello();
                $a1->setId(1);
                $a1->setCapienza(1);
                $a1->setInsegnamento($i[2]);
                $a1->setData(new DateTime());
                $a1->getData()->setDate(2013, 6, 7);
                $a1->iscrivi($studente);

                // creo un appello a cui non mi posso iscrivere 
                $a2 = new Appello();
                $a2->setId(2);
                $a2->setCapienza(0);
                $a2->setInsegnamento($i[1]);
                $a2->setData(new DateTime());
                $a2->getData()->setDate(2013, 6, 14);

                // creo un appello a cui mi posso iscrivere 
                $a3 = new Appello();
                $a2->setId(3);
                $a3->setCapienza(5);
                $a3->setInsegnamento($i[0]);
                $a3->setData(new DateTime());
                $a3->getData()->setDate(2013, 6, 21);


                $appelli[] = $a1;
                $appelli[] = $a2;
                $appelli[] = $a3;

                break;
        }

        return $appelli;
    }

    
    /**
     * Restituisce tutti gli appelli inseriti da un dato Docente
     * @param Docente $docente il docente per la ricerca
     * @return array una lista di appelli (riferimento)
     */
    public static function &getAppelliPerDocente(Docente $docente) {
        $i = InsegnamentoFactory::getListaInsegnamenti();
        $appelli = array();
        switch ($docente->getCognome()) {
            case 'Spano':
                // creo un appello a cui sono gia' iscritto
                $a1 = new Appello();
                $a1->setId(1);
                $a1->setCapienza(10);
                $a1->setInsegnamento($i[2]);
                $a1->setData(new DateTime());
                $a1->getData()->setDate(2013, 6, 7);
                $appelli[] = $a1;
                $studenti = UserFactory::getListaStudenti();
                foreach($studenti as $s){
                    $a1->iscrivi($s);
                }
                break;
        }
        return $appelli;
    }

}

?>
