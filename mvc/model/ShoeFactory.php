<?php

include_once 'Shoe.php';
include_once 'Database.php';

/**
 * Classe per recuperare informazioni sulle scarpe immagazzinate nel database
 */
class ShoeFactory 
{   
    /**
     * Dato l'id di una scarpa, restituisce tutte le informazioni
     * 
     * @param $shoeId l'id della scarpa considerata
     * 
     * @return un oggetto Shoe contenente tutte le informazioni sulla scarpa trovate nel db; ritorna null se non viene trovato niente
     */
    public static function getShoeFromId($shoeId) 
    {        
        $mysqli = Database::connect();
        
        if(isset($mysqli))
        {            
            $query = "SELECT * FROM Scarpa WHERE id_scarpa = $shoeId";
                        
            $result = $mysqli->query($query);

            if(Database::checkForErrors($mysqli) && $result->num_rows == 1)
            {
                $row = $result->fetch_object();
                
                $mysqli->close();
                
                return ShoeFactory::getShoeFromRowWithSizes($row, $shoeId);
            }
            else
            {
                $mysqli->close();
            
                return null;
            }             
        }
        else
            return null;
    }   

    /**
     * Metodo di convenienza che estrapola i dati da una riga del database ottenuta con una query per una scarpa. Esegue a sua volta query
     * per recuperare informazioni relative alla scarpa da altre tabelle, come le categorie e le taglie disponibili
     * per creare il libro che ne risulta
     * 
     * @param $row la riga del database restituita da una query
     * @param $shoeId l'id della scarpa; serve per fare altre query per recuperare categorie e taglie della scarpa
     * 
     * @return un oggetto Shoe con le informazioni recuperate dalle query
     */
    private static function getShoeFromRowWithSizes($row, $shoeId) 
    {
        $id = $row->id_scarpa;
        $brand = $row->marca;
        $model = $row->modello;
        $color = $row->colore;
        $sex=  $row->sesso;
        $category =  $row->categoria;
        $price = $row->prezzo;
        $mediaPath = $row->media;
        
        //Recupero tutte le taglie disponibili con relativa quantità disponibile
        $sizesAndQuantities = ShoeFactory::getSizesAndQuantitiesFromId($shoeId);
        

        //Creo quindi l'oggetto Shoe con i dettagli recuperati
        $shoe = new Shoe($id, $brand, $model, $color, $sex, $price, $category, $sizesAndQuantities, $mediaPath);
        
        return $shoe;
    }
    
    
    /**
     * Metodo di convenienza che estrapola i dati da una riga del database ottenuta con una query per una scarpa, SENZA prendere le taglie e le relative
     * quantità disponibili
     * 
     * @param $row la riga del database restituita da una query
     * 
     * @return un oggetto Shoe con le informazioni recuperate dalle query
     */
    private static function getShoeFromRow($row) 
    {
        $id = $row->id_scarpa;
        $brand = $row->marca;
        $model = $row->modello;
        $color = $row->colore;
        $sex=  $row->sesso;
        $category =  $row->categoria;
        $price = $row->prezzo;        
        $mediaPath = $row->media;

        //Creo quindi l'oggetto Shoe con i dettagli recuperati
        $shoe = new Shoe($id, $brand, $model, $color, $sex, $price, $category, $sizesAndQuantities, $mediaPath);
        
        return $shoe;
    }
    
    
    /**
     * Recupera le categorie a cui appartiene la scarpa considerata
     * 
     * @param $shoeId l'id della scarpa
     * 
     * @return un array di String contenente tutte le categorie trovate; l'array è vuoto in caso di errori o se non trova niente
     */
    public static function getCategoriesFromId($shoeId) 
    {
        //Effettuo la connessione al database
        $mysqli = Database::connect();
        
        $categories = array();
        
        //Se la variabile è settata non ci sono stati errori
        if(isset($mysqli))
        {            
            $query = "SELECT categoria FROM Categoria WHERE id_scarpa = $shoeId";

            $result = $mysqli->query($query);

            
            //Se non ci sono stati errori e la query ha avuto almeno un risultato, procedo
            if(Database::checkForErrors($mysqli) && $result->num_rows > 0)
            {
                //Per ogni riga, recupero i vari campi delle colonne
                while($row = $result->fetch_object())
                {      
                    //Recupero la categoria...
                    $category = $row->categoria;
                       
                    //...e la aggiungo all'array
                    $categories[] = $category;
                }
            }
            
            //Finito di usare il database, lo chiudo
            $mysqli->close();
            
            return $categories;
        }
        else
            return $categories;
    }
    
    
    /**
     * Recupera le taglie disponibili per la scarpa e le relative quantità disponibili
     * 
     * @param $shoeId l'id della scarpa
     * 
     * @return un array associativo del tipo "taglia -> quantita_disponibile"
     */
    public static function getSizesAndQuantitiesFromId($shoeId) 
    {
        $mysqli = Database::connect();
        
        $sizesAndQuantities = array();
        
        if(isset($mysqli))
        {            
            $query = "SELECT taglia, quantita FROM Taglia WHERE id_scarpa = $shoeId";

            $result = $mysqli->query($query);
            
            if(Database::checkForErrors($mysqli) && $result->num_rows > 0)
            {
                while($row = $result->fetch_object())
                {      
                    $size = $row->taglia;
                    $quantity = $row->quantita;
                       
                    //Aggiungo i risutati come array associativo; la taglia è la key, la quantità è il value
                    $sizesAndQuantities[$size] = $quantity;
                }
            }
            
            $mysqli->close();
            
            return $sizesAndQuantities;
        }
        else
            return $sizesAndQuantities;
    }
    
    
    /**
     * Recupera le taglie disponibili per la scarpa e le relative quantità disponibili
     * 
     * @param $shoeId l'id della scarpa
     * 
     * @return un array associativo del tipo "taglia -> quantita_disponibile"
     */
    public static function getSuggestions($shoeId, $sex, $category) 
    {
        $mysqli = Database::connect();
        
        $suggestions = array();
        
        if(isset($mysqli))
        {            
            $query = "SELECT * FROM Scarpa WHERE id_scarpa != $shoeId AND sesso = '$sex' AND categoria = '$category'";

            $result = $mysqli->query($query);
            
            if(Database::checkForErrors($mysqli) && $result->num_rows > 0)
            {
                while($row = $result->fetch_object())
                {      
                    $suggestions[] = ShoeFactory::getShoeFromRow($row);
                }
            }
            
            $mysqli->close();
            
            return $suggestions;
        }
        else
            return $suggestions;
    }
}

?>
