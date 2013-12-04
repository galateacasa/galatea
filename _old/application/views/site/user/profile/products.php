<div class="grid_12">
  <?php echo  br(2) ?>

  <!-- title -->
  <h2 id="product" class="profile-tab">

    <a
      class="filter activate"
      data-hide="carousel-product-mine"
      data-show="carousel-product-starred"
      data-section="product"
      href="#carousel-product-starred"
    >produtos Preferidos</a>

    <a
      class="filter border"
      data-hide="carousel-product-starred"
      data-show="carousel-product-mine"
      data-section="product"
      href="#carousel-product-mine"
    ><?php echo  $user->id == $this->session->userdata('id') ? 'Meus produtos' : "Produtos produzidos" ?></a>

  </h2> <!-- /title -->

  <!-- user starred products -->
  <section id="carousel-product-starred">

    <div class="horizontal-slider-container">
      <!-- carousel -->
      <div class="horizontal-slider-content">
        <ul id="carousel-product-star" class="horizontal-slider">

          <?php if( !$user_products_starred->exists() ): ?>

            <?php $lis = 4 ?>

            <?php if( $user->id == $this->session->userdata('id') ): /* Check if the user is the owner */ ?>
              <?php $lis-- ?>
              <!-- default product -->
              <li class="no-data product">
                <?php echo  heading('você ainda não possui <br> produtos selecionados', 2) ?>
                <div class="msg">faça a <img src="/assets/images/rate.png" alt="estrela"> brilhar nos <br> itens que você mais gosta</div>
              </li>
            <?php endif ?>

            <?php echo  str_repeat('<li class="empty"></li>', $lis) ?>

          <?php else: ?>

            <?
              # Number of products
              $count_products = $user_products_starred->result_count();
              $required_li = 4 - $count_products;

              /* Lista all products */
              foreach( $user_products_starred as $product ) {
                $action = $user->id == $this->session->userdata('id') ? 'close' : 'star';
                echo $product->show('product', $action);
              }

              # Add a custom options, if necessary
              if ($count_products < 4) echo str_repeat('<li class="empty"></li>', $required_li);
            ?>

          <?php endif ?>

        </ul>
      </div> <!-- /carousel -->

      <?php if( $user_products_starred->result_count() > 4): ?>
        <div class="arrows">
          <!-- left arrow -->
          <a href="#" class="previous">&nbsp;</a>

          <!-- right arrow -->
          <a href="#" class="next">&nbsp;</a>
        </div>
      <?php endif ?>

    </div>

  </section> <!-- /user starred products -->

  <!-- user products -->
  <section id="carousel-product-mine" class="hide">

    <!-- carousel -->
    <div class="horizontal-slider-container">

      <!-- content -->
      <div class="horizontal-slider-content">
        <ul id="carousel-product-my" class="horizontal-slider">

          <?php if( !$user_products->exists() ): /* Check if the user have any product */  ?>

            <?php $lis = 4 ?>

            <?php if( $user->id == $this->session->userdata('id') ): /* Check if the user is the owner of the profile */ ?>
              <?php $lis--; ?>
              <!-- default product -->
              <li class="no-data product">
                <?php echo  heading('Você não possui produtos', 2) ?>
                <div class="msg">Poste e divulgue seus projetos <?php echo  br() ?> para eles virarem produtos</div>
                <?php echo  anchor('institucional/designer', 'Saiba mais') ?>
              </li> <!-- /default product -->
            <?php endif ?>

            <?php echo  str_repeat('<li class="empty"></li>', $lis) ?>

          <?php else: ?>

            <?
              # Nmber of products
              $count_products = $user_products->result_count();
              $required_li = 4 - $count_products;

              foreach( $user_products as $user_product ) {
                $action = $user->id == $this->session->userdata('id') ? 'close' : 'star';
                echo $user_product->show('product', $action);
              }

              if ($count_products < 4) echo str_repeat('<li class="empty"></li>', $required_li);
            ?>

          <?php endif ?>

        </ul>
      </div> <!-- /content -->

      <?php if( $user_products->result_count() > 4): ?>
        <div class="arrows">
          <!-- left arrow -->
          <a href="#" class="previous">&nbsp;</a>

          <!-- right arrow -->
          <a href="#" class="next">&nbsp;</a>
        </div>
      <?php endif ?>

    </div> <!-- /carousel -->

  </section> <!-- /user products -->

</div>
