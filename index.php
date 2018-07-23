<?php
    require_once 'header.php';
    //////inicio de contenido
?>    
<div id="myCarousel" class="carousel slide" data-ride="carousel" style="z-index:1;" >
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" >
    <div class="item active">
      <img src="img/bannerhome_01.jpg" alt="Credicor">
    </div>

    <div class="item">
      <img src="img/bannerhome_02.jpg" alt="Credicor">
    </div>

    <div class="item">
      <img src="img/bannerhome_03.jpg" alt="Credicor">
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<div class="row">
  <div class="col-md-4"><img src="img/btnhome_01.jpg" alt="" width="300px"></div>
  <div class="col-md-4"><img src="img/btnhome_02.jpg" alt="" width="300px"></div>
  <div class="col-md-4"><img src="img/btnhome_03.jpg" alt="" width="300px"></div>
</div>
<?php
    /////fin de contenido
    require_once 'footer.php';
?>
