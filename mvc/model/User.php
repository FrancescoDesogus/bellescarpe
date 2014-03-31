<?php

/**
 * Classe che rappresenta un generico utente del sistema
 */
class User 
{
    //Costanti per distinguere il tipo di user
    const ADMIN = 1;
    const USER = 2;
    
    /**
     * L'id dell'utente nel db
     * 
     * @var int 
     */
    private $id;
    
    /**
     * Il nome utente dello user
     * 
     * @var String 
     */
    private $username;  
    
    /**
     * La password dello user
     * 
     * @var String 
     */
    private $password;  
    
    /**
     * L'email dello user
     * 
     * @var String 
     */
    private $email; 
    
    
    /**
     * L'id facebook dell'utente (è null se l'utente non si è registrato tramite facebook)
     * 
     * @var String 
     */
    private $facebookId; 
    
    
    /**
     * Il tipo di user 
     * 
     * @var int 
     */
    private $userType; 
    
    /**
     * Booleano per definire se l'utente corrente è impersonato da un admin
     * 
     * @var boolean 
     */
    private $isImpersonated; 
  
    
    /**
     * Il nome dello user  
     * @var String 
     */
    private $name; 
   
    /**
     * Il cognome delo 'user
     * @var String 
     */
    private $surname; 
     
    
    /**
     * Costruttore
     */
    public function __construct($pUserName, $pPassword, $pId, $pUserType, $pEmail, $pFacebookId) 
    {        
        $this->setUsername($pUserName);
        $this->setPassword($pPassword);
        $this->setId($pId);
        $this->setUserType($pUserType);
//        $this->setName($pName);
//        $this->setSurname($pSurname);
        $this->setEmail($pEmail);
        $this->setFacebookId($pFacebookId);

        
        //Se non indicato esplicitamente, do' per scontato che l'utente non sia impersonato da un admin
        $this->setIsImpersonated(false);
    }


    // =====================================================
    // Getter
    // =====================================================
    
    /**
     * Restituisce lo username dell'utente
     * 
     * @return String
     */
    public function getUsername() 
    {
        return $this->username;
    }

    /**
     * Restituisce la password dell'utente
     * 
     * @return String
     */
    public function getPassword() 
    {
        return $this->password;
    }
    
    /**
     * Restituisce il nome dell'utente
     * 
     * @return String
     */
    public function getName() 
    {
        return $this->name;
    }
    
    /**
     * Restituisce il cognome dell'utente
     * 
     * @return String
     */
    public function getSurname()
    {
        return $this->surname;
    }
    
    
    /**
     * Restituisce l'email dell'utente
     * 
     * @return String
     */
    public function getEmail() 
    {
        return $this->email;
    }
    
    
    /**
     * Restituisce l'id facebook dell'utente (è null se l'utente non si è registrato tramite facebook)
     * 
     * @return String
     */
    public function getFacebookId() 
    {
        return $this->facebookId;
    }
    
    
    /**
     * Restituisce l'identificatore unico per l'utente
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Restituisce il tipo di utente
     * 
     * @return int
     */
    public function getUserType() 
    {
        return $this->userType;
    }
    
    /**
     * Restituisce il booleano che indica se l'utente corrente è impersonato da un admin
     * 
     * @return boolean
     */
    public function isImpersonated()
    {
        return $this->isImpersonated;
    }
    
    
    // =====================================================
    // Setter
    // =====================================================

    /**
     * Imposta lo username dell'utente
     * 
     * @param String $pUsername
     * 
     * @return boolean true se lo username e' ammissibile ed e' stato impostato,
     * false altrimenti
     */
    public function setUsername($pUsername) 
    {      
        $this->username = $pUsername;
        
        return true;
    }

    /**
     * Imposta la password per l'utente corrente
     * 
     * @param String $password
     * 
     * @return boolean true se la password e' stata impostata correttamente,
     * false altrimenti
     */
    public function setPassword($pPassword) 
    {
        $this->password = $pPassword;
        
        return true;
    }

    /**
     * Imposta il nome dell'utente
     * 
     * @param String $nome
     * 
     * @return boolean true se il nome e' stato impostato correttamente, 
     * false altrimenti 
     */
    public function setName($pName) 
    {
        $this->name = $pName;
        
        return true;
    }

    /**
     * Imposta il cognome dell'utente
     * 
     * @param String $pSurname
     * 
     * @return boolean true se il cognome e' stato impostato correttamente,
     * false altrimenti
     */
    public function setSurname($pSurname) 
    {
        $this->surname = $pSurname;
        
        return true;
    }
    
    /**
     * Imposta il tipo di utente
     * 
     * @param String $pUserType
     * 
     * @return boolean true se il valore e' ammissibile ed e' stato impostato,
     * false altrimenti
     */
    public function setUserType($pUserType) 
    {
        $this->userType = $pUserType;
        
        switch($pUserType) 
        {
            case User::ADMIN:
//            case User::CUSTOMER:
            case User::USER:
                $this->userType = $pUserType;
                return true;
            default:
                return false;
        }
    }
    
    /**
     * Imposta l'email dell'utente
     * 
     * @param String $pEmail 
     * 
     * @return boolean true se l'email è ammissibile, false altrimenti
     */
    public function setEmail($pEmail) 
    {
        if(!filter_var($pEmail, FILTER_VALIDATE_EMAIL)) 
            return false;
        
        $this->email = $pEmail;
        
        return true;
    }

    /**
     * Imposta l'id facebook dell'utente
     * 
     * @param String $pFacebookId 
     * 
     * @return boolean true se l'id è stato messo, false altrimenti
     */
    public function setFacebookId($pFacebookId) 
    {
        $this->facebookId = $pFacebookId;
        
        return true;
    }
    
    
    /**
     * Imposta l'id dell'utente
     * 
     * @param int $pId
     * 
     * @return boolean true se il valore e' stato impostato correttamente,
     * false altrimenti
     */
    public function setId($pId)
    {
        $isInt = filter_var($pId, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        
        if(!isset($isInt))
            return false;
        
        $this->id = $pId;
        
        return true;
    }
    
    /**
     * Imposta il booleano che indica se l'utente è impersonato da un admin
     * 
     * @param boolean $pIsImpersonated
     * 
     * @return boolean true se il valore e' stato aggiornato correttamente,
     * false altrimenti
     */
    public function setIsImpersonated($pIsImpersonated)
    {
        $this->isImpersonated = $pIsImpersonated;
        
        return true;
    }
    
    
    // =====================================================
    // Methods
    // =====================================================
    
    /**
     * Compara due utenti, verificandone l'uguaglianza logica
     * 
     * @param User $pUser l'utente con cui comparare $this
     * 
     * @return boolean true se i due oggetti sono logicamente uguali, 
     * false altrimenti
     */
    public function equals(User $pUser) 
    {
        return  $this->id == $pUser->id;
    }
}

?>
