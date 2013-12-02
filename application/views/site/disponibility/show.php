<section class="container_12">

  <?php echo  $breadcrumbs ?>

  <!-- banner -->
  <section class="grid_12">

    <!-- main image -->
    <div class="add-large-img">
      <ul id="large_images">
        <?php $imageCount = 0; ?>
        <?php foreach($product->item_image->get() as $image): ?>
          <?php if ($imageCount === 0) { ?>
          <li class="" id="img0">
          <?php } else { ?>
          <li class="hide" id="img0">
          <?php } ?>
            <figure>

              <!-- title -->
              <figcaption>
                <h3>
                  <?php echo  $product->name ?>
                  <?php echo  anchor("perfil/{$product->user->username}", "Por: {$product->user->name} {$product->user->surname}") ?>
                  <?
                    /* check if the logged user is the owner of the item */
                    if(
                        $this->session->userdata('id') == $product->user_id
                        and
                        $this->session->userdata('role') == 2
                      ):
                    ?>
                    <!-- edit this project -->
                    <a href="<?php echo  site_url('site/disponibilities/edit/' . $product->id) ?>" class="link-btn blue float-r edit-btn">EDITAR</a>
                  <?php endif ?>

                  <?

                    # Define if the item was starred
                    $starred = '';

                    # Check if the item was starred by the logged user
                    if($product->item_vote->where('user_id', $this->session->userdata('id'))->get()->exists()){
                      $starred = 'active';
                    }

                  ?>
                  <span class="star-big">
                      <a
                      id="<?php echo  "disponibility_vote_{$product->id}" ?>"
                      href="#"
                      class="item_vote <?php echo  $starred ?>"
                      data-vote-type="disponibilities"
                      data-vote-id="<?php echo  $product->id ?>"
                    >&nbsp;</a>
                  </span>
                </h3>
              </figcaption> <!-- /title -->
              <!-- image -->
              <img
                src="<?php echo  amazon_url('images/items/' . $image->image, 940, 420) ?>"
                alt="<?php echo  $product->name ?>"
                width="940"
                height="420"
              >
              <!-- /image -->

              <!-- social icons -->
              <?php echo  $socialLinks; ?>
              <!-- /social icons -->

            </figure>
          </li>
        <?php $imageCount++; ?>
        <?php endforeach ?>
      </ul>
    </div> <!-- /main image -->

    <!-- thumbnails -->
    <div class="add-img-small extra-btm-space">
      <ul id="thumb_holder" class="product">
       <?php $count = 1; foreach ($product->item_image->get() as $image): /* Create all thumbnails */ ?>
          <li class="grid_2 alpha" style="<?php echo  $count == 6 ? "margin:0;" : "" ?>">
            <a href="javascript:void(0);">
              <img
                src="<?php echo  amazon_url("images/items/{$image->image}", 140, 62) ?>"
                alt="<?php echo  $product->name ?>"
                width="140"
                height="62"
              >
            </a>
          </li>
          <?php $count++ ?>
        <?php endforeach ?>
      </ul>
    </div> <!-- /thumbnails -->
  </section> <!-- /banner -->
</section>

