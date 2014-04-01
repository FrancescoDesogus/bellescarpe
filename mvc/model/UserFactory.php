<?php

include_once 'User.php';

/**
 * Classe per la creazione ed il recupero degli utenti del sistema
 */
class UserFactory 
{
    //Costruttore
    private function __construct() 
    {
        
    }

    /**
     * Carica un utente (se esiste) tramite username e password
     * 
     * @param String $username
     * @param String $password
     * 
     * @return l'utente, o altrimenti null
     */
    public static function loadUser($username, $password) 
    {
        //Effettuo la connessione al database
        $mysqli = Database::connect();
        
        //Se la variabile è settata non ci sono stati errori
        if(isset($mysqli))
        {
            /* Dato che il login è a rischio di SQL injection, creo un prepared
             * statement per la query per evitare possibili attacchi */
            $query = "SELECT * FROM Utente WHERE username = ? AND password = ?";
            
            $statement = $mysqli->stmt_init();   
            
            //Preparo la query
            $statement->prepare($query);
            
            //Connetto i parametri che l'utente ha inserito a quelli della query
            $statement->bind_param("ss", $username, $password);
            
            //La eseguo
            $statement->execute();
            
            $statement->store_result();
            
            //Associo i risultati a queste variabili
            $statement->bind_result($result_id, $result_username, $result_password, 
                                    $result_email, $result_facebookId);
            
            
            //Stabilisco inizialmente che l'utente non è stato trovato
            //impostando a null la variabile user
            $user = null;
            
            //Se non ci sono stati errori, procedo
            if(Database::checkForErrors($mysqli))
            {
                //Faccio il fetch del risultato
                $statement->fetch();

                //Se il numero di righe risultati è 1 è stata trovato l'utente
                //nel database, quindi recupero i parametri
                if($statement->num_rows() == 1)
                {
                    $id = $result_id;
                    $email = $result_email;
                    $facebookId = $result_facebookId;
                    
                    //Recuperati tutti i dati, creo l'oggetto user
                    $user = new User($username, $password, $id, User::USER, $email, $facebookId);
                }
            }
            
            $mysqli->close();
            
            return $user;
        }
        
        return null;
    }
    
    
    /**
     * Carica un utente (se esiste) tramite il suo id di facebook
     * 
     * @param String $facebookId l'id facebook dell'utente
     * 
     * @return l'utente, o altrimenti null se l'utente con l'id facebook specificato non è stato trovato nel db (quindi non si è registrato ancora tramite facebook)
     */
    public static function loadFacebookUser($facebookId) 
    {
        //Effettuo la connessione al database
        $mysqli = Database::connect();
        
        if(isset($mysqli))
        { 
            //Recupero tutte le righe che hanno username pari a quello specificato
            //(al più sarà una riga)
            $query = "SELECT * FROM Utente WHERE facebook_id = $facebookId";
            
            $result = $mysqli->query($query);
            
            $user = null;
            
            if(Database::checkForErrors($mysqli) && $result->num_rows == 1)
            {
                $row = $result->fetch_object();
                
                $id = $row->id;
                $username = $row->username;
                $password = $row->password;
                $email = $row->email;

                $user = new User($username, $password, $id, User::USER, $email, $facebookId);
            }
            
            $mysqli->close();    
            
            return $user;
        }
        
        return null;
    }
    
    

    
    /**
     * Aggiunge un utente al database con i parametri passati e ritorna
     * l'utente appena creato in caso di successo (null altrimenti).
     * 
     * @param String $username
     * @param String $password
     * @param String $email
     * @param String $facebookId l'id facebook dell'utente (è null se l'uente non si sta registrando tramite facebook)
     * 
     * @return l'utente appena creato, null altrimenti
     */
    public static function addUser($username, $password, $email, $facebookId) 
    {        
        $mysqli = Database::connect();
        
        if(isset($mysqli))
        {           
//            /* Dato che nella compilazione del form il database è vulnerabile, utilizzo un 
//             * prepared statemenet per inserire i parametri inseriti dall'utente nel database */
//            $query = "INSERT INTO Utente (id, username, password, email, facebook_id)
//                      VALUES (default, ?, ?, ?, ?)";
//
//            $statement = $mysqli->stmt_init();   
//            
//            $statement->prepare($query);
//            
////            $facebookId = strval($facebookId);
//                        
//            $statement->bind_param("isssi", $username, $password, $email, $facebookId);
//            
//      
//            $statement->execute();
//            
//            $statement->store_result();
//            
//            if(Database::checkForErrors($mysqli))
//            { 
//                $id = $statement->insert_id;
//                
//                echo "new user id: ".$id;
//                
//                
//                $user = new User($username, $password, $id, User::USER, $email, $facebookId);
//                                
//                $mysqli->close();
//                
//                //E lo ritorno
//                return $user;
//            }
            
            
            $query = "INSERT INTO Utente (id, username, password, email, facebook_id)
                      VALUES (default, '$username', '$password', '$email', '$facebookId');";

            echo $query;
            
            $result = $mysqli->query($query);
            
            
            $user = null;

            if(Database::checkForErrors($mysqli) && $mysqli->affected_rows == 1)
                $user = new User($username, $password, $id, User::USER, $email, $facebookId);
           
            
            $mysqli->close();
            
            return $user;
        }
        
        return null;
    }
    
    
    /**
     * Controlla se lo username passato come parametro è già in uso
     * da un altro utente, restituendo true o false di conseguenza
     * 
     * @param $pUsername lo username da controllare
     * 
     * @return boolean true se lo username è occupato, false se è libero
     */
    public static function isUsernameOccupied($username) 
    {        
        $mysqli = Database::connect();
        
        if(isset($mysqli))
        {            
            //Recupero tutte le righe che hanno username pari a quello specificato
            //(al più sarà una riga)
            $query = "SELECT * FROM Utente WHERE username = '$username'";
            
            $result = $mysqli->query($query);
            
            //Stabilisco inizialmente che non è stata trovata una corrispondenza
            $flag = false;
   
            if(Database::checkForErrors($mysqli))
            {
                //Se il numero di righe restituito è 1, vuol dire che c'è 
                //stata una corrispondenza, quindi inverto il booleano
                if($result->num_rows == 1)
                    $flag = true;
            }
            
            $mysqli->close();
            
            return $flag;
        }
        
        return false;
    }
    
    
    
    /**
     * Controlla se lo username passato come parametro è già in uso
     * da un altro utente, restituendo true o false di conseguenza
     * 
     * @param $pUsername lo username da controllare
     * 
     * @return boolean true se lo username è occupato, false se è libero
     */
    public static function isEmailAlreadyUsed($email) 
    {        
        $mysqli = Database::connect();
        
        if(isset($mysqli))
        {            
            //Recupero tutte le righe che hanno username pari a quello specificato
            //(al più sarà una riga)
            $query = "SELECT * FROM Utente WHERE email = '$email'";
            
            $result = $mysqli->query($query);
            
            //Stabilisco inizialmente che non è stata trovata una corrispondenza
            $flag = false;
   
            if(Database::checkForErrors($mysqli))
            {
                //Se il numero di righe restituito è 1, vuol dire che c'è 
                //stata una corrispondenza, quindi inverto il booleano
                if($result->num_rows == 1)
                    $flag = true;
            }
            
            $mysqli->close();
            
            return $flag;
        }
        
        return false;
    }
}

?>
