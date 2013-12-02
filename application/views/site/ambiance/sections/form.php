<?php echo  form_open( current_url() ) ?>

  <div class="overlay upload-page-popup" id="ambiance-add-form">

    <section class="pop-block">

      <!-- main informations -->
      <div class="blocks border-btm extra-btm-space">

        <!-- page title -->
        <h2 class="pop-title">
          Enviar Ambiente

          <!-- close button -->
          <a href="javascript:void(0)" class="close-btn">&nbsp;</a>

        </h2> <!-- /page title -->


        <div class="wrap-content">

          <!-- left column -->
          <section class="pop-small-block">

            <!-- file upload title from computer -->
            <?php echo  heading('Selecione a Imagem no seu computador ou...', 3) ?>

            <!-- image preview -->
            <section class="msg-box">
              <?php echo  heading('Pré-visualização da imagem:', 3) ?>

              <!-- drop image area -->
              <div id="upload-response" class="grid_12">
                <span id="ambiance_dropbox" class="ambiance_dropbox" >
                  Arraste a imagem para esta área
                  <?php echo  br(1) ?>
                  (Tamanho máximo 2mb)
                </span>
              </div> <!-- /drop image area -->

            </section> <!-- /image preview -->

          </section> <!-- /left column -->

          <!-- right column -->
          <section class="pop-small-block omega last">

            <!-- file upload title from web -->
            <?php echo  heading('insira o endereço da web:', 3) ?>

            <!-- image from web -->
            <div class="inpt-out">
              <input type="text" class="search-area" placeholder="http://sitedaimage.com.br/nome-da-image.jpg">
              <input type="submit" value="OK" class="submit-btn">
            </div>

            <!-- aditional informations -->
            <ul class="long-forms">

              <!-- title -->
              <li>
                <div class="legend">Título:</div>
                <input name="title" type="text" class="search-area">
              </li>

              <!-- categories -->
              <li>
                <div class="legend">Categoria:</div>
                <div class="report-box">
                  <select name="main_category" class="styled" id="main-category">
                  </select>
                </div>
              </li> <!-- /categories -->

              <!-- sub-categories -->
              <li>
                <div class="legend">Sub-Categoria:</div>
                <div class="report-box">
                  <select name="sub_category" class="styled" id="sub-category">
                  </select>
                </div>
              </li> <!-- /sub-categories -->

              <!-- submit + add products -->
              <li>
                <!-- submit ambiance -->
                <button type="submit" class="link-btn blue float-r">publicar</button>

                <!-- add products to this ambiance -->
                <button type="button" id="add-products-btn" class="link-btn grey float-r extra-rt-space" style="border: none;">anexar produtos</button>
                <p>
                  Clicando em PUBLICAR, você estará concordando <br> com os <?php echo  anchor('institucional/termos-e-condicoes', 'termos do site', 'target="_blank"') ?> e com nossa política de <?php echo  anchor('institucional/termos-e-condicoes#privacidade', 'direito de imagem', 'target="_blank"') ?>
                </p>
              </li> <!-- /submit + add products -->

            </ul> <!-- /aditional informations -->

          </section> <!-- /right column -->

        </div>

      </div> <!-- /main informations -->

      <!-- add products -->
      <div id="products-add" class="blocks hide">

        <!-- title + search fild + filter -->
        <header class="pop-header">

          <!-- title -->
          <h2 class="pop-title">Anexar Produtos</h2>

          <!-- title description -->
          <h3 class="extra-lt-space">Anexe produtos do site relacionados a esse ambiente</h3>

          <!-- search area -->
          <section class="pro-search">
            <span class="long-forms">
              <input
                id="search-ambiance"
                type="text"
                class="search-area"
                placeholder="Palavra-chave do produto buscado"
              >
            </span>

            <!-- filter -->
            <div class="sort-list">
              <ul id="filter">

                <!-- filter label -->
                <li>Exibir: </li>

                <!-- all -->
                <li class="border">
                  <a href="#" data-filter="all" class="current-sel">todos </a>
                </li>

                <!-- favorites -->
                <li>
                  <a href="#" data-filter="favorites">meus favoritos</a>
                </li>
              </ul>
            </div> <!-- /filter -->

          </section> <!-- /search area -->

        </header> <!-- /title + search fild + filter -->

        <!-- search result -->
        <section class="slider">

          <!-- total products from search form -->
          <h3>&nbsp;</h3>

          <!-- slider -->
          <div id="search-result" class="carousel">
            <ul>&nbsp;</ul>
          </div> <!-- /slider -->

          <!-- left arrow -->
          <a href="javascript:void(0)" class="prev btn-prv">&nbsp;</a>

          <!-- right arrow -->
          <a href="javascript:void(0)" class="next btn-next">&nbsp;</a>

        </section> <!-- /search result -->

        <!-- added products title -->
        <h2 class="pop-title">produtos anexados</h2>

        <!-- added products title -->
        <section class="slider">

          <!-- slider -->
          <div class="carousel">
            <ul id="products-added">&nbsp;</ul>
          </div> <!-- /slider -->

          <!-- left arrow -->
          <a href="javascript:void(0)" class="prev1 btn-prv">&nbsp;</a>

          <!-- right arrow -->
          <a href="javascript:void(0)" class="next1 btn-next">&nbsp;</a>

        </section> <!-- /added products title -->

      </div> <!-- /add products -->

    </section>

  </div> <!-- /submit ambiance -->

<?php echo  form_close() ?>