<!-- about item + about design + technical details -->
<section class="container_12 extra-btm-space">
  <form action="<?php echo  site_url('site/cart/add');?>" method="POST">

    <input type="hidden" name="item_id" value="<?php echo  $product->id ?>">
    <input type="hidden" name="delivery_cost" id="delivery_cost" value="<?php echo  $product->delivery_cost ?>">

    <?php if( !empty($ambiance_link) ): /* User came to the product page from an ambiance link? */ ?>
      <input type="hidden" name="ambiance_link" value="<?php echo  $ambiance_link ?>">
    <?php endif ?>

    <!-- options + price + cart -->
    <section class="grid_12 add-to-cart-container product-page">

      <!-- measures -->
      <div class="report-box  custom-select msr" style="width: 157px; margin-right: 15px;">

        <!-- title -->
        <h2>Medidas (L x A x P)</h2>

        <!-- options -->
        <select name="measurement" id="measurement" class="styled variations" style="-webkit-appearance: menulist-button; width: 219px; position: absolute; opacity: 0; left: 0px; height: 25px;">
          <option value="">Selecione uma medida</option>
          <?php foreach($measures as $measure): ?>
            <option
              value="<?php echo  $measure->id ?>"
              data-additional-type="<?php echo  $measure->additional_type ?>"
              data-additional-amount="<?php echo  $measure->additional_amount ?>"
            >
            <?
              $options = array(
                $measure->width,
                $measure->height,
                $measure->depth
              );

              $options = implode('cm X ', $options) . 'cm';
              echo $options;

            ?>
            </option>
          <?php endforeach ?>

        </select> <!-- /options -->

        <!-- custom option -->
        <span class="customSelect styled customSelectChanged" style="display: inline-block; width: 140px !important;">
          <span class="customSelectInner" style="width: 153px; display: inline-block;">
            Selecione uma medida
          </span>
        </span> <!-- /custom option -->

      </div> <!-- /measures -->

      <!-- material -->
      <div class="report-box custom-select msr" style="width: 330px; margin-right: 15px;">

        <!-- title -->
        <h2>Acabamento</h2>
        <!-- options -->
        <select name="material" id="material"  class="styled variations" style="-webkit-appearance: menulist-button; width: 310px; position: absolute; opacity: 0; left: 0px; height: 25px;">
          <option value="">Selecione um acabamento</option>
          <?php foreach($materials as $material): ?>
            <option
              value="<?php echo  $material->id ?>"
              data-additional-type="<?php echo  $material->additional_type ?>"
              data-additional-amount="<?php echo  $material->additional_amount ?>"
            >
            <?php echo  $material->material ?>
            </option>
          <?php endforeach ?>

        </select> <!-- /options -->

        <!-- custom option -->
        <span class="customSelect styled customSelectChanged" style="display: inline-block; width: 310px !important;">
          <span class="customSelectInner">
            Selecione um acabamento
          </span>
        </span> <!-- /custom option -->

      </div> <!-- /material -->


      <!-- quantity -->
      <div class="report-box custom-select msr" style="width: 82px; margin-right: 15px;">

        <!-- title -->
        <h2>Quantidade</h2>

        <input
          type="text"
          class="search-area float-l mid-text-box no-bg-img alpha extra-top-space"
          style="width: 70px !important; margin-top: 0px; height: 20px;"
          name="qty"
          id="qty"
          value="<?php echo  set_value('qty', 1);?>"
        >

      </div> <!-- /quantity -->

      <!-- add to cart -->
      <span class="report-box cart-btn float-r" style="width: 160px; margin-left: 0px !important;">
        <button type="submit" class="link-btn blue" style="margin: 0;">adicionar ao carrinho</button>
      </span>

      <!-- price -->
      <div class="report-box grand-total float-r" style="width: 140px; margin-right: 5px;">
        <input class="variation money"
          name="price"
          id="price"
          value=""
          type="text"
          data-default-price="<?php echo  "R$ {$product->production_price}" ?>"
        >
        <label>total</label>
        <span  class="remark">10x de <input class="money" value="" id="total_instalments" type="text" /></span>
      </div> <!-- /price -->

    </section> <!-- /options + price + cart -->
  </form>

  <!-- about item -->
  <section class="grid_6">

    <!-- title -->
    <h2 class="extra-btm-space extra-top-space">Sobre o produto</h2>

    <?php $paragraphs = explode("\n", $product->description) /* Separate all paragraphs */ ?>

    <?php foreach($paragraphs as $paragraph): /* Add each paragraph into a <p> tag */ ?>
      <p class="extra-btm-space">
        <?php echo  $paragraph ?>
      </p>
    <?php endforeach ?>

    <br>
    <br>

    <!-- title -->
    <h2 class="extra-btm-space extra-top-space">
      <?
        $pattern = "Prazo de entrega: %s dias";

        if($order_items->result_count() > $item_supplier->production_amount):
          $delivery_exceeded = TRUE;
          printf($pattern, $order_items->result_count() / $item_supplier->production_amount * $product->delivery_time);
        else:
          printf($pattern, $product->delivery_time);
        endif;
      ?>
    </h2>

    <?php if( isset($delivery_exceeded) and $item_supplier->production_amount > 0 ): ?>
      <div class="product-delivery-exceeded">
        Esse prazo de entrega é superior ao habitual desse item pois a capacidade do fornecedor está esgotada nesse mês
      </div>
    <?php endif ?>

  </section> <!-- /about item -->

  <!-- about design + technical details -->
  <section class="grid_6 omega extra-top-space">


      <!-- about the designer -->
      <section class="grid_6 omega alpha extra-btm-space">

        <?php if($product->user->image): /* check if the designer have any profile image */ ?>
          <img
            src="<?php echo  amazon_url('images/users/' . $product->user->image) ?>"
            alt="<?php echo  $product->user->name ?>"
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
                <a href="<?php echo  site_url("perfil/{$product->user->username}")?>">
                  <?php echo  $product->user->name." ".$product->user->surname ?>
                </a>
              </small>
            </h2>
            <p><?php echo  $product->user->description ?></p>
        </article>

      </section> <!-- /about the designer -->

      <!-- technical information -->
      <section class="grid_6 omega alpha no-under-l">

          <!-- title -->
          <h2 class=" extra-btm-space">Informações técnicas</h2>

          <h3>Medidas</h3>
          <?php foreach($measures as $measure): ?>
            <!-- width -->
            <p><?php echo  "Largura: {$measure->width}cm" ?></p>

            <!-- height -->
            <p><?php echo  "Altura: {$measure->height}cm" ?></p>

            <!-- depth -->
            <p><?php echo  "Profundidade: {$measure->depth}cm" ?></p>
            <?php echo  br(1) ?>
          <?php endforeach ?>

          <h3>Acabamentos</h3>

          <?php foreach( $materials as $material): ?>
            <p><?php echo  $material->material ?></p>
          <?php endforeach ?>

      </section> <!-- /technical information -->

  </section> <!-- /about design + technical details -->

