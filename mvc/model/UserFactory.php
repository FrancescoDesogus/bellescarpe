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
            $query = "SELECT * FROM user WHERE username = ? AND password = ?";
            
            $statement = $mysqli->stmt_init();   
            
            //Preparo la query
            $statement->prepare($query);
            
            //Connetto i parametri che l'utente ha inserito a quelli della query
            $statement->bind_param("ss", $username, $password);
            
            //La eseguo
            $statement->execute();
            
            $statement->store_result();
            
            //Associo i risultati a queste variabili
            $statement->bind_result($result_id, $result_userType, $result_username, $result_password, 
                                    $result_name, $result_surname, $result_email, $result_adress, 
                                    $result_civicNumber, $result_city, $result_cap, $result_company, $result_balance);
            
            
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
                    $userType = $result_userType;
                    $id = $result_id;
                    $name = $result_name;
                    $surname = $result_surname;
                    $email = $result_email;
                    $adress = $result_adress;
                    $civicNumber = $result_civicNumber;
                    $city = $result_city;
                    $cap = $result_cap;
                    $company = $result_company;
                    $balance = $result_balance;
                    
                    //Recuperati tutti i dati, creo l'oggetto user
                    $user = new User($username, $password, $userType, $id, $name, $surname, $email, $adress, $civicNumber, $city, $cap, $balance, $company);
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
     * Cancella l'utente specificato tramite l'id ed il tipo
     * 
     * @param $id l'id dell'utente da eliminare
     * @param $userType il tipo dell'utente da eliminare (admin, customer o retailer)
     * 
     * @return true se l'utente è stato cancellato, false altrimenti
     */
    public static function deleteUser($userId, $userType)
    {
        $mysqli = Database::connect();
        
        if(isset($mysqli))
        { 
            //Recupero tutte le righe che hanno username pari a quello specificato
            //(al più sarà una riga)
            $query = "DELETE FROM user WHERE id = $userId AND userType = $userType";
            
            $result = $mysqli->query($query);
            
            $flag = false;
            
            if(Database::checkForErrors($mysqli))
            {
                //Se il numero di righe restituito è 1, vuol dire che c'è 
                //stata una corrispondenza, quindi inverto il booleano
                if($mysqli->affected_rows == 1)
                {
                    /* Se l'utente da cancellare è un commerciante, potrebbe avere followers e offerte attive,
                     * oltre che libri in vendita. Cancello quindi tutte le righe in cui appare
                     * il suo id nelle rispettive tabelle */
                    $query = "DELETE FROM offer WHERE retailerId = $userId";
                    $mysqli->query($query);
                    
                    $query = "DELETE FROM followers WHERE retailerId = $userId";
                    $mysqli->query($query);
                    
                    $query = "DELETE FROM books_retailers WHERE retailerId = $userId";
                    $mysqli->query($query);
            
                    $flag = true;
                }
            }
            
            $mysqli->close();    
            
            return $flag;
        }
        else 
            return false;
    }
    
    
    /**
     * Restituisce il numero di utenti del tipo specificato registrati al sito
     * 
     * @param int $userType il tipo di utente da considerare nella ricerca
     * 
     * @return il numero di utenti presenti
     */
    public static function getTotalUsersRegistered($userType)
    {
        $mysqli = Database::connect();
        
        if(isset($mysqli))
        {                        
            //La query consiste semplicemente nel contare tutti gli elementi nella tabella
            //che sono del tipo specificato
            $query = "SELECT COUNT(*) FROM user WHERE userType = $userType";
            
            $result = $mysqli->query($query);
            
            if(Database::checkForErrors($mysqli) && $result->num_rows == 1)
            {
                $row = $result->fetch_row();
                
                $mysqli->close();
                
                return $row[0];
            }
            
            $mysqli->close();
            
            return 0;
        }
        
        return 0;
        
    }
    
    
    /**
     * Restituisce un array con i clienti presenti nel sistema nel range specificato
     * 
     * @param $startingIndex indice da cui partire per la ricerca nel database
     * @param $numberOfRows numero di elementi da prendere dal database
     * 
     * @return l'array con i clienti
     */
    public static function &getCustomerList($startingIndex, $numberOfRows) 
    {
        $mysqli = Database::connect();
        
        if(isset($mysqli))
        {            
            /* Recupero tutti gli utenti nella rispettiva tabella che hanno come
             * tipo utente quello che ho definito per i clienti (dato che utilizzo
             * un'unica tabella per tutti i tipi di utente, visto che le differenze
             * tra loro sono minime); li recupero limitando i risultati al range impostato */
            $query = "SELECT * FROM user WHERE userType = ".User::CUSTOMER." LIMIT $startingIndex, $numberOfRows";
            
            $result = $mysqli->query($query);
            
            $customerList = array();
            
            if(Database::checkForErrors($mysqli) && $result->num_rows > 0)
            {
                while($row = $result->fetch_object())
                {                    
                    $userType = $row->userType;
                    $id = $row->id;
                    $username = $row->username;
                    $password = $row->password;
                    $name = $row->name;
                    $surname = $row->surname;
                    $email = $row->email;
                    $adress = $row->adress;
                    $civicNumber = $row->civicNumber;
                    $city = $row->city;
                    $cap = $row->cap;
                    $balance = $row->balance;
                    $company = $row->company;
                    
                    //Creo l'utente con i parametri restituiti dalla query
                    $user = new User($username, $password, $userType, $id, $name, $surname, $email, $adress, $civicNumber, $city, $cap, $balance, $company);

                    //Creato l'utente, lo inserisco nell'array
                    $customerList[] = $user;
                }
            }
            
            $mysqli->close();
            
            return $customerList;
        }
        
        return null;
    }
    
    
    /**
     * Restituisce un array con i commercianti presenti nel sistema (metodo analogo
     * a quello che recupera i clienti)
     * 
     * @param $startingIndex indice da cui partire per la ricerca nel database
     * @param $numberOfRows numero di elementi da prendere dal database
     * 
     * @return l'array con i commercianti
     */
    public static function &getRetailerList($startingIndex, $numberOfRows) 
    {
        $mysqli = Database::connect();
        
        if(isset($mysqli))
        {            
            $query = "SELECT * FROM user WHERE userType = ".User::RETAILER." LIMIT $startingIndex, $numberOfRows";
            
            $result = $mysqli->query($query);
            
            $retailerList = array();
            
            if(Database::checkForErrors($mysqli) && $result->num_rows > 0)
            {
                while($row = $result->fetch_object())
                {                    
                    $userType = $row->userType;
                    $id = $row->id;
                    $username = $row->username;
                    $password = $row->password;
                    $name = $row->name;
                    $surname = $row->surname;
                    $email = $row->email;
                    $adress = $row->adress;
                    $civicNumber = $row->civicNumber;
                    $city = $row->city;
                    $cap = $row->cap;
                    $balance = $row->balance;
                    $company = $row->company;
                    
                    $user = new User($username, $password, $userType, $id, $name, $surname, $email, $adress, $civicNumber, $city, $cap, $balance, $company);
                                        
                    $retailerList[] = $user;
                }
            }
            
            $mysqli->close();
            
            return $retailerList;
        }
        
        return null;
    }
    
    
    /**
     * Ricerca l'utente con un dato username, del tipo passatogli come parametro
     * 
     * @param $pUsername dell'utente da cercare
     * @param $userType il tipo dell'utente da cercare (admin, customer o retailer)
     * 
     * @return l'utente trovato o null
     */
    public static function searchUserByUsername($pUsername, $pUserType) 
    {         
        switch($pUserType)
        {
            case User::ADMIN:
                break;
            
            case User::CUSTOMER:
                $totalCustomers = UserFactory::getTotalUsersRegistered(User::CUSTOMER);
                
                $customerList = self::getCustomerList(0, $totalCustomers);

                foreach($customerList as $customer)
                {                                        
                    if($customer->getUsername() == $pUsername)
                        return $customer;
                }
                
                break;
                
            case User::RETAILER:
                $totalRetailers = UserFactory::getTotalUsersRegistered(User::RETAILER);
                
                $retailerList = self::getRetailerList(0, $totalRetailers);
                
                foreach($retailerList as $retailer)
                {                                        
                    if($retailer->getUsername() == $pUsername)
                        return $retailer;
                }
                
                break;
        }
        
        return null;   
    }
    
    /**
     * Ricerca l'utente con un dato id, del tipo passatogli come parametro
     * 
     * @param $id l'id dell'utente da cercare
     * @param $userType il tipo dell'utente da cercare (admin, customer o retailer)
     * 
     * @return l'utente trovato o null
     */
    public static function searchUserById($pId, $pUserType) 
    {        
        switch($pUserType)
        {
            case User::ADMIN:
                break;
            
            case User::CUSTOMER:
                $totalCustomers = UserFactory::getTotalUsersRegistered(User::CUSTOMER);
                
                $customerList = self::getCustomerList(0, $totalCustomers);
                
                foreach($customerList as $customer)
                {
                    if($customer->getId() == $pId)
                        return $customer;
                }
                
                break;
                
            case User::RETAILER:
                $totalRetailers = UserFactory::getTotalUsersRegistered(User::RETAILER);
                
                $retailerList = self::getRetailerList(0, $totalRetailers);
                
                foreach($retailerList as $retailer)
                {
                    if($retailer->getId() == $pId)
                        return $retailer;
                }
                
                break;
        }
        
        return null;
    }

    
    /**
     * Aggiorna i dati dell'utente passatogli come parametro (i dati da salvare
     * sono già inclusi nella variabile $user), ritornando un booleano che
     * indica il successo o il fallimento dell'operazione
     * 
     * @param $user l'utente di cui bisogna aggiornare i dati
     * 
     * @return true se i dati sono stati aggiornati correttamente, false altrimenti
     */
    public static function changePersonalData($user)
    {
        $mysqli = Database::connect();
        
        if(isset($mysqli))
        {                     
            $userId = $user->getId();
            
            /* Preparo la query per l'update dei campi personali dell'utente con l'id
             * pari a quello specificato. Dato che il form è a rischio di SQL injection,
             * utilizzo un prepared statemenet */
            $query = "UPDATE user SET email = ?, adress = ?, civicNumber = ?, city = ?, cap = ?, company = ?
                      WHERE id = $userId";

            $statement = $mysqli->stmt_init();   
            
            $statement->prepare($query);
                        
            $statement->bind_param("ssisis", $user->getEmail(), $user->getAdress(), 
                                             $user->getCivicNumber(), $user->getCity(),
                                             $user->getCap(), $user->getCompany());
            
      
            $statement->execute();
            
            $statement->store_result();
            
            //Assumo che il processo non sia andato a buon fine
            $hasSucceeded = false;
            
            //Se non ci sono errori ed il numero di righe modificate  
            //dalla query è 1, vuol dire che i dati sono stati inseriti correttamente
            if(Database::checkForErrors($mysqli) && $statement->affected_rows == 1)
                $hasSucceeded = true;
            
            
            $mysqli->close();

            return $hasSucceeded;      
        }
        else 
            return false;
    } 
    
    
    /**
     * Aggiorna la password dell'utente passatogli come parametro (la password da salvare
     * è già inclusa nella variabile $user), ritornando un booleano che
     * indica il successo o il fallimento dell'operazione
     * 
     * @param $user l'utente di cui bisogna aggiornare i dati
     * 
     * @return true se i dati se la password è stata modificata correttamente, false altrimenti
     */
    public static function changePassword($user)
    {
        $mysqli = Database::connect();
        
        if(isset($mysqli))
        {                     
            $userId = $user->getId();
            
            /* Come in changePersonalData, utilizzo un prepared statement per
             * proteggere il database */
            $query = "UPDATE user SET password = ? WHERE id = $userId";

            $statement = $mysqli->stmt_init();   
            
            $statement->prepare($query);
                        
            $statement->bind_param("s", $user->getPassword());
            
      
            $statement->execute();
            
            $statement->store_result();
            
            
            $hasSucceeded = false;
            
            if(Database::checkForErrors($mysqli) && $statement->affected_rows == 1)
                $hasSucceeded = true;
            
            
            $mysqli->close();

            return $hasSucceeded;      
        }
        else 
            return false;
    }
    
    
    /**
     * Restituisce lo username dell'utente con l'id specificato
     * 
     * @param int $userId l'id dell'utente in questione
     * 
     * @return lo username richiesto (null in caso di errore)
     */
    public static function getUsernameFromId($userId)
    {
        $mysqli = Database::connect();
        
        if(isset($mysqli))
        {                        
            $query = "SELECT username FROM user WHERE id = $userId";
            
            $result = $mysqli->query($query);
            
            if(Database::checkForErrors($mysqli) && $result->num_rows == 1)
            {
                $row = $result->fetch_row();
                
                $mysqli->close();
                
                return $row[0];
            }
            
            $mysqli->close();
            
            return null;
        }
        
        return null;
        
    }
    
    
    /**
     * Modifica il bilancio dell'utente specificato del tipo specificato
     * 
     * @param $userId l'id dell'utente
     * @param $userType il tipo dell'utente
     * @param $balance il nuovo bilancio
     * 
     * @return true se il bilancio è stato modificato, false altrimenti
     */
    public static function setUserBalance($userId, $userType, $balance)
    {
        $mysqli = Database::connect();
        
        if(isset($mysqli))
        {             
            $query = "UPDATE user SET balance = $balance WHERE id = $userId AND userType = $userType";
            
            $result = $mysqli->query($query);
            
            $hasChangedBalance = false;
                        
            if(Database::checkForErrors($mysqli) && $mysqli->affected_rows == 1)
                $hasChangedBalance = true;            
            
            $mysqli->close();    
            
            return $hasChangedBalance;
        }
        else 
            return false;
    }
    
    
    /**
     * Recupera il bilancio dell'utente specificato
     * 
     * @param $userId l'id dell'utente
     * 
     * @return il bilancio dell'utente
     */
    public static function getUserBalance($userId)
    {
        $mysqli = Database::connect();
        
        if(isset($mysqli))
        {             
            $query = "SELECT balance FROM user WHERE id = $userId";
            
            $result = $mysqli->query($query);
            
            $hasChangedBalance = false;
                        
            if(Database::checkForErrors($mysqli) && $result->num_rows == 1)
            {
                $row = $result->fetch_row();
                
                $mysqli->close(); 
                
                return $row[0];
            }          
            
            $mysqli->close();    
            
            return 0;
        }
        else 
            return 0;
    }
    
    
    /**
     * Controlla se lo username passato come parametro è già in uso
     * da un altro utente, restituendo true o false di conseguenza
     * 
     * @param $pUsername lo username da controllare
     * 
     * @return boolean true se lo username è occupato, false se è libero
     */
    public static function isUsernameOccupied($pUsername) 
    {        
        $mysqli = Database::connect();
        
        if(isset($mysqli))
        {            
            //Recupero tutte le righe che hanno username pari a quello specificato
            //(al più sarà una riga)
            $query = "SELECT * FROM user WHERE username = '$pUsername'";
            
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
     * Controlla se esiste un utente del tipo specificato con l'id specificato 
     * 
     * @return true se esiste, false altrimenti (null in caso di errori)
     */
    public static function isUserExistent($userId, $userType)
    {
        $mysqli = Database::connect();  
        
        if(isset($mysqli))
        {                   
            $query = "SELECT COUNT(*) FROM user WHERE id = $userId AND userType = $userType";
            
            $result = $mysqli->query($query);

            if(Database::checkForErrors($mysqli) && $result->num_rows == 1)
            {                
                $row = $result->fetch_row();

                $mysqli->close();
                
                //Se il numero di righe contate è 0, non esiste; altrimenti si
                if($row[0] == 0)
                    return false;
                else
                    return true;
            }
            
            $mysqli->close();
            
            return null;
        }
        else
            return null;
    }
}

?>
