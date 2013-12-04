<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Editar item sugerido</h2>
    </div>
    <div class="box-content">
      <form action="" class="form-horizontal" method="post">
        <fieldset>
          <legend><?php echo  $suggested_item->name ?> - <?php echo  $suggested_item->user->name ?></legend>
          <div class="span6">
            <div class="control-group">
              <label class="control-label" for="name"> Nome </label>
              <div class="controls">
                <input type="text" name="name" id="name" value="<?php echo  set_value('name', $suggested_item->name); ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="description">Descriçao</label>
              <div class="controls">
                <textarea type="description" id="description"  name="description"><?php echo  set_value('description', $suggested_item->description); ?></textarea>
              </div>
            </div>

          </div>
          <div class="span4" style="text-align:center;">
            <?
            $images = array();
            foreach($suggested_item->suggested_item_image->get() as $img){
              $images[] = $img->image;
            }
            $toview = array(
              'maxUploads' => 5,
              'path' => 'images/suggested_items',
              'image_insert' => $images
              );
            $this->load->view('templates/upload_image', $toview);
            ?>
          </fieldset>

        </div>

        <div class="form-actions">
          <button class="btn btn-primary" type="submit">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>
