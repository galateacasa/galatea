<?php if( $home_layouts->exists() ): /* Check if have any layout defined */ ?>
  <?php foreach($home_layouts as $home_layout): /* Add all layouts mark up */ ?>
    <div class="container_12">
      <section class="product-top grid_12">

        <!-- products -->
        <section class="grid_6 alpha fig-product">
          <ul>

            <?php foreach($home_layout->item->get() as $product): /* Mount all product markup */  ?>
              <?php
                //Item price
                //Item price is the sum of the cheapest measure with the cheapest material
                //Material
                $cheapest_material = "";

                foreach ($product->item_variation_material->get() as $material) {
                  if($cheapest_material == "") $cheapest_material = $material->additional_amount;
                  if($cheapest_material > $material->additional_amount)$cheapest_material = $material->additional_amount;
                }

                //measure
                $cheapest_measure = "";

                foreach ($product->item_variation_measurement->get() as $measure) {
                  if($cheapest_measure == "") $cheapest_measure = $measure->additional_amount;
                  if($cheapest_measure > $measure->additional_amount)$cheapest_measure = $measure->additional_amount;
                }

                // Calculate the product price
                $item_price = $cheapest_measure + $cheapest_material + $product->production_price;

                //Calculate the delivery_price
                $delivery_cost = $product->delivery_cost;
                $delivery_price = $item_price * $delivery_cost / 100;

                //Add to the price
                $item_price += $delivery_price;

                //instalments
                $instalment = $item_price / 10;

                // Format the prices
                $item_price = number_format($item_price, 2, ',', '.');
                $instalment = number_format($instalment, 2, ',', '.');
              ?>
              <li>
                <a href="produto/<?php echo $product->slug; ?>">
                  <div class='hdn-top'>
                    <!-- title -->
                    <h3>
                      <!-- name -->
                      <?php echo $product->name; ?>
                      <!-- designer name -->
                      <i>
                        Por <?php echo "{$product->user->name} {$product->user->surname}"; ?>
                      </i>
                    </h3>
                    <!-- /title -->
                  </div>
                  <!-- product image -->
                  <?php
                    if ( $product->item_image->where('principal', 1)->get()->exists() ) {
                      $img = amazon_url("images/items/{$product->item_image->image}", 460, 200);
                    }else{
                      $img = assets_url('images/prd-second.jpg');
                    }
                  ?>
                  <figure>
                    <?php echo img($img); ?>
                  </figure>
                  <span class="rate-new"><?php echo  "R$ $item_price" ?></span>
                  <span class="rate"><?php echo  "10 x R$ $instalment"?></span>
                  <div class="white-box"></div>
                </a>
              </li>
            <?php endforeach ?>
          </ul>
        </section> <!-- /products -->

        <?php foreach($home_layout->ambiance->get() as $ambiance): /* Add all ambiances */ ?>
          <section class='grid_6 omega'>

            <section class='product-top-right'>

              <?php echo  $vote_button->get($ambiance->id, 'ambiances', 'star') ?>

              <!-- title -->
              <h3>
                <a ambiance-id="<?php echo $ambiance->id; ?>" href="<?php echo base_url('inspire-me/' . $ambiance->id); ?>" class="ambiance-info">
                  <?php echo  $ambiance->title ?>
                </a>
              </h3> <!-- /title -->

              <!-- main image -->
              <figure>
                <a ambiance-id="<?php echo $ambiance->id; ?>" href="<?php echo base_url('inspire-me/' . $ambiance->id); ?>" class="ambiance-info">
                  <?php echo  img( amazon_url("images/ambiances/{$ambiance->image}", 458, 482) ) ?>
                </a>
              </figure> <!-- /main image -->

              <?php echo $social_links->get($ambiance->title, $ambiance->title, amazon_url("images/ambiances/{$ambiance->image}"), site_url("inspire-me/{$ambiance->id}") ) ?>

              <div class="white-box"></div>

              <!-- user information -->
              <div class='fig-sm'>
                <figure>

                  <figcaption>

                    <!-- user name -->
                    <?php echo  $ambiance->user->name ? anchor("perfil/{$ambiance->user->username}", "{$ambiance->user->name} {$ambiance->user->surname}") : '' ?>

                    <?php if($ambiance->category_id > 0): ?>
                      <!-- category name -->
                      <mark>
                        <?php echo  anchor("site/categories/show/{$ambiance->category->id}", "{$ambiance->category->name}") ?>
                      </mark>
                    <?php endif ?>

                  </figcaption>

                  <!-- user image -->
                  <?php if($ambiance->user->image): /* Check if the user have any image */ ?>
                    <a href="<?php echo  base_url("perfil/{$ambiance->user->username}") ?>">
                      <img src="<?php echo  amazon_url("images/users/{$ambiance->user->image}", 60, 60) ?>" alt="<?php echo  $ambiance->user->name ?>">
                    </a>
                  <?php else: ?>
                    <figure class="profile-img" style="width:60px; height:60px; float:right; margin:0;" >&nbsp;</figure>
                  <?php endif ?>

                </figure>
              </div> <!-- /user information -->

            </section>

          </section>

        <?php endforeach ?>

      </section>
    </div>
  <?php endforeach ?>

  <!-- overlay layer -->
  <div class="overlay upload-page-popup" ></div>
  <section class="pop-block-extended"></section>
<?php endif ?>
