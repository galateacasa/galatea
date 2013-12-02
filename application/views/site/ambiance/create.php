<!-- overlay -->
<div class="overlay upload-page-popup"></div>

<?php echo  form_open('#', 'id="ambiance-form"') ?>
    <section id="ambiance-add-form" class="pop-block">

      <!-- main informations -->
      <div class="blocks">

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
            <?php echo  heading('Arraste uma imagem para o quadrado ou...', 3) ?>

            <!-- custom file input -->
            <input type="file" name="file" id="ambiance-image" class="file-upload-styled" />

            <!-- image preview -->
            <section class="msg-box">

              <!-- title -->
              <?php echo  heading('Pr&#233;-visualiza&#231;&#227;o da imagem:', 3) ?>

              <!-- drop image area -->
              <div id="upload-response" class="grid_12">

                <span id="ambiance_dropbox" class="ambiance_dropbox" >
                  Arraste a imagem para esta &#225;rea
                  <?php echo  br(1) ?>
                  (Tamanho m&#225;ximo 2mb)
                </span>

                <!-- upload message -->
                <span id="ambiance-upload-message"></span>

              </div> <!-- /drop image area -->

            </section> <!-- /image preview -->

          </section> <!-- /left column -->

          <!-- right column -->
          <section class="pop-small-block omega last">

            <!-- file upload title from web -->
            <?php echo  heading('insira o endere&#231;o da web:', 3) ?>

            <!-- image from web -->
            <div class="inpt-out">
              <input id="ambiance-image-url" type="text" class="search-area" placeholder="http://sitedaimage.com.br/nome-da-image.jpg">
              <input id="ambiance-save-image-url" type="button" value="OK" class="submit-btn">
            </div>

            <!-- aditional informations -->
            <ul class="long-forms">

              <!-- title -->
              <li>
                <div class="legend">T&#237;tulo:</div>
                <input id="ambiance-title" type="text" class="search-area">
              </li>

              <!-- categories -->
              <li>

                <div class="legend">Categoria:</div>

                <div class="report-box">
                  <select id="ambiance-category-main" class="ambiance-styled">
                  </select>
                </div>

              </li> <!-- /categories -->

              <!-- submit + add products -->
              <li>
                <!-- submit ambiance -->
                <button id="ambiance-save" type="submit" class="button float-r">publicar</button>

                <!-- add products to this ambiance -->
                <button type="button" id="add-products-btn" class="button button-gray float-r">
                  anexar produtos
                </button>

                <p class="ambiance-terms">
                  Clicando em PUBLICAR, voc&#234; estar&#225; concordando <br> com os <?php echo  anchor('institucional/termos-e-condicoes', 'termos do site', 'target="_blank"') ?> e com nossa pol&#237;tica de <?php echo  anchor('institucional/condicoes-de-upload#direitos-autorais', 'direito de imagem', 'target="_blank"') ?>
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

          <div id="ambiance-slider-search" class="horizontal-slider-container">

            <!-- content -->
            <div id="search-result" class="horizontal-slider-content">
              <ul class="horizontal-slider add-ambiance">
                &nbsp;
              </ul>
            </div>

            <!-- arrows -->
            <div class="arrows">

              <!-- left arrow -->
              <a href="#" class="previous">&nbsp;</a>

              <!-- right arrow -->
              <a href="#" class="next">&nbsp;</a>

            </div>

          </div>

        </section> <!-- /search result -->

        <!-- added products title -->
        <h2 class="pop-title">produtos anexados</h2>

        <!-- added products title -->
        <section class="slider">

          <div id="ambiance-slider-attached" class="horizontal-slider-container">

            <!-- content -->
            <div id="ambiance-attached-products" class="horizontal-slider-content">
              <ul id="products-added" class="horizontal-slider add-ambiance">&nbsp;</ul>
            </div>

            <!-- arrows -->
            <div class="arrows">

              <!-- left arrow -->
              <a href="#" class="previous">&nbsp;</a>

              <!-- right arrow -->
              <a href="#" class="next">&nbsp;</a>

            </div> <!-- /arrows -->

          </div>

        </section> <!-- /added products title -->

      </div> <!-- /add products -->

    </section>
<?php echo  form_close() ?>
