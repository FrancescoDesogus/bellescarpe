<?php

/**
 * Rappresenta una (bella) scarpa
 */
class Shoe {

    /**
     * Identificatore della scarpa
     */
    private $id;
    
    /**
     * Marca della scarpa
     */
    private $brand;
    
    /**
     * Modello della scarpa
     */
    private $model;
    
    /**
     * Colore della scarpa
     */
    private $color;
    
    /**
     * Sesso della scarpa
     */
    private $sex;
    
    /**
     * Prezzo della scarpa
     */
    private $price;
    
    /**
     * Le categorie a cui la scarpa appartiene (array)
     */
    private $categories;
    
    
    /*
     * Lista di taglie disponibili per scarpa, con relativa quantità disponibile (array associativo)
     */
    private $sizesAndQuantities;
    
    
    /*
     * Il path della cartella contenente i media relativi alla scarpa
     */
    private $mediaPath;
    
    /**
     * Costrutture dell'appello
     */
    public function __construct($id, $brand, $model, $color, $sex, $price, $categories, $sizesAndQuantities, $mediaPath) 
    {
        $this->setId($id);
        $this->setBrand($brand);
        $this->setModel($model);
        $this->setColor($color);
        $this->setSex($sex);
        $this->setPrice($price);
        $this->setCategories($categories);
        $this->setSizesAndQuantities($sizesAndQuantities);
        $this->setMediaPath($mediaPath);
    }

    /**
     * Restituisce l'indentificatore della scarpa
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Modifica il valore dell'identificatore 
     * 
     * @param int $id il nuovo id
     * 
     * @return boolean true se il valore e' stato modificato, 
     *                 false altrimenti
     */
    public function setId($id) {
        $intVal = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        
        if(!isset($intVal)) 
            return false;
        
        $this->id = $intVal;
        
        return true;
    }

    /**
     * Restituisce la marca
     * @return la marca
     */
    public function getBrand() 
            {
        return $this->brand;
    }

    /**
     * Modifica il valore della marca
     * 
     * @param la nuova marca
     * 
     * @return boolean true se è stata cambiata, false altrimenti
     */
    public function setBrand($marca) {
        $this->brand = $marca;
        
        return true;
    }

    /**
     * Restituisce la lista delle taglie disponibili con relativa quantità
     * 
     * @return array
     */
    public function getSizesAndQuantities() {
        return $this->sizesAndQuantities;
    }
    
    public function setSizesAndQuantities($taglie){
        $this->sizesAndQuantities = $taglie;
    }
    
    /**
     * Restituisce il numero di taglie disponibili
     * 
     * @return int
     */
    public function getSizesCount(){
        return count($this->taglie);
    }

    /**
     * Restituisce il modello della scarpa
     * 
     * @return string
     */
    public function getModel() {
        return $this->model;
    }

    /**
     * Imposta il modello
     * 
     * @param string
     */
    public function setModel($modello) {
        $this->model = $modello;
    }
    
    public function getPrice(){
        return $this->price;
    }
    
    public function setPrice($prezzo){
        $this->price = $prezzo;
    }
    
    public function getColor(){
        return $this->color;
    }
    
    public function setSex($sex){
        $this->sex = $sex;
    }
    
    public function getSex(){
        return $this->sex;
    }
    
    public function setColor($colore){
        $this->color = $colore;
    }
    
    public function getCategories(){
        return $this->categories;
    }
    
    public function setCategories($categoria){
        $this->categories = $categoria;
    }

     public function getMediaPath(){
        return $this->mediaPath;
    }
    
    public function setMediaPath($mediaPath){
        $this->mediaPath = $mediaPath;
    }
}

?>
