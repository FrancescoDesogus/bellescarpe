<?php

/**
 * Classe che contiene una lista di variabili di configurazione
 */
class Settings {

    private static $appPath;

    /**
     * Restituisce il path relativo nel server corrente dell'applicazione
     */
    public static function getApplicationPath() 
    {
        if (!isset(self::$appPath)) 
        {
            //Restituisce il server corrente
            switch ($_SERVER['HTTP_HOST']) 
            {
                case 'localhost':
                    // configurazione locale
                    self::$appPath = 'http://' . $_SERVER['HTTP_HOST'] . '/BelleScarpe/mvc/';
//                    self::$appPath = 'http://spano.sc.unica.it/desogusFrancesco/progetto/mvc/';
                    break;
                case 'bellescarpecod.altervista.org':                    
                    // configurazione pubblica
                    self::$appPath = 'http://' . $_SERVER['HTTP_HOST'] . '/mvc/';
                    break;

                default:
                    self::$appPath = '';
                    break;
            }
        }
        
        return self::$appPath;
    }

}

?>
