<?php

/**
 * Classe per recuperare informazioni sulle scarpe immagazzinate nel database
 */
class Arduino 
{   
    public static $COM_PORT = "com6";
    public static $BAUD = "9600";
    public static $PARITY = "n";
    public static $DATA = "8";
    public static $STOP = "1";
    
    
    /**
     * Dato l'id di una scarpa, restituisce tutte le informazioni
     * 
     * @param $shoeId l'id della scarpa considerata
     * 
     * @return un oggetto Shoe contenente tutte le informazioni sulla scarpa trovate nel db; ritorna null se non viene trovato niente
     */
    public static function light($lightCoordinate) 
    {        
        for($i = 0; $i < func_num_args(); $i++) 
        {
            $currentCoordinate = func_get_arg($i);
            
            Arduino::lightAtCoordinate($currentCoordinate);
        }
        
    }   

   
    private static function lightAtCoordinate($command) 
    {
	$openSerialOK = false;
        
	try 
        {
//            exec("mode com6: BAUD=9600 PARITY=n DATA=8 STOP=1 to=off dtr=off rts=off");
            exec("mode ".Arduino::$COM_PORT.": BAUD=".Arduino::$BAUD." PARITY=".Arduino::$PARITY." DATA=".Arduino::$DATA." STOP=".Arduino::$STOP." to=off dtr=off rts=off");

            
            $fh =fopen("com6", "w");
            
            //$fp = fopen('/dev/ttyUSB0','r+'); //use this for Linux
            
            $openSerialOK = true;
	} 
        catch(Exception $e) 
        {
            echo 'Message: ' .$e->getMessage();
	}

	if($openSerialOK) 
        {
            fwrite($fh, $command); //write string to serial
            fclose($fh);
        }	
    }  
}

?>
