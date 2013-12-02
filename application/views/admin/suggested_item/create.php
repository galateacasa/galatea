<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Criar item sugerido</h2>
    </div>
    <div class="box-content">
      <form action="" class="form-horizontal" method="post">
        <fieldset>
          <legend>Criar item sugerido</legend>
          <div class="span6">
            <div class="control-group">
              <label class="control-label" for="name"> Nome </label>
              <div class="controls">
                <input type="text" name="name" id="name" value="<?php echo  set_value('name'); ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="description">Descriçao</label>
              <div class="controls">
                <textarea type="description" id="description"  name="description"><?php echo  set_value('description'); ?></textarea>
              </div>
            </div>

          </div>
          <div class="span4" style="text-align:center;">
            <?
            $images = array();
            $toview = array(
              'maxUploads' => 5,
              'path' => 'images/suggested_items',
              'image_insert' => $images
              );
            $this->load->view('templates/upload_image', $toview);
            ?>
          </div>
        </fieldset>

      </div>

      <div class="form-actions">
        <button class="btn btn-primary" type="submit">Salvar</button>
      </div>
    </form>
  </div>
</div>
</div>
