<section class="container_12">
  <section class="grid_12">
    <div class="banner-area"  id="slides">
      <div class="slides_container">

        <?php foreach ($carroussels as $carroussel): ?>
          <div class="slide-content">
            <a href="<?php echo $carroussel->link?>" target="_blank">
              <img src="<?php echo amazon_url('images/carroussels/'.$carroussel->image, 940)?>" alt="">
            </a>
          </div>
        <?php endforeach ?>

      </div>
    </div>
  </section>
</section>
