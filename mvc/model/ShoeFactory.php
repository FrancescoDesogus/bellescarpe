<?php

include_once 'Shoe.php';
include_once 'Database.php';

/**
 * Classe per creare/recuperare/modificare il catalogo dei libri presenti nel sito
 */
class ShoeFactory 
{   
    /**
     * Dato l'id di un libro, ritorna il nome di esso.
     * 
     * @param $bookId l'id del libro considerato
     * 
     * @return il nome del libro, o null altrimenti
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
                
                return ShoeFactory::getShoeFromRow($row, $shoeId);
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
     * Metodo di convenienza che estrapola i dati da una riga del database
     * per creare il libro che ne risulta
     * 
     * @param $row la riga del database
     * 
     * @return la scarpa recuparata
     */
    private static function getShoeFromRow($row, $shoeId) 
    {
        $id = $row->id_scarpa;
        $brand = $row->marca;
        $model = $row->modello;
        $color = $row->colore;
        $sex=  $row->sesso;
        $price = $row->prezzo;
        
        $category = ShoeFactory::getCategoriesFromId($shoeId);
        
        $sizesAndQuantities = ShoeFactory::getSizesAndQuantitiesFromId($shoeId);
        
        $mediaPath = $row->media;

        //Creo quindi il libro con i parametri appena presi...
        $shoe = new Shoe($id, $brand, $model, $color, $sex, $price, $category, $sizesAndQuantities, $mediaPath);
        
        return $shoe;
    }
    
    
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
            

            //Se non ci sono stati errori ed il catalogo ha almeno 1 elemento, procedo
            if(Database::checkForErrors($mysqli) && $result->num_rows > 0)
            {
                //Per ogni riga, recupero i vari campi delle colonne
                while($row = $result->fetch_object())
                {      
                    //Recupero il libro dalla riga...
                    $category = $row->categoria;
                       
                    //...e lo aggiungo all'array
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
    
    
    public static function getSizesAndQuantitiesFromId($shoeId) 
    {
        //Effettuo la connessione al database
        $mysqli = Database::connect();
        
        $sizesAndQuantities = array();
        
        //Se la variabile è settata non ci sono stati errori
        if(isset($mysqli))
        {            
            $query = "SELECT taglia, quantita FROM Taglia WHERE id_scarpa = $shoeId";

            $result = $mysqli->query($query);
            

            //Se non ci sono stati errori ed il catalogo ha almeno 1 elemento, procedo
            if(Database::checkForErrors($mysqli) && $result->num_rows > 0)
            {
                //Per ogni riga, recupero i vari campi delle colonne
                while($row = $result->fetch_object())
                {      
                    $size = $row->taglia;
                    $quantity = $row->quantita;
                       
                    $sizesAndQuantities[$size] = $quantity;
                }
            }
            
            //Finito di usare il database, lo chiudo
            $mysqli->close();
            
            return $sizesAndQuantities;
        }
        else
            return $sizesAndQuantities;
    }
}

?>