</section> <!-- /about item + about design + technical details -->

<!-- modal with some descriptions -->
<!--
<section class="container_12">
  <section class="grid_12 extra-top-space">
    <div class=" product-detail">
      <figure class="grid_5 alpha">&nbsp;</figure>
      <article class="grid_6 omega">
          <h2>Detalhes estrutura madeira</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pharetra massa quis risus tincidunt ultrices. Nulla et neque nibh, ac hendrerit risus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nullam eu nibh quis tellus venenatis pellentesque.</p>
          <p>Pellentesque pulvinar leo mauris. Donec quis ipsum quis nisl scelerisque tempor. Suspendisse potenti. Aliquam pulvinar ipsum sed lectus pulvinar malesuada. Integer dui enim, aliquam ac aliquet tincidunt, convallis ut arcu. Aenean cursus mi vitae dui ornare imperdiet. Nulla viverra, felis in aliquam sodales, nisi neque luctus mi, aliquet dignissim ipsum quam sit amet mauris. </p>
      </article>
    </div>
  </section>
</section>
-->
<!-- /modal with some descriptions -->

<!-- message reviews -->
<section class="container_12">
  <section class="grid_12 extra-btm-space">
    <?php echo  $message->get() ?>
  </section>
</section> <!-- /message reviews -->

<!-- full-slider -->
<div class="full-slider">
  <section class="container_12">

    <?php if($same_style): ?>

      <!-- title -->
      <header class="grid_12">
        <h2>Produtos com o mesmo estilo</h2>
      </header>

      <!-- disponibility amciances -->
      <section class="grid_12">
        <div id="disponibility-ambiances" class="horizontal-slider-container">

          <!-- carousel -->
          <div class="horizontal-slider-content">
            <ul id="carousel-ambiance-star" class="horizontal-slider">

              <?
                # Number of ambiances
                $count_same_style = $same_style->result_count();
                $required_li = 4 - $count_same_style;
              ?>

              <?
                foreach($same_style as $same) echo $same->show('product', 'star');

                if ($count_same_style < 4) echo str_repeat('<li class="empty"></li>', $required_li);
              ?>
            </ul>
          </div> <!-- /carousel -->

          <?php if( $count_same_style > 4): /* Check if the arrows are necessary */ ?>
            <div class="arrows">
              <!-- left arrow -->
              <a href="#" class="previous">&nbsp;</a>

              <!-- right arrow -->
              <a href="#" class="next">&nbsp;</a>
            </div>
          <?php endif ?>

        </div>
      </section> <!-- /disponibility amciances -->
    <?php endif ?>

    <?php if( $related_products->exists() ): ?>

      <!-- title -->
      <header class="grid_12">
        <h2>Produtos similares</h2>
      </header>

      <!-- Second slider -->
      <section class="grid_12">

        <!-- carousel -->
        <div id="related-products" class="horizontal-slider-container">

          <!-- content -->
          <div class="horizontal-slider-content">
            <ul id="carousel-product-my" class="horizontal-slider">
              <?
                # Nmber of products
                $count_products = $related_products->result_count();
                $required_li = 4 - $count_products;

                foreach( $related_products as $product ) echo $product->show('product', 'star');

                if ($count_products < 4) echo str_repeat('<li class="empty"></li>', $required_li);
              ?>
            </ul>
          </div> <!-- /content -->

          <?php if( $count_products > 4): ?>
            <div class="arrows">
              <!-- left arrow -->
              <a href="#" class="previous">&nbsp;</a>

              <!-- right arrow -->
              <a href="#" class="next">&nbsp;</a>
            </div>
          <?php endif ?>

        </div> <!-- /carousel -->

      </section> <!-- /second slider -->
    <?php endif ?>

    <?php if( $related_ambiances->exists() ): ?>
      <!-- overlay layer -->
      <div class="overlay upload-page-popup" ></div>
      <section class="pop-block-extended"></section>

      <!-- title -->
      <header class="grid_12">
        <h2>Ambientes onde esse produto foi utilizado</h2>
      </header>

      <!-- third slider -->
      <section class="grid_12">

        <!-- carousel -->
        <div id="related-ambiances" class="horizontal-slider-container">

          <!-- content -->
          <div class="horizontal-slider-content">
            <ul class="horizontal-slider">
              <?
                # Nmber of products
                $count_ambiances = $related_ambiances->result_count();
                $required_li = 4 - $count_ambiances;

                foreach($related_ambiances as $ambiance) echo $ambiance->show();

                if ($count_ambiances < 4) echo str_repeat('<li class="empty"></li>', $required_li);
              ?>
            </ul>
          </div> <!-- /content -->

          <?php if( $count_ambiances > 4): ?>
            <div class="arrows">
              <!-- left arrow -->
              <a href="#" class="previous">&nbsp;</a>

              <!-- right arrow -->
              <a href="#" class="next">&nbsp;</a>
            </div>
          <?php endif ?>

        </div> <!-- /carousel -->

      </section> <!-- /third slider -->
    <?php endif ?>

  </section>
</div> <!-- /full-slider -->
