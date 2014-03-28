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
     
//     
//     
//     
//     echo "Dati della scarpa con id pari a 1: <br> <br>";
//     
//     if($shoe == null)
//     {
//        echo "Non ci sono scarpe... coddasa?";
//        
//     }
//     else {
//
//        //Stampo tutti i dati della scarpa con id = 1
//        echo "ID = ";
//        echo $shoe->getId();
//        echo "<br>";
//
//        echo "Marca = ";
//        echo $shoe->getBrand();
//        echo "<br>";
//
//        echo "Modello = ";
//        echo $shoe->getModel();
//        echo "<br>";
//
//        echo "Colore = ";
//        echo $shoe->getColor();
//        echo "<br>";
//
//        echo "Sesso = ";
//        echo $shoe->getSex();
//        echo "<br>";
//
//        echo "Prezzo = ";
//        echo $shoe->getPrice()." euro";
//        echo "<br>";
//
//
//        //Stampo tutte le categorie della scarpa; potrebbero essere più di una
//        $i = 0;
//
//        $categories = $shoe->getCategories();
//
//        for($i = 0; $i < count($categories); $i++) 
//        {
//           echo "Categoria".($i + 1)." = ";
//           echo $categories[$i];
//           echo "<br>";
//        }
//
//        echo "<br>";
//
//
//        //Stampo tutte le taglie presenti del modello, con relativa quantità disponibile per la data misura
//        $sizesAndQuantities = $shoe->getSizesAndQuantities();
//
//        foreach ($sizesAndQuantities as $size => $quantity) 
//        {
//           echo "Taglia".$size." => Quntita': ".$quantity;
//           echo "<br>";
//        }
//
//        echo "<br>";
//
//
//        //Stampo il path dei media della scarpa; di default è null
//        $mediaPath = $shoe->getMediaPath();
//
//        echo "MediaPath = ";
//
//        if(isset($mediaPath))
//            echo "not null";
//        else
//            echo "null";
//
//        echo "<br>";
//        echo "<br>";
//        echo "<br>";
//        
//        
//        
//     }
//     
     ?>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    <!-- Main jumbotron for a primary marketing message or call to action -->
        <div id="gallery_container">
           <div id="blueimp-gallery-carousel" class="blueimp-gallery blueimp-gallery-carousel blueimp-gallery-controls">
               <div class="slides"></div>
               <h3 class="title"></h3>
               <a class="prev">‹</a>
                   <a class="next">›</a>
<!--               <a class="left frecce">
                   
               </a>
               <a class="right frecce ">
               </a>-->
               <a class="play-pause"></a>
               <ol class="indicator"></ol>
           </div>
       </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>Heading</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div>
      </div>

      <hr>

      <footer>
        <p>&copy; Company 2014</p>
      </footer>
    </div> <!-- /container -->

        <script src="../js/jquery-2.0.3.js"></script>
        <script src="../js/bootstrap.js"></script>
        <script src="../js/blueimp-gallery.min.js"></script>
        <script src="../js/blueimp-gallery-youtube.js"></script>
                    <script>
blueimp.Gallery([
        {
            title: 'Apple',
            href: '../site_images/apple.jpg',
            type: 'image/jpg',
            thumbnail: '../img/banana_thumb.jpg'
        },
        {
            title: 'Orange',
            href: '../site_images/orange.jpg',
            type: 'image/jpg'
        },
        {
            title: 'Banana',
            href: '../site_images/banana.jpg',
            type: 'image/jpg'
        },
        {
            title: 'Immagine 1',
            href: 'http://farm4.static.flickr.com/3675/13408578274_b27808d172_c.jpg',
            type: 'image/jpg'
        },
        {
            title: 'Immagine 2',
            href: 'http://farm4.static.flickr.com/3786/13406912874_ce914ea564_c.jpg',
            type: 'image/jpg'
        },
        {
            title: 'Immagine 3',
            href: 'http://farm4.static.flickr.com/3710/13409099245_fc8598d5b4_c.jpg',
            type: 'image/jpg'
        },
        {
            title: 'A YouYube video',
            href: 'https://www.youtube.com/watch?v=SpfMceJDjL4',
            type: 'text/html',
            youtube: 'SpfMceJDjL4',
            poster: 'https://img.youtube.com/vi/SpfMceJDjL4/0.jpg'
        }
    ], {
        container: '#blueimp-gallery-carousel',
        carousel: true
    });

</script>  