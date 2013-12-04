<script>
$(document).ready(function() {
  <?
  if (!$this->session->userdata('location')) {
    ?>
    $("#location").modal({
      backdrop: 'static'
    })
    $("#location").modal('show');
    <?
  }
  ?>
});

</script>
<div class="row-fluid">
  <h1>
    Galatea
  </h1>
  <p>
    Móveis únicos para todos os lares
  </p>
</div>

<div class="row" style="margin-left:10%;">
  <div class="span9">
    <div id="myCarousel" class="carousel slide">
      <div class="carousel-inner">
        <?
        $i=0;
        foreach ($carroussels as $carroussel) {
          $active = $i==0?"active":"";
          ?>
          <div style="height:380px;" class="item <?php echo $active?>">
            <a target="_blank" href="<?php echo $carroussel->link?>">
              <img  src="<?php echo amazon_url('images/carroussels/'.$carroussel->image)?>" alt="">
              <div class="carousel-caption">
                <h4><?php echo $carroussel->title?></h4>
                <p><?php echo $carroussel->description?></p>
              </div>
            </a>
          </div>
          <?
          $i++;
        }
        ?>
      </div>
      <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
    </div>
    <hr/>
  </div>
</div>

<div class="row-fluid">
  <legend>Produtos</legend>
  <ul class="thumbnails">
    <?
    foreach ($products as $product) {
      ?>
      <li class="">
        <?php echo  $product->show(); ?>
      </li>
      <?
    }
    ?>
  </ul>
</div>

<div class="row-fluid">
  <legend>Projetos</legend>
  <ul class="thumbnails">
    <?
    foreach ($projects as $project) {
      ?>
      <li>
        <?php echo  $project->show(); ?>
      </li>
      <?
    }
    ?>
  </ul>
</div>

<hr>
<div>
  © Galatea 2012
</div>
