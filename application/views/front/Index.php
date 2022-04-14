<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php $this->load->view('front/_layout/Head'); ?>
  </head>
  <body class="maincolor">
    <?php $this->load->view('front/_layout/Navbar'); ?>
    <section class="section">
      <div class="maincolor m-0" style="padding-bottom:20px;">
        <div class="container" >
          <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <?php $i=0; foreach ($dataSlide as $d): ?>
                  <li data-target="#carouselExampleIndicators" class="<?php if ($i == 0) {
                    echo "active";
                } ?>" data-slide-to="<?php echo $i; ?>"></li>
                <?php $i++; endforeach;  ?>
            </ol>
            <div class="carousel-inner">
              <?php $i = 0; foreach ($dataSlide as $d): ?>
                <div class=" carousel-item <?php if ($i == 0): ?>
                  <?php echo 'active'; ?>
                <?php endif; ?>">
                  <img class="rounded d-block w-100" src="<?php echo $d->FotoSlide; ?>" alt="First slide">
                </div>
              <?php $i++; endforeach; ?>

            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>

      </div>
    </section>
    <section>
      <div class="seccolor">
        <?php foreach ($dataCat as $dc): ?>
          <div class="container" style="padding-top:25px;padding-bottom:25px;">
            <div class="title text-left" style="margin-bottom:20px;">
              <?php echo $dc->ProductCat; ?>
            </div>
            <div class="row">
              <?php foreach ($dataProduct as $d): ?>
                <?php if ($dc->ProductCat == $d->ProductCat): ?>
                <div class="col-4 col-sm-4 col-md-4 col-lg-3 text-center mt-3 item" id="<?php echo $d->Id; ?>">
                  <a href="<?php if ($d->ProductLink == '-') {
                    echo base_url('order?pro=').urlencode($d->ProductName);
                  }else {
                    echo $d->ProductLink;
                  }  ?>">
                    <div style="padding-top:10px; padding-bottom:10px;" class="produkcolor rounded text-center text-white" style="height:100%;width:100%;">
                      <img class="rounded" style="height:70%;width:70%;" src="<?php echo $d->ProductImage; ?>" alt="">
                      <div class="col-sm-12 text-center produkname" style="margin-top:5px;margin-bottom:5px;">
                        <?php echo $d->ProductName; ?>
                      </div>
                      <button type="button" class="btn btntopup btn-sm btncolor <?php echo 'btn'.$d->Id; ?> text-white" name="button">TOP UP</button>
                    </div>
                  </a>
                </div>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>

      </div>
    </section>
    <div class="container">
      <div class="" style="padding-top:25px;padding-bottom:25px;">
        <div class="title text-center text-white" style="margin-bottom:25px;">
          Contact US
        </div>
        <div class="row mt-3">
          <div class="col-3 col-md-3 col-sm-3 p-1 ">
            <div class="text-center produkcolor rounded p-2">
              <a class="cek text-white" href="#"><i style="font-size:30px;" class="bi bi-whatsapp"></i><br>Whatsapp</a>
            </div>
          </div>
          <div class="col-3 col-md-3 col-sm-3 p-1 ">
            <div class="text-center produkcolor rounded p-2">
              <a class="cek text-white" href="#"><i style="font-size:30px;" class="bi bi-envelope"></i><br>Email</a>
            </div>
          </div>
          <div class="col-3 col-md-3 col-sm-3 p-1 ">
            <div class="text-center produkcolor rounded p-2">
              <a class="cek text-white" href="#"><i style="font-size:30px;" class="bi bi-facebook"></i><br>Facebook</a>
            </div>
          </div>
          <div class="col-3 col-md-3 col-sm-3 p-1 ">
            <div class="text-center produkcolor rounded p-2">
              <a class="cek text-white" href="#"><i style="font-size:30px;" class="bi bi-instagram"></i><br>Instagram</a>
            </div>
          </div>
        </div>
        <div class="title text-center text-white" style="margin-top:25px;">
          About <?php echo $title; ?>
        </div>
        <div class="subtitle text-center" style="margin-top:25px;font-size:15px;">
          <?php echo SITE_NAME; ?> is a global digital entertainment products sales platform which offers customers the most attractive digital products price and services, the merchants we are cooperating with are all from the TOP Ranking income game companies. Besides, the payment methods we are supporting with covered all of the world. As we believe, Join the fun, enjoy the future. Join us and get the latest news.
        </div>
      </div>
    </div>

    <?php $this->load->view('front/_layout/Footer'); ?>
    <script type="text/javascript">
    $( document ).ready(function() {
      console.log( "ready!" );
      $(".item").mouseover(function(){
        var id = $(this).attr('id')
        $(".btn"+id).css("background-color", "#3782ff");
      });
      $(".item").mouseout(function(){
        var id = $(this).attr('id')
        $(".btn"+id).css("background-color", "#283269");
      });
    });
    </script>
  </body>
</html>
