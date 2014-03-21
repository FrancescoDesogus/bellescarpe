<?php

include_once 'Esame.php';
include_once 'Studente.php';
include_once 'Docente.php';
include_once 'Insegnamento.php';
include_once 'UserFactory.php';
include_once 'InsegnamentoFactory.php';

/**
 * Classe per la creazione degli esami
 *
 * @author Davide Spano
 */
class EsameFactory {

    /**
     * Costruttore
     */
    private function __construct() {
        ;
    }

    /**
     * Restituisce la lista di esami per un dato studente
     * @param Studente $user
     */
    public static function &esamiPerStudente(Studente $user) {
        $d = UserFactory::getListaDocenti();
        $i = InsegnamentoFactory::getListaInsegnamenti();

        $esami = array();
        // simuliamo il caricaemento da un db
        switch ($user->getMatricola()) {
            case 253662:
                $e1 = new Esame();
                $e1->setStudente($user);
                $e1->setVoto(24);
                $e1->setInsegnamento($i[0]);
                $e1->aggiungiMembroCommissione($d[1]);
                $e1->aggiungiMembroCommissione($d[2]);
                $e1->setData(new DateTime());
                $e1->getData()->setDate(2009, 3, 21);

                $e2 = new Esame();
                $e2->setStudente($user);
                $e2->setVoto(27);
                $e2->setInsegnamento($i[1]);
                $e2->aggiungiMembroCommissione($d[0]);
                $e2->aggiungiMembroCommissione($d[2]);
                $e2->setData(new DateTime());
                $e2->getData()->setDate(2009, 5, 24);

                $e3 = new Esame();
                $e3->setStudente($user);
                $e3->setVoto(24);
                $e3->setInsegnamento($i[2]);
                $e3->aggiungiMembroCommissione($d[0]);
                $e3->aggiungiMembroCommissione($d[1]);
                $e3->setData(new DateTime());
                $e3->getData()->setDate(2009, 9, 5);

                $esami[] = $e1;
                $esami[] = $e2;
                $esami[] = $e3;

                break;
        }
        return $esami;
    }

    public static function &esamePerDocente(Docente $user) {
        $s = UserFactory::getListaStudenti();
        $d = UserFactory::getListaDocenti();
        $i = InsegnamentoFactory::getListaInsegnamenti();
        $e1 = new Esame();
        $e1->setStudente($s[0]);
        $e1->setVoto(24);
        $e1->setInsegnamento($i[0]);
        $e1->aggiungiMembroCommissione($d[1]);
        $e1->aggiungiMembroCommissione($d[2]);
        $e1->setData(new DateTime());
        $e1->getData()->setDate(2009, 3, 21);

        $e2 = new Esame();
        $e2->setStudente($s[1]);
        $e2->setVoto(27);
        $e2->setInsegnamento($i[1]);
        $e2->aggiungiMembroCommissione($d[0]);
        $e2->aggiungiMembroCommissione($d[2]);
        $e2->setData(new DateTime());
        $e2->getData()->setDate(2009, 5, 24);

        $e3 = new Esame();
        $e3->setStudente($s[2]);
        $e3->setVoto(24);
        $e3->setInsegnamento($i[2]);
        $e3->aggiungiMembroCommissione($d[0]);
        $e3->aggiungiMembroCommissione($d[1]);
        $e3->setData(new DateTime());
        $e3->getData()->setDate(2009, 9, 5);

        $esami[] = $e1;
        $esami[] = $e2;
        $esami[] = $e3;

        return $esami;
    }
    
    public static function &getEsami(){
        return self::esamePerDocente(new Docente());
    }

}

?>
