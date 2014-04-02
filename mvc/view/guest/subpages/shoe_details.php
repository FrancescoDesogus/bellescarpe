 
    <nav class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle glyphicon glyphicon-user" id="utente" data-toggle="collapse" data-target="#links"></button>
            <button type="button" class="navbar-toggle glyphicon glyphicon-search" id="ricerca" data-toggle="collapse" data-target="#search"></button> 
            <a class="navbar-brand" href="#">BelleScarpe</a>
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
        
    <?php if(isset($shoe)) { ?>
       <div id="owl-example" class="owl-carousel">
            <?php
            if(isset($imagesPaths) && count($imagesPaths) > 0)
            {
                foreach($imagesPaths as $filepath)
                {
            ?>
                    <div class="item slide"> <img src="<?= $filepath ?>" width="400px">  </div>
            <?php
                }
            }
            ?>
                    
            <?php
            if(isset($video_links) && count($video_links) > 0)
            {
                foreach($video_links as $link)
                {
            ?>
                    <div class="item video"> 
                        <div class="js-lazyYT" data-youtube-id="<?= $link ?>" data-width="100%" data-height="100%" ></div>
                    </div>
            <?php
                }
            }
            ?>
       </div>
        
        <div class="container">
      <!-- Example row of columns -->
      <div class="row">
            <div class="col-md-4">
                <h2> Dettagli </h2>
              <table class="table table-striped">
                  
                <!--  marca
                      modello
                      sesso
                      colore
                      categoria -->
                  
                  <tbody>
                      <tr>
                          <td> <strong> Marca </strong> </td>
                          <td> <?= $shoe->getBrand() ?> </td>
                      </tr>
                      <tr>
                          <td> <strong> Modello </strong> </td>
                          <td> <?= $shoe->getModel() ?> </td>
                      </tr>
                      <tr>
                          <td> <strong> Colore </strong> </td>
                          <td> <?= $shoe->getColor() ?> </td>
                      </tr>
                      <tr>
                          <td> <strong> Categoria </strong> </td>
                          <td> <?= $shoe->getCategory() ?> </td>
                      </tr>
                      <tr>
                          <td> <strong> Sesso </strong> </td>
                          <td> <?= $shoe->getSex() ?> </td>
                      </tr>
                      <tr>
                          <td> <strong> Prezzo </strong> </td>
                          <td> <?= $shoe->getPrice() ?> &euro; </td>
                      </tr>
                  </tbody>
                      
                      
                </table>
           </div>
        <div class="col-md-4">
          <h2>Taglie</h2>
          <?php
          $sizesAndQuantities = $shoe->getSizesAndQuantities();
          
          foreach ($sizesAndQuantities as $size => $quantity) 
          {
//              $taglia = (float) $size; //metto un cast a float se voglio mostrare anche le cifre decimali, e al contempo mostrare solo
                                        //la parte intera se la parte decimale è .00
              $taglia = (int) $size; //elimino la virgola e qualsiasi cosa ci sia dopo
              
              if($quantity >= 1) { ?>
                <button type='button' class='btn selectable_button'> <?= $taglia ?> </button>
              <?php } else { ?>
                <button type='button' class='btn' disabled> <?= $taglia ?> </button>
              <?php } 
          }
          
          ?>
          
        </div>
        <div class="col-md-4">
          <h2>Scarpe Simili</h2>
        </div>
      </div>

      <hr>

      <footer>
        <p>&copy; Company 2014</p>
      </footer>
    </div> <!-- /container -->
    <?php } ?>
        

        
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
//                    items : 2,
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
           
         $('.selectable_button').on('click', function () {
             console.log("premuto");
             if($(this).hasClass('btn-success'))
                 $(this).removeClass('btn-success');
             else $(this).addClass('btn-success');
         });
        });//]]>  
    </script>