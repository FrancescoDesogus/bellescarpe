<?php

/**
 * Classe che contiene variabili e metodi ricorrenti durante l'uso del database
 */
class Database 
{   
    public static $DB_HOST = 'localhost';
    public static $DB_USER = 'bellescarpecod';
    public static $DB_PASSWORD = 'albero';
    public static $DB_NAME = 'my_bellescarpecod';
    
    
    /**
     * Istanzia un oggetto mysqli che si connette al database e gestisce
     * l'eventuale errore di connessione; restituisce null in caso di errori
     * o altrimenti il riferimento all'oggetto mysqli
     * 
     * @return riferimento all'oggetto mysqli; restituisce null in caso di errori
     */
    public static function &connect() 
    {
        $mysqli = new mysqli();
        
        if($_SERVER['HTTP_HOST'] != 'localhost')
            $mysqli->connect(self::$DB_HOST, self::$DB_USER, self::$DB_PASSWORD, self::$DB_NAME);
        else
            $mysqli->connect(self::$DB_HOST, "root", "", self::$DB_NAME);
    
        if($mysqli->connect_errno != 0)
        {
            $message = $mysqli->connect_error;
            
            echo "Errore durante la connessione al database: $message";
            
            return null;
        }
        
        return $mysqli;
    }
    
    
    /**
     * Controlla se è presente un errore nella query
     * 
     * @param $mysqli l'oggetto mysqli che contiene il potenziale errore
     * 
     * @return true se non ci sono errori, false altrimenti
     */
    public static function checkForErrors(mysqli $mysqli) 
    {                
        if($mysqli->errno > 0)
        {
            $message = $mysqli->error;
            
            echo "Errore nell'esecuzione della query. $mysqli->errno : $message";

            return false;
        }
        
        return true;
    }
}
?>
