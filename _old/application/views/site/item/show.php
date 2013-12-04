<section class="container_12">

  <?php echo  $breadcrumbs ?>

  <!-- banner -->
  <section class="grid_12" itemprop="offers" itemscope itemtype="http://schema.org/Offer">

    <!-- main image -->
    <div class="add-large-img extra-btm-space">
      <ul id="large_images">
        <?php foreach ($item->item_image->get() as $image): ?>
          <li class="" id="img0">
            <figure>

              <!-- title -->
              <figcaption>
                <h3>
                  <span itemprop="name"><?php echo  $item->name ?></span>
                  <?php echo  br(1) ?>
                  <?php echo  anchor("perfil/{$item->user->username}", "Por: {$item->user->name} {$item->user->surname}") ?>

                  <?
                    /* check if the logged user is the owner of the item */
                    if(
                        $user->id == $item->user_id
                        and
                        $user->role == 3
                      ):
                    ?>
                    <!-- edit this project -->
                    <?php echo  anchor( base_url('site/items/edit/' . $item->id), 'EDITAR', 'class="link-btn blue float-r edit-btn"') ?>
                  <?php endif ?>

                  <!-- total votes -->
                  <span class="vote-count">
                    <?
                      # Define total votes for the project
                      $votes = $item->item_vote->where('item_id', $item->id)->count();

                      # Define the text pattern
                      $pattern = '%s <span>voto%s</span>';

                      # Check if has only 1 vote
                      if($votes == 1):
                        printf($pattern, $votes, '');
                      else:
                        printf($pattern, $votes, 's');
                      endif;
                    ?>
                  </span> <!-- /total votes -->

                </h3>
              </figcaption> <!-- /title -->

              <!-- image -->
              <img src="<?php echo  amazon_url('images/items/' . $image->image, 940, 460) ?>" alt="<?php echo  $item->name ?>" itemprop="image" />
              <!-- /image -->

              <?
                if( $user->role == 2 ): ?>
                  <!-- call to vote -->
                  <span class="vote vote-banner">
                    <?php echo  anchor( base_url('site/items/build/' . $item->id), 'QUERO PRODUZIR ESTE ITEM', 'class="no-bg-img"') ?>
                  </span>
                <?php else: ?>

                <!-- social icons -->
                <?php echo  $socialLinks ?>

                <!-- call to vote -->
                <span class="vote vote-banner">
                  <a
                    id="<?php echo  'item_vote_' . $item->id ?>"
                    href="#"
                    class="item_vote"
                    data-vote-type="items"
                    data-vote-id="<?php echo  $item->id ?>"
                  >VOTE</a>
                </span>

              <?php endif ?>

            </figure>
          </li>
        <?php endforeach ?>
      </ul>
    </div> <!-- /main image -->

    <!-- thumbnails -->
    <div class="add-img-small extra-btm-space">
        <ul id="thumb_holder">
          <?
           $count = 1;
           foreach ($item->item_image->get() as $image): /* Create all thumbnails */ ?>
            <li class="grid_2 alpha" style="<?php echo ($count == 6)? "margin:0;" : "" ?>">
                <a href="javascript:void(0);">
                  <img
                    src="<?php echo  amazon_url('images/items/' . $image->image, 140, 70) ?>"
                    alt="<?php echo  $item->name ?>"
                  >
                </a>
            </li>
            <?$count++;?>
          <?php endforeach ?>
        </ul>
    </div> <!-- /thumbnails -->
  </section>
  <!-- /banner -->


</section>

