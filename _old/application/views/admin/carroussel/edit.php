<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Editar imagem de carroussel</h2>
    </div>
    <div class="box-content">
      <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
        <fieldset>
          <legend><?php echo  $carroussel->title ?></legend>
          <div class="control-group">
            <label class="control-label" for="title"> Título </label>
            <div class="controls">
              <input type="text" name="title" id="title" value="<?php echo  set_value('title', $carroussel->title); ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="description"> Descrição </label>
            <div class="controls">
              <textarea name="description" id="description" ><?php echo  set_value('description', $carroussel->description); ?></textarea>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="link"> Link </label>
            <div class="controls">
              <input type="text" name="link" id="link" value="<?php echo  set_value('link', $carroussel->link); ?>">
            </div>
          </div>
        </fieldset>
        <div class="control-group">
          <?
          $toview = array(
            'maxUploads' => 1,
            'path' => 'images/carroussels',
            'image_insert' => array($carroussel->image)
            );
          $this->load->view('templates/upload_image', $toview);
          ?>
        </div>
        <div class="form-actions">
          <button class="btn btn-primary" type="submit">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>
