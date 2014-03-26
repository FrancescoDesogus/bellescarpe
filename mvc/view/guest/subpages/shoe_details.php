     <!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
     
     <?php
     
//     //Codice per il QR code preso da qua: http://codematrix.altervista.org/archives/1143
//     require("../phpqrcode/qrlib.php");
//     
//     $data = "http://bellescarpecod.altervista.org/mvc/index.php?page=guest&subpage=shoe_detailsaa";
//     
//     $filename = 'qrcode'.md5($data.'|'."L".'|'."4").'.png';
//     
//     QRcode::png($data, $filename, "L", 4, 2);
//     
//     echo '<img src="'.$filename.'" /><hr/>';
     
     
     
     
     echo "Dati della scarpa con id pari a 1: <br> <br>";
     
     if($shoe == null)
     {
        echo "Non ci sono scarpe... coddasa?";
        
     }
     else {

        //Stampo tutti i dati della scarpa con id = 1
        echo "ID = ";
        echo $shoe->getId();
        echo "<br>";

        echo "Marca = ";
        echo $shoe->getBrand();
        echo "<br>";

        echo "Modello = ";
        echo $shoe->getModel();
        echo "<br>";

        echo "Colore = ";
        echo $shoe->getColor();
        echo "<br>";

        echo "Sesso = ";
        echo $shoe->getSex();
        echo "<br>";

        echo "Prezzo = ";
        echo $shoe->getPrice()." euro";
        echo "<br>";


        //Stampo tutte le categorie della scarpa; potrebbero essere più di una
        $i = 0;

        $categories = $shoe->getCategories();

        for($i = 0; $i < count($categories); $i++) 
        {
           echo "Categoria".($i + 1)." = ";
           echo $categories[$i];
           echo "<br>";
        }

        echo "<br>";


        //Stampo tutte le taglie presenti del modello, con relativa quantità disponibile per la data misura
        $sizesAndQuantities = $shoe->getSizesAndQuantities();

        foreach ($sizesAndQuantities as $size => $quantity) 
        {
           echo "Taglia".$size." => Quntita': ".$quantity;
           echo "<br>";
        }

        echo "<br>";


        //Stampo il path dei media della scarpa; di default è null
        $mediaPath = $shoe->getMediaPath();

        echo "MediaPath = ";

        if(isset($mediaPath))
            echo "not null";
        else
            echo "null";

        echo "<br>";
        echo "<br>";
        echo "<br>";
        
        
        
     }
     
     ?>
     
      <div id="blueimp-gallery" class="blueimp-gallery">
          <!-- The container for the modal slides -->
          <div class="slides"></div>
          <!-- Controls for the borderless lightbox -->
          <h3 class="title"></h3>
          <a class="prev">‹</a>
          <a class="next">›</a>
          <a class="close">×</a>
          <a class="play-pause"></a>
          <ol class="indicator"></ol>
          <!-- The modal dialog, which will be used to wrap the lightbox content -->
          <div class="modal fade">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" aria-hidden="true">&times;</button>
                          <h4 class="modal-title"></h4>
                      </div>
                      <div class="modal-body next"></div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-default pull-left prev">
                              <i class="glyphicon glyphicon-chevron-left"></i>
                              Previous
                          </button>
                          <button type="button" class="btn btn-primary next">
                              Next
                              <i class="glyphicon glyphicon-chevron-right"></i>
                          </button>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      
      
        <div id="links">
            <a href="../site_images/banana.jpg" title="Banana" data-gallery>
            banana</a>
            <a href="../site_images/apple.jpg" title="Apple" data-gallery>
             mela</a>
            <a href="../site_images/orange.jpg" title="Orange" data-gallery>
             arancia</a>
        </div>
     
     
            
        <script src="../js/jquery-2.0.3.js"></script>
        <script src="../js/jquery.blueimp-gallery.min.js"></script>
        <script src="../js/bootstrap-image-gallery.min.js"></script>