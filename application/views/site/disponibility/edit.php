<section class="container_12">

  <?php echo  $breadcrumbs ?>

  <!-- banner -->
  <section class="grid_12">

    <!-- main image -->
    <div class="add-large-img extra-btm-space">
      <ul id="large_images">
        <?php foreach ($disponibility->item->item_image->get() as $image): ?>
          <li class="" id="img0">
            <figure>

              <!-- title -->
              <figcaption>
                <h3>
                  <?php echo  $disponibility->item->name ?>
                  <a href="#">
                    <?php echo  'Por Designer ' . ucwords($disponibility->item->user->name) ?>
                  </a>
                </h3>
              </figcaption> <!-- /title -->

              <!-- image -->
              <img
                src="<?php echo  amazon_url('images/items/' . $image->image) ?>"
                alt="<?php echo  $disponibility->item->name ?>"
                width="940"
                height="413"
              > <!-- /image -->

            </figure>
          </li>
        <?php endforeach ?>
      </ul>
    </div> <!-- /main image -->

    <!-- thumbnails -->
    <div class="add-img-small extra-btm-space">
        <ul id="thumb_holder">
          <?php foreach ($disponibility->item->item_image as $image): /* Create all thumbnails */ ?>
            <li class="grid_2 alpha">
                <a href="javascript:void(0);">
                  <img
                    src="<?php echo  amazon_url('images/items/' . $image->image) ?>"
                    alt="<?php echo  $disponibility->item->name ?>"
                    width="140"
                    height="62"
                  >
                </a>
            </li>
          <?php endforeach ?>
        </ul>
    </div> <!-- /thumbnails -->
  </section> <!-- /banner -->

</section>

<form action="<?php echo  site_url('site/disponibilities/edit/' . $disponibility->id) ?>" method="post">

  <!-- about item + about design + technical details -->
  <section class="container_12 extra-btm-space">

    <!-- about item -->
    <section class="grid_6">

      <!-- title -->
      <h2 class="extra-btm-space extra-top-space">Sobre o produto</h2>

      <?php $paragraphs = explode("\n", $disponibility->item->description) /* Separate all paragraphs */ ?>

      <?php foreach($paragraphs as $paragraph): /* Add each paragraph into a <p> tag */ ?>
        <p class="extra-btm-space">
          <?php echo  $paragraph ?>
        </p>
      <?php endforeach ?>

      <!-- production costs -->
      <h2 class="extra-btm-space extra-top-space">Custo de produção (R$)</h2>
      <input
        name="production_price"
        class="float-l search-area no-bg-img name-text"
        type="text"
        id="production_price"
        data-a-dec=","
        data-a-sep="."
        placeholder="900.00"
        value="<?php echo  $disponibility->production_price ?>"
      >
      <br>
      <br>

      <!-- delivery time -->
      <h2 class="extra-btm-space extra-top-space">Prazo de entrega (em dias)</h2>
      <input
        name="delivery"
        class="float-l search-area no-bg-img name-text"
        type="text"
        placeholder="45"
        value="<?php echo  $disponibility->delivery ?>"
      >
      <br>
      <br>

      <!-- production -->
      <h2 class="extra-btm-space extra-top-space">Produção mensal</h2>
      <input
        name="production_amount"
        class="float-l search-area no-bg-img name-text"
        type="text"
        placeholder="15"
        value="<?php echo  $disponibility->production_amount ?>"
      >
      <br>
      <br>

    </section> <!-- /about item -->

    <!-- about design + technical details + aditional values -->
    <section class="grid_6 omega extra-top-space">

      <!-- about the designer -->
      <section class="grid_6 omega alpha extra-btm-space">

          <?php if($disponibility->item->user->image): /* check if the designer have any profile image */ ?>
            <img
              src="<?php echo  amazon_url('images/users/' . $disponibility->item->user->image) ?>"
              alt="<?php echo  $disponibility->item->user->name ?>"
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
                <small><?php echo  ucwords($disponibility->item->user->name) ?></small>
              </h2>
              <p><?php echo  $disponibility->item->user->description ?></p>
          </article>

      </section> <!-- /about the designer -->

      <!-- technical information -->
      <section class="grid_6 omega alpha no-under-l">

        <!-- title -->
        <h2 class=" extra-btm-space">Informações técnicas</h2>

        <?php foreach($disponibility->disponibility_variation->get() as $variation): ?>
          <p>
            <strong>Dimensões (LxAxP): </strong>
            <?
              $variations = array(
                $variation->item_variation->width,
                $variation->item_variation->height,
                $variation->item_variation->depth
              );

              $variations = implode('cm X ', $variations) . 'cm';

              echo $variations;
            ?>
          </p>
          <p>
            <strong>Acabamento: </strong>
            <?php echo  $variation->item_variation->finish ?>
          </p>
          <p>

            <!-- amount -->
            <strong>Montante adicional: </strong>
            <br>

            <!-- amount input -->
            <input
              name="<?php echo  'aditional_amount_' . $variation->id ?>"
              class="search-area no-bg-img name-text variation"
              type="text"
              placeholder="500.00"
              data-a-dec=","
              data-a-sep="."
              value="<?php echo  $variation->aditional_amount ?>"
            >
            <br>

            <!-- type radios -->
            <?php if($variation->aditional_type == 1): ?>
              <input name="<?php echo  'aditional_type_' . $variation->id ?>" type="radio" value="1" checked> Em valor monetário
              <input name="<?php echo  'aditional_type_' . $variation->id ?>" type="radio" value="0"> Em percentual
            <?php else: ?>
              <input name="<?php echo  'aditional_type_' . $variation->id ?>" type="radio" value="1"> Em valor monetário
              <input name="<?php echo  'aditional_type_' . $variation->id ?>" type="radio" value="0" checked> Em percentual
            <?php endif ?>

            <!-- ID -->
            <input name="variation_id[]" type="hidden" value="<?php echo  $variation->id ?>">
          </p>

          <br>
          <br>
          <br>
        <?php endforeach ?>

      </section> <!-- /technical information -->

    </section> <!-- /about design + technical details -->

  </section> <!-- /about item + about design + technical details -->

  <!-- produce -->
  <section class="container_12">

    <section class="grid_7 float-r accept-terms">

      <!-- terms and image right -->
      <section class="grid_4 terms-con alpha">
        Clicando em ATUALIZAR, você estará concordando com os <a href="#">Termos do site</a> e com nossa política de <a href="#">Direito de Imagem</a>
      </section>

      <!-- submit buttons -->
      <section class="grid_3 omega">
        <button class="link-btn blue float-r" type="submit">Atualizar</button>
      </section>

    </section>

  </section> <!-- /produce -->

</form>
