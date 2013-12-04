<?php echo  form_open_multipart( current_url() ) ?>

  <section class="container_12">

    <!-- breadcrumbs + mannual + project name -->
    <section class="grid_12">

      <?php echo  $breadcrumbs /* Add breadcrumbs */ ?>

      <!-- project name -->
      <div class="error-msg extra-btm-space no-pad no-border">

        <!-- title -->
        <h2>inscrição de projetos<a href="#" class="read-more">leia o Manual de Boas Práticas</a></h2>

        <!-- project name -->
        <span class="block">
          <input
            type="text"
            name="name"
            class="search-area no-bg custom-textbox float-l"
            placeholder="Nome do projeto"
            value="<?php echo  set_value('name', @$item->name) ?>"
            maxlenght = "40"
          >
        </span> <!-- /project name -->

      </div> <!-- /project name -->

    </section> <!-- /breadcrumbs + mannual + project name -->

  </section>

  <!-- imagens -->
  <section class="container_12">

    <!-- title -->
    <h4 class="grid_7" style="width: 490px; float:left; padding-top: 17px;">
      Selecione no seu computador uma imagem com até <strong>com até 2mb  (gif, tiff ou jpeg)</strong> <br>Tamanho recomendado: 940 x 420 pixels
    </h4>
    <div class="file-submit file-upload-inline" style="width: 440px; margin-bottom: 0">
      <input type="file" name="file" id="principal_img" class="file-upload-styled" />
    </div>

    <!-- drop area -->
    <div id="upload-response" class="grid_12">
      <div id="dropbox_principal" class="frame" >
        ou arraste aqui a imagem principal
      </div>
      <div id="result_box_principal" class="frame" ></div>
    </div> <!-- /drop area -->

    <h4 class="grid_7" style="width: 500px; float:left; padding-top: 20px; margin-top: 17px;">
      Selecione no seu computador as imagens secundárias do projeto <br/>com até <strong>com até 2mb  (gif, tiff ou jpeg)</strong>>Tamanho recomendado: 940 x 420 pixels
    </h4>
    <div class="file-submit file-upload-inline" style="width: 430px; margin-bottom: 0; margin-top: 30px;">
      <input type="file" name="secondary_file" id="secondary_img" class="file-upload-styled" />
    </div>

    <!-- drop area -->
    <div class="grid_12">
      <div id="dropbox_secondary" class="frame" >
        ou arraste aqui as imagens secundárias
      </div>
    </div> <!-- /drop area -->

    <div class="grid_12">
      <ul id="thumbnails">
      </ul>
    </div>

  </section> <!-- /imagens -->

  <!-- about the project + designer information + technical information -->
  <section class="container_12">

    <!-- categories + description -->
    <section class="grid_6">

      <!-- title -->
      <h2>Sobre o projeto</h2>

      <!-- categories -->
      <section class="grid_4 alpha">

        <!-- main category -->
        <div class="report-box custom-select">
          <label for="main_category">Categoria</label>
          <select name="main_category" id="main-category" class="styled category_select">
          </select>
        </div> <!-- /main category -->

        <!-- sub-category -->
        <div class="report-box custom-select">
          <label for="sub_category">Sub-Categoria</label>
          <select name="sub_category" id="sub-category" class="styled category_select">
          </select>
        </div> <!-- /sub-category -->

      </section> <!-- /categories -->

      <!-- description -->
      <span class="block">
        <div class="msg-box">
          <textarea name="description" id="" cols="40" rows="5" placeholder="Digite algumas palavras sobre o projeto" class='msg' ><?php echo set_value('description', $item->description)?></textarea>
        </div>
      </span> <!-- /description -->

    </section> <!-- /categories + description -->

    <section class="grid_6 omega alpha" id="info-block">

      <!-- título -->
      <h2 class="extra-btm-space">Informações técnicas</h2>

      <!-- medidas -->
      <div class="info-area grid_6 omega alpha extra-btm-space">

        <?php for($i = 0; $i < count($measurements['height']); $i++): /* List all measures */ ?>

            <div id="measure">

              <!-- label -->
              <span>Medidas(cm)</span>

              <ul>

                <!-- height -->
                <li class="pi-info">
                  <label class="first">Altura</label>
                  <input
                    type="text"
                    name="<?php echo  'measurements[height][]' ?>"
                    class="search-area no-bg custom-textbox float-l"
                    value="<?php echo  $measurements['height'][$i] ?>"
                    placeholder="cm"
                  >
                </li> <!-- /height -->

                <!-- width -->
                <li class="pi-info">
                  <label>Largura</label>
                  <input
                    type="text"
                    name="<?php echo  'measurements[width][]' ?>"
                    class="search-area no-bg custom-textbox float-l"
                    value="<?php echo  $measurements['width'][$i] ?>"
                    placeholder="cm"
                  >
                </li> <!-- /width -->

                <!-- depth -->
                <li class="pi-info">
                  <label>Profundidade</label>
                  <input
                    type="text"
                    type="text"
                    name="<?php echo  'measurements[depth][]' ?>"
                    class="search-area no-bg custom-textbox float-l"
                    value="<?php echo  $measurements['depth'][$i] ?>"
                    placeholder="cm"
                  >
                </li> <!-- /depth -->

              </ul>
            </div>

        <?php endfor ?>

        <!-- add more -->
        <a href="javascript:void(0)" data-add="#measure" class="add-more link-btn blue float-r">
          + adicione nova medida
        </a>

      </div> <!-- /medidas -->

      <!-- acabamento -->
      <div class="info-area grid_6 omega alpha extra-btm-space">

        <?php foreach( $materials as $material ): /* List all materials */ ?>

            <!-- entrada de dados -->
            <div id="material" >
              <?php echo  form_label('Acabamento') ?>
              <input
                name="<?php echo  "materials[]" ?>"
                type="text"
                placeholder="Nome de um material utilizado no projeto"
                class="search-area v-large no-bg custom-textbox float-l"
                value="<?php echo  $material ?>"
              >
            </div> <!-- /entrada de dados -->

        <?php endforeach; ?>

        <!-- add more -->
        <a data-add="#material" class="add-more link-btn blue float-r" href="javascript:void(0)">
          + adicione novo acabamento
        </a>

      </div> <!-- /acabamento -->


    </section>

  </section> <!-- /about the project + designer information + technical information -->

  <section class="container_12">

    <section class="grid_7 float-r accept-terms" style="margin-bottom: 50px;">

      <!-- terms and image rights -->
      <!--
      <section class="grid_4 terms-con alpha">
        Clicando em ATUALIZAR, você estará concordando com os <a href="#">Termos do site</a> e com nossa política de <a href="#">Direito de Imagem</a>
      </section>
      -->

      <!-- submit buttons -->
      <section class="grid_7 omega">
      <!-- <section class="grid_3 omega"> -->
        <button class="link-btn blue float-r" style="margin:0px 20px 0px 7px; padding: 7px 20px;" type="submit">ATUALIZAR</button>
        <?php echo  anchor( base_url('site/items/show/' . $item->id), 'CANCELAR', 'class="link-btn grey float-r" style="padding: 8px 20px;"') ?>
      </section>

    </section>

  </section>

<?php echo  form_close() ?>
