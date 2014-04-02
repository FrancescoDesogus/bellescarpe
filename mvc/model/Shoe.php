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
     * La categoria a cui la scarpa appartiene (array)
     */
    private $category;
    
    
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
    public function __construct($id, $brand, $model, $color, $sex, $price, $category, $sizesAndQuantities, $mediaPath) 
    {
        $this->setId($id);
        $this->setBrand($brand);
        $this->setModel($model);
        $this->setColor($color);
        $this->setSex($sex);
        $this->setPrice($price);
        $this->setCategory($category);
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
    
    public function getCategory(){
        return $this->category;
    }
    
    public function setCategory($categoria){
        $this->category = $categoria;
    }

     public function getMediaPath(){
        return $this->mediaPath;
    }
    
    public function setMediaPath($mediaPath){
        $this->mediaPath = $mediaPath;
    }
    
    
    public function toString()
    {
        echo "Dati della scarpa con id pari a ". $this->getId() . ": <br> <br>";

        echo "Marca = ";
        echo $this->getBrand();
        echo "<br>";

        echo "Modello = ";
        echo $this->getModel();
        echo "<br>";

        echo "Colore = ";
        echo $this->getColor();
        echo "<br>";

        echo "Sesso = ";
        echo $this->getSex();
        echo "<br>";

        echo "Prezzo = ";
        echo $this->getPrice()." euro";
        echo "<br>";

        echo "Categoria = ";
        echo $this->getCategory();
        echo "<br>";


        echo "<br>";


        //Stampo tutte le taglie presenti del modello, con relativa quantità disponibile per la data misura
        $sizesAndQuantities = $this->getSizesAndQuantities();

        foreach ($sizesAndQuantities as $size => $quantity) 
        {
           echo "Taglia".$size." => Quntita': ".$quantity;
           echo "<br>";
        }


        //Stampo il path dei media della scarpa; di default è null
        $mediaPath = $this->getMediaPath();

        echo "MediaPath = ";

        if(isset($mediaPath))
            echo $mediaPath;
        else
            echo "null";

        echo "<br>";
        echo "<br>";
        echo "<br>";
    }
}

?>
