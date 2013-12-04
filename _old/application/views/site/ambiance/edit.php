<section id="ambiance-edit">

  <?php echo  $breadcrumbs ?>

  <div class="grid_12">
    <h1>Edição de ambientes</h1>
  </div>

  <?php echo  form_open( current_url() ) ?>
    <fieldset>

      <!-- image -->
      <div class="grid_6">

        <!-- title -->
        <h3>Exclua a imagem abaixo clicando-a e arraste uma nova para o mesmo quadrado.</h3>

        <!-- drop area -->
        <span id="ambiance_dropbox" class="ambiance_dropbox">
          <?php echo  img( amazon_url("images/ambiances/{$ambiance->image}", 460, 240) ) ?>
          <?php echo  form_hidden('image', $ambiance->image) ?>
        </span> <!-- /drop area -->

      </div> <!-- /image -->

      <!-- inputs -->
      <div class="grid_6" role="fields">

        <!-- title -->
        <div>
          <?php echo  form_label('Título', 'title') ?>
          <?php echo  form_input( 'title', set_value('title', $ambiance->title) ) ?>
        </div>

        <!-- category -->
        <div>
          <?php echo  form_label('Categoria', 'main_category') ?>
          <select name="main_category" id="main-category">
          </select>
        </div>

        <!-- sub-category -->
        <div>
          <?php echo  form_label('Sub-Categoria', 'sub_category') ?>
          <select name="sub_category" id="sub-category">
          </select>
        </div>

        <?php echo  form_submit('save', 'Salvar'); ?>

      </div> <!-- /inputs -->

    </fieldset>
  <?php echo  form_close() ?>

</section>
