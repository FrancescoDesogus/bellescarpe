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
    
    <nav class="yamm navbar navbar-default" role="navigation">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Brand</a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle glyphicon glyphicon-search" data-toggle="dropdown"></a>
                <ul class="dropdown-menu">
                  <li>
                      <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Search">
                    <button type="submit" class="btn btn-default">Submit</button>
                     </div>
                  </form>
                  </li>
                </ul>
              </li>
              
              <li class="dropdown">
                <a href="#" class="dropdown-toggle glyphicon glyphicon-user" data-toggle="dropdown"></a>
                <ul class="dropdown-menu">
                  <li>
                      <form class="navbar-form navbar-right" role="form">
                    <div class="form-group">
                      <input type="text" placeholder="Email" class="form-control">
                    </div>
                    <div class="form-group">
                      <input type="password" placeholder="Password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success">Sign in</button>
                  </form>
                  </li>
                </ul>
              </li>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
        
       <div id="owl-example" class="owl-carousel">
        <div class="item"> <img src="../site_images/apple.jpg" width="400px">  </div>
        <div class="item"> <img src="../site_images/banana.jpg" width="400px"> </div>
        <div class="item"> <img src="../site_images/orange.jpg" width="400px"> </div>
        <div class="item"> <img src="http://farm4.static.flickr.com/3675/13408578274_b27808d172_c.jpg" width="400px"> </div>
        <div class="item"> <img src="http://farm4.static.flickr.com/3786/13406912874_ce914ea564_c.jpg" width="400px"> </div>
        <div class="item video"> <iframe src="//www.youtube.com/embed/SpfMceJDjL4" frameborder="0" allowfullscreen></iframe> </div>
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
        <script src="../js/owl.carousel.min.js"></script>
        <script src="../js/bootstrap.js"></script>
        <script>
            $(document).ready(function() {
 
            $("#owl-example").owlCarousel({
                navigation : true, // Show next and prev buttons
                slideSpeed : 300,
                paginationSpeed : 400,
                singleItem:true,                
                autoHeight: true
            });

          });
        </script>

    </body>