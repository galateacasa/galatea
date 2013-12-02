<?php echo  form_open( current_url(), array('id' => 'frm_create_project') ) ?>

  <section class="container_12">

    <!-- breadcrumbs + mannual + project name -->
    <section class="grid_12">

      <?php echo  $breadcrumbs /* Add breadcrumbs */ ?>

      <!-- project name -->
      <div>

        <!-- title -->
        <h2>
            inscrição de projetos<a href="<?php echo  base_url('institucional/manual-de-boas-praticas') ?>" class="read-more" target="_blank">leia o manual de boas práticas</a>
        </h2>

        <!-- project name -->
        <span class="block">
          <?php echo  form_input('name', set_value('name'), 'class="search-area no-bg custom-textbox float-l" placeholder="Nome do projeto" maxlength=40') ?>
        </span> <!-- /project name -->

      </div> <!-- /project name -->

    </section> <!-- /breadcrumbs + mannual + project name -->

  </section>

    <!-- images -->
    <section class="container_12">

        <?php $container_text = "Selecione no seu computador uma imagem <strong>com até 2mb  (gif, tiff ou jpeg)</strong> <br>Tamanho recomendado: 940 x 420 pixels" . br(2) ?>

        <!-- title -->
        <h4 class="grid_12">
            <?php echo  $container_text ?>
        </h4>

        <!-- Upload image select button -->
        <div class="grid_12">
            <input type="file" name="file" id="principal_img" class="file-upload-styled">
        </div>

        <!-- drop area -->
        <div id="upload-response" class="grid_12">
            <div id="dropbox_principal" class="frame" >ou arraste aqui a imagem principal</div>
            <div id="result_box_principal" class="frame" style="height: 110px;"></div>
        </div> <!-- /drop area -->

        <h4 class="grid_12">
            <?php echo  $container_text ?>
        </h4>

        <!-- Upload image select button -->
        <div class="grid_12">
            <input type="file" name="secondary_file" id="secondary_img" class="file-upload-styled">
        </div>

        <!-- drop area -->
        <div class="grid_12">
            <div id="dropbox_secondary" class="frame">
            ou arraste aqui as imagens secundárias
            </div>
        </div> <!-- /drop area -->

        <div class="grid_12">
            <ul id="thumbnails"></ul>
        </div>

    </section> <!-- /imagens -->

    <!-- about the project + designer information + technical information -->
    <section class="container_12">

        <!-- categories + description -->
        <section class="grid_6">

            <!-- title -->
            <?php echo  heading('Sobre o projeto', 2) ?>

            <!-- categories -->
            <section class="grid_4 alpha">
                <div class="legend">Categoria:</div>
                <div class="category-select-box">
                    <select id="project-categories" class="styled" name="category"></select>
                </div>
            </section> <!-- /categories -->

            <!-- description -->
            <span class="block">
                <div class="msg-box">
                    <textarea name="description" id="" cols="40" rows="5" placeholder="Digite algumas palavras sobre o projeto" class='msg' ><?php echo  set_value('description') ?></textarea>
                </div>
            </span> <!-- /description -->

        </section> <!-- /categories + description -->

    <section class="grid_6 omega alpha" id="info-block">

      <!-- título -->
      <?php echo  heading('Informações técnicas', 2) ?>

      <!-- medidas -->
      <div class="info-area grid_6 omega alpha extra-btm-space">

        <div id="measure">
          <!-- label -->
          <span>Medidas</span>

          <ul>

            <!-- altura -->
            <li class="pi-info">
              <label class="first">Altura</label>
              <input
                type="text"
                name="measurements[height][]"
                class="search-area no-bg custom-textbox float-l"
                value="<?php echo  set_value('measurements[height][]') ?>"
                placeholder="cm"
              >
            </li> <!-- /altura -->

            <!-- largura -->
            <li class="pi-info">
              <label>Largura</label>
              <input
                type="text"
                name="measurements[width][]"
                class="search-area no-bg custom-textbox float-l"
                value="<?php echo  set_value('measurements[width][]') ?>"
                placeholder="cm"
              >
            </li> <!-- /largura -->

            <!-- profundidade -->
            <li class="pi-info">
              <label>Profundidade</label>
              <input
                type="text"
                name="measurements[depth][]"
                class="search-area no-bg custom-textbox float-l"
                value="<?php echo  set_value('measurements[depth][]') ?>"
                placeholder="cm"
              >
            </li> <!-- /profundidade -->

          </ul>
        </div>

        <!-- add more -->
        <a data-add="#measure" class="add-more link-btn blue float-r" href="javascript:void(0)">+ adicione nova medida</a>

      </div> <!-- /medidas -->

      <!-- acabamento -->
      <div class="info-area grid_6 omega alpha extra-btm-space">

        <div id="material" >
          <label>Acabamento</label>
          <input
            name="materials[]"
            type="text"
            placeholder="Escreva os materiais utilizados no projeto"
            class="search-area v-large no-bg custom-textbox float-l"
            input="<?php echo  set_value('materials[]') ?>"
          >
        </div>

        <!-- add more -->
        <a data-add="#material" class="add-more link-btn blue float-r" href="javascript:void(0)">
            + adicione novo acabamento
        </a>

      </div> <!-- /acabamento -->

    </section>

  </section> <!-- /about the project + designer information + technical information -->

  <section class="container_12">

    <!-- terms and image right -->
    <div class="prefix_7 grid_4 terms-con" style="position: relative; right: 40px;">
      <br>
      Clicando em PUBLICAR, você estará concordando <br> com os <?php echo  anchor('institucional/termos-e-condicoes', 'termos do site', 'target="_blank"') ?> e com nossa política de <?php echo  anchor('institucional/termos-e-condicoes#privacidade', 'direito de imagem', 'target="_blank"') ?>
    </div>

    <!-- submit buttons -->
    <div class="grid_1">
      <button class="button" type="submit" style="position: relative; right: 50px;">PUBLICAR</button>
    </div>

  </section>

<?php echo  form_close() ?>
