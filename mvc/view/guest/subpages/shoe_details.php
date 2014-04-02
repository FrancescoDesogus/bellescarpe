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
    <nav class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle glyphicon glyphicon-user" id="utente" data-toggle="collapse" data-target="#links"></button>
            <button type="button" class="navbar-toggle glyphicon glyphicon-search" id="ricerca" data-toggle="collapse" data-target="#search"></button> 
            <a class="navbar-brand" href="#">Brand</a>
        </div>
        <ul class="collapse navbar-collapse nav navbar-nav" id="links">
            <form class="navbar-form navbar-right" role="form">
                <div class="form-group">
                    <input type="text" placeholder="Email" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Password" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Sign in</button>
            </form>
        </ul>
        <div class="collapse navbar-collapse" id="search">
            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </nav>
        
       <div id="owl-example" class="owl-carousel">
            <?php
            if(isset($video_links) && count($video_links) > 0)
            {
                foreach($video_links as $link)
                {
            ?>
                    <div class="item video"> 
                        <div class="js-lazyYT" data-youtube-id="<?= $link?>" data-width="100%" data-height="100%" ></div>
                    </div>
            <?php
                }
            }
            ?>

            <?php
            if(isset($result) && count($result) > 0)
            {
                foreach($result as $filename)
                {
            ?>
                    <div class="item slide"> <img src="<?= $filename ?>" width="400px">  </div>
            <?php
                }
            }
            ?>
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
        

        
        <!--  jQuery 1.7+  -->
        <script src="../js/jquery-2.0.3.js"></script>

        <!-- Include js plugin -->
        <script src="../js/lazyYT.min.js"></script>
        <script src="../js/owl.carousel.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.js-lazyYT').lazyYT(); 
                    
                $("#owl-example").owlCarousel({
                    navigation : true, // Show next and prev buttons
                    slideSpeed : 300,
                    paginationSpeed : 400,
                    singleItem:true,                
                    autoHeight: true,
                    rewindNav: true,
                    afterMove: moved
                });
                
                function moved() {
                    $(".js-lazyYT").removeClass("lazyYT-video-loaded");
                    $(".js-lazyYT").addClass("lazyYT-image-loaded");
                    $('.js-lazyYT').lazyYT(); 
                }
            });
        </script>
        
            <script type='text/javascript'>//<![CDATA[ 
        $(document).ready(function () {
            
            $('#ricerca').on('click', function () {
                console.log("ricerca")
              var actives = $('.navbar').find('.collapse.in'),
                   hasData;
                   
               if (actives && actives.length) {
                   hasData = actives.data('collapse')
                   if (hasData && hasData.transitioning) return
                   actives.collapse('hide')
                   hasData || actives.data('collapse', null)
               }
           });
           
           $('#utente').on('click', function () {
               console.log("utente")
               var actives = $('.navbar').find('.collapse.in'),
                   hasData;
                   
               if (actives && actives.length) {
                   hasData = actives.data('collapse')
                   if (hasData && hasData.transitioning) return
                   actives.collapse('hide')
                   hasData || actives.data('collapse', null)
               }
           });
           
//           $(function(){
//            $("#frame").on('click', function () { 
//                $("#frame").attr("src", "http://www.youtube.com/embed/"+ "SpfMceJDjL4" +"?rel=0&autoplay=1");
//                });
//          });
        });//]]>  
    </script>

    </body>