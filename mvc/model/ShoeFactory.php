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
                
                return getShoeFromRow($row, $shoeId);
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
    private function getShoeFromRow($row, $shoeId) 
    {
        $id = $row->id_scarpa;
        $brand = $row->marca;
        $model = $row->modello;
        $color = $row->colore;
        $sex=  $row->sesso;
        $price = $row->publisher;
        
//        $category = $row->genre;
//        
//        $sizesAndQuantities = $row->briefDescription;
        
        $category = "lol";
        $sizesAndQuantities = "aaaaaaaaaa";
        
        $price = $row->mediaPath;

        //Creo quindi il libro con i parametri appena presi...
        $shoe = new Shoe($id, $brand, $model, $color, $sex, $price, $category, $$sizesAndQuantities, $mediaPath);
        
        return $shoe;
    }
}

?>