<!-- about item + about design + technical details -->
<section class="container_12 extra-btm-space" itemprop="offers" itemscope itemtype="http://schema.org/Offer">

  <!-- about item -->
  <section class="grid_6">

    <!-- title -->
    <h2 class="extra-btm-space extra-top-space">Sobre o produto</h2>

    <?php $paragraphs = explode("\n", $item->description) /* Separate all paragraphs */ ?>

    <?php foreach($paragraphs as $paragraph): /* Add each paragraph into a <p> tag */ ?>
      <p class="extra-btm-space" itemprop="description">
        <?php echo  $paragraph ?>
      </p>
    <?php endforeach ?>

  </section> <!-- /about item -->

  <!-- about design + technical details -->
  <section class="grid_6 omega extra-top-space">

      <!-- about the designer -->
      <section class="grid_6 omega alpha extra-btm-space">

          <?php if($item->user->image): /* check if the designer have any profile image */ ?>
            <img
              src="<?php echo  amazon_url('images/users/' . $item->user->image) ?>"
              alt="<?php echo  $item->user->name ?>"
              width="80"
              height="85"
              style="float: left;"
            >
          <?php else: ?>
            <figure class="profile-img">&nbsp;</figure>
          <?php endif ?>

          <!-- designer description -->
          <article class="profile-des">
              <h2>
                Designer
                <small>
                  <a href="<?php echo  site_url("perfil/{$item->user->username}") ?>">
                    <?php echo  "{$item->user->name} {$item->user->surname}" ?>
                  </a>
                </small>
              </h2>
              <p><?php echo  $item->user->description ?></p>
          </article>

      </section> <!-- /about the designer -->

      <!-- technical information -->
      <section class="grid_6 omega alpha no-under-l">

          <!-- title -->
          <h2 class="extra-btm-space">Informações técnicas</h2>

          <h3>Medidas</h3>
          <?php foreach($item->Item_Variation_Measurement->get() as $measure): ?>
            <!-- width -->
            <p><?php echo  'Largura: ' . $measure->width . 'cm' ?></p>

            <!-- height -->
            <p><?php echo  'Altura: ' . $measure->height . 'cm' ?></p>

            <!-- depth -->
            <p><?php echo  'Profundidade: ' . $measure->depth . 'cm' ?></p>
            <br>
          <?php endforeach ?>

          <h3>Acabamentos</h3>

          <?php foreach( $item->Item_Variation_Material->get() as $material): ?>
            <p><?php echo  $material->material ?></p>
            <br>
          <?php endforeach ?>

      </section> <!-- /technical information -->

  </section> <!-- /about design + technical details -->

</section>
<!-- /about item + about design + technical details -->

<!-- message reviews -->
<section class="container_12">
  <section class="grid_12 extra-btm-space">
    <?php echo  $message->get() ?>
  </section>
</section>
<!-- /message reviews -->

<!-- vote History -->
<section class="container_12">
  <div class="grid_12 extra-btm-space vote-chart">
    <h2>histórico de votos</h2>

    <!-- div that will have the chart inside -->
    <div id="chart_div"></div>
  </div>
</section>
<!-- /vote History -->


<!-- sliders -->
<section class="container_12">

  <?php if( $related_items->exists() ): /* Check if have any item into the same category */ ?>
    <!-- title -->
    <div class="grid_12 full-slider">
      <h2>Projetos similares</h2>
    </div>

    <div class="grid_12 full-slider">
      <!-- slider -->
      <section class="slider prf-slider">

        <!-- carousel -->
        <div id="carousel" class="carousel">
          <ul class="product-list">
            <?php foreach($related_items->get() as $similar): ?>
              <?

                # Define if the item was voted
                $voted = '';

                # Check if the item was voted by the logged user
                if(

                   # Item ID
                   $similar->item_votes
                           ->where('item_id', $similar->id)
                           ->get()
                           ->exists()

                   and

                   # User ID
                   $similar->item_votes
                           ->where('user_id', $user->id)
                           ->get()
                           ->exists()

                  ) $voted = 'active';
              ?>
              <li>

                <!-- header -->
                <h3>

                  <!-- project name -->
                  <?php echo  anchor( base_url('site/items/show/' . $similar->slug), $similar->name ) ?>
                  <?php echo  br(1) ?>

                  <!-- designer name -->
                  <i>
                    <?php echo  anchor("perfil/{$similar->user->username}", "Por: {$similar->user->name}") ?>
                  </i>

                </h3> <!-- /header -->

                <?php echo  $similar->denounceBtn() ?>

                <figure>
                  <a href="#">
                    <img
                      width="200"
                      height="170"
                      alt="<?php echo  $similar->name ?>"
                      src="<?php echo  amazon_url('images/items/' . $similar->item_image->get()->image) ?>"
                    >
                  </a>
                </figure>

                <?php echo  $similar->social_links() ?>
                <?php echo  $similar->voteBtn() ?>

              </li>
            <?php endforeach ?>
          </ul>
        </div> <!-- /carousel -->

        <!-- left arrow -->
        <a class="prev btn-prv" href="javascript:void(0)">&nbsp;</a>

        <!-- right arrow -->
        <a class="next btn-next" href="javascript:void(0)">&nbsp;</a>
      </section> <!-- /slider -->
    </div>
  <?php endif ?>

</section>
<!-- /sliders -->
