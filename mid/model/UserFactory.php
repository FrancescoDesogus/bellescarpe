<?php

include_once 'User.php';
include_once 'Docente.php';
include_once 'Studente.php';
include_once 'CorsoDiLaureaFactory.php';
include_once 'DipartimentoFactory.php';



/**
 * Classe per la creazione degli utenti del sistema
 *
 * @author Davide Spano
 */
class UserFactory {

  
    /**
     * Costruttore
     */
    private function __construct() {
        
    }

    /**
     * Carica un utente tramite username e password
     * @param string $username
     * @param string $password
     * @return \User|\Docente|\Studente
     */
    public static function loadUser($username, $password) {
        // simuliamo il caricamento da db
        if ($username == 'admin' && $password = 'spano') {
            $toRet = new User();
            $toRet->setUsername($username);
            $toRet->setPassword($password);
            $toRet->setRuolo(User::Amministratore);
            $toRet->setNome('Davide');
            $toRet->setCognome('Spano');
            $toRet->setId(9);
            $toRet->setEmail('davide.spano@unica.it');
            return $toRet;
        } else if ($username == 'docente' && $password == 'spano') {
            $toRet = new Docente();
            $toRet->setUsername($username);
            $dip = DipartimentoFactory::getDipartimenti();
            $toRet->setDipartimento($dip[0]);
            $toRet->setPassword($password);
            $toRet->setRuolo(User::Docente);
            $toRet->setNome('Davide');
            $toRet->setId(7);
            $toRet->setCognome('Spano');
            $toRet->setEmail('davide.spano@unica.it');
            return $toRet;
        } else if ($username == 'studente' && $password == 'spano') {

            $toRet = new Studente();
            $dip = DipartimentoFactory::getDipartimenti();
            $cdl = CorsoDiLaureaFactory::getCorsiDiLaureaPerDipartimento($dip[0]);
            $toRet->setCorsoDiLaurea($cdl[0]);
            $toRet->setUsername($username);
            $toRet->setPassword($password);
            $toRet->setRuolo(User::Studente);
            $toRet->setMatricola(253662);
            $toRet->setId(0);
            $toRet->setNome('Davide');
            $toRet->setCognome('Spano');
            $toRet->setEmail('davide.spano@unica.it');
            return $toRet;
        }
    }

    /**
     * Restituisce un array con i Docenti presenti nel sistema
     * @return array
     */
    public static function &getListaDocenti() {
        // simuliamo il caricamento dal db
        $dips = DipartimentoFactory::getDipartimenti();

        
        $d1 = new Docente();
        $d1->setNome('Riccardo');
        $d1->setCognome('Scateni');
        $d1->setDipartimento($dips[0]);
        $d1->setId(3);

        $d2 = new Docente();
        $d2->setNome('Gianni');
        $d2->setCognome('Fenu');
        $d2->setDipartimento($dips[0]);
        $d2->setId(4);

        $d3 = new Docente();
        $d3->setNome('Davide');
        $d3->setCognome('Spano');
        $d3->setDipartimento($dips[0]);
        $d3->setId(5);

        $docenti = array();
        $docenti[] = $d1;
        $docenti[] = $d2;
        $docenti[] = $d3;

        return $docenti;
    }

    /**
     * Restituisce la lista degli studenti presenti nel sistema
     * @return array
     */
    public static function &getListaStudenti() {
        $studenti = array();
        $dip = DipartimentoFactory::getDipartimenti();
        $cdl = CorsoDiLaureaFactory::getCorsiDiLaureaPerDipartimento($dip[0]);
        $s1 = new Studente();
        $s1->setCorsoDiLaurea($cdl[0]);
        $s1->setRuolo(User::Studente);
        $s1->setMatricola(253662);
        $s1->setId(0);
        $s1->setNome('Davide');
        $s1->setCognome('Spano');
        $s1->setEmail('davide.spano@unica.it');

        $s2 = new Studente();
        $s2->setCorsoDiLaurea($cdl[0]);
        $s2->setRuolo(User::Studente);
        $s2->setMatricola(123456);
        $s2->setId(1);
        $s2->setNome('Pinco');
        $s2->setCognome('Pallino');
        $s2->setEmail('pinco.pallino@unica.it');


        $s3 = new Studente();
        $s3->setCorsoDiLaurea($cdl[0]);
        $s3->setRuolo(User::Studente);
        $s3->setMatricola(654321);
        $s3->setId(2);
        $s3->setNome('Marta');
        $s3->setCognome('Rossi');
        $s3->setEmail('marta.rossi@unica.it');

        $studenti[] = $s1;
        $studenti[] = $s2;
        $studenti[] = $s3;
        return $studenti;
    }

    
    /**
     * Carica uno studente dalla matricola
     * @param int $matricola la matricola da cercare
     * @return Studente un oggetto Studente nel caso sia stato trovato,
     * NULL altrimenti
     */
    public static function cercaStudentePerMatricola($matricola) {


        $intval = filter_var($matricola, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intval)) {
            return null;
        }
        $studenti = self::getListaStudenti();
        foreach ($studenti as $studente) {
            if ($studente->getMatricola() == $intval) {
                return $studente;
            }
        }
        return null;
    }
    
    /**
     * Cerca uno studente per id
     * @param int $id
     * @return Studente un oggetto Studente nel caso sia stato trovato,
     * NULL altrimenti
     */
    public static function cercaUtentePerId($id){
         $intval = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intval)) {
            return null;
        }
        $users = self::getListaStudenti();
        foreach ($users as $user) {
            if ($user->getId() == $intval) {
                return $user;
            }
        }
        $users2 = self::getListaDocenti();
        foreach ($users2 as $user) {
            if ($user->getId() == $intval) {
                return $user;
            }
        }
        return null;
    }
    

}

?>
