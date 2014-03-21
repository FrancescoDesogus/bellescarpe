<?php

/*
 * Classe utilizzata dalla master page per creare le varie parti della pagina.
 */
class ViewDescriptor 
{
    const get = 'get'; //GET http
    
    const post = 'post'; //Post http
    
    /**
     * Il titolo della pagina
     * 
     * @var String 
     */
    private $title; 

    /**
     * Iil path per il file contenente il codice html delle tabs
     * 
     * @var String 
     */
    private $tabs_file; 
    
    /**
     * Il path per il file contenente il codice html della sidebar sinistra
     * 
     * @var String 
     */
    private $leftSidebar_file; 

    /**
     * Il path per il file contenente il codice html della sidebar destra
     * 
     * @var String 
     */
    private $rightSidebar_file; 
 
    /**
     * Il path per il file contenente il codice html del content
     * 
     * @var String 
     */
    private $content_file; 

    /**
     * Il path per il file contenente il codice html per il logout
     * 
     * @var String 
     */
    private $logout_file; 
    
    
    /**
     * Messaggio di errore da mostrare dopo ad esempio un input scorretto
     * 
     * @var String 
     */
    private $errorMessagge; 

    /**
     * Messaggio di errore da conferma dopo ad esempio un input corretto
     * 
     * @var String 
     */
    private $confirmationMessage; 
    
    /**
     * La pagina corrente
     * 
     * @var String 
     */
    private $page; 
    
    /**
     * Sottopagina della vista corrente
     * 
     * @var String 
     */
    private $subPage; 
    
    /**
     * Token usato dall'admin per impersonare un cliente
     * 
     * @var String 
     */
    private $impersonificationToken; 

    
    //Costruttore
    public function __construct() 
    {
        
    }
    
    // =====================================================
    // Getter
    // =====================================================

    /**
     * Restituisce il titolo della pagina
     * @return String
     */
    public function getTitle() 
    {
        return $this->title;
    }
    
    /**
     * Restituisce il path al file che include la definizione HTML del link per il logout
     * @return String
     */
    public function getLogoutFIle() 
    {
        return $this->logout_file;
    }

    /**
     * Restituisce il path al file che include la definizione HTML dei tab (parte dello header)
     * @return String
     */
    public function getTabsFile() 
    {
        return $this->tabs_file;
    }
    
    /**
     * Restituisce il path al file che include la definizione HTML della sidebar sinistra
     * @return String
     */
    public function getLeftSidebarFile() 
    {
        return $this->leftSidebar_file;
    }
    
    /**
     * Imposta il file che include la definizione HTML della sidebar destra
     * @return String
     */
    public function getRightSidebarFile() 
    {
        return $this->rightSidebar_file;
    }
    
    /**
     * Restituisce il path al file che contiene il content 
     * @return String
     */
    public function getContentFile() 
    {
        return $this->content_file;
    }
    
    /**
     * Restituisce il testo del messaggio di errore (null se non c'è un errore)
     * @return String
     */
    public function getErrorMessage() 
    { 
        return $this->errorMessagge;
    }
    
    /**
     * Restituisce il contenuto del messaggio di conferma
     * @return String
     */
    public function getConfirmationMessage() 
    {
        return $this->confirmationMessage;
    }
    
    /**
     * Restituisce il nome della pagina corrente
     * @return String
     */
    public function getPage() 
    {
        return $this->page;
    }
    
    /**
     * Restituisce il nome della sotto-pagina corrente
     * @return String
     */
    public function getSubPage() 
    {
        return $this->subPage;
    }
    
    
    /**
     * Restituisce il valore corrente del token, se esiste. Altrimenti
     * viene ritornata una stringa vuota
     * @return String
     */
    public function getImpToken() 
    {
        if(isset($this->impersonationToken))
            return $this->impersonationToken;
        else
            return "";
    }
    
    
    // =====================================================
    // Setter
    // =====================================================
    
    
    /**
     * Imposta il titolo della pagina
     * @param String
     */
    public function setTitle($pTitle) 
    {
        $this->title = $pTitle;
    }   

    /**
     * Imposta il path al file che include la definizione HTML del link per il logout
     * @return String
     */
    public function setLogoutFIle($pLogoutFile) 
    {
        $this->logout_file = $pLogoutFile;
    }
    
    /**
     * Imposta il path al file che include la definizione HTML delle tab (parte dello header)
     * @param String 
     */
    public function setTabsFile($pTabsFile) 
    {
        $this->tabs_file = $pTabsFile;
    }


    /**
     * Imposta il path al file che include la definizione HTML della sidebar sinistra
     * @param String 
     */
    public function setLeftSidebarFile($pLeftSidebar) 
    {
        $this->leftSidebar_file = $pLeftSidebar;
    }

    /**
     * Imposta il path al file che include la definizione HTML della sidebar destra
     * @param String
     */
    public function setRightSidebarFile($pRightBar) 
    {
        $this->rightSidebar_file = $pRightBar;
    }

     /**
     * Imposta il file che include la definizione HTML del contenuto principale
     * @param String
     */
    public function setContentFile($pContentFile) {
        $this->content_file = $pContentFile;
    }

     /**
     * Imposta un messaggio di errore
     * @return String
     */
    public function setErrorMessage($pErrorMessage) {
        $this->errorMessagge = $pErrorMessage;
    }
    
    /**
     * Imposta il contenuto del messaggio di conferma
     * @param string $msg
     */
    public function setConfirmationMessage($pConfirmationMessage) 
    {
        $this->confirmationMessage = $pConfirmationMessage;
    }
    
    /**
     * Imposta il nome della pagina corrente
     * @param String
     */
    public function setPage($pPage) 
    {
        $this->page = $pPage;
    }
    
    /**
     * Imposta il nome della sotto-pagina corrente
     * @param String
     */
    public function setSubPage($pSubPage) 
    {
        $this->subPage = $pSubPage;
    }

    /**
     * Restituisce il valore corrente del token per fare in modo che
     * un amministratore possa impersonare un cliente
     * 
     * @param String
     */
    public function setImpToken($pImpersonationToken) 
    {
        $this->impersonationToken = $pImpersonationToken;
    }

    
    
    // =====================================================
    // Methods
    // =====================================================
    
    /**
     * Scrive un token per gestire quale sia l'utente che l'amministratore
     * sta impersonando per svolgere delle operazioni in sua vece. 
     * 
     * Questo metodo concentra in un solo punto il mantenimento di questa
     * informazione, che deve essere appesa per ogni get e per ogni post
     * degli utenti impersonati.
     * 
     * @param $pre il prefisso per attaccare il parametro del token nella 
     *             query string.
     * @param $method metodo HTTP usato (get o post)
     * 
     * @return String il valore da scrivere nella URL in caso di get o come
     *                hidden input in caso di form
     */
    public function putToken($pre = '', $method = self::get) 
    {
        $imp = BaseController::impersonation;
        
        switch($method) 
        {
            case self::get:
                if (isset($this->impersonationToken)) 
                    return $pre . "$imp=$this->impersonationToken";

                break;

            case self::post:
                if (isset($this->impersonationToken)) 
                    return "<input type=\"hidden\" name=\"$imp\" value=\"$this->impersonationToken\"/>";
                
                break;
        }

        return '';
    }

}

?>
