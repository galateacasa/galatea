<script type="text/javascript">
$(document).ready(function(){
  set_combo_user('<?php echo  $ambiance->user_id ?>');
  set_combo_item(false);

  <?
  if(!empty($ambiance->category->parent_id)){
    ?>
    set_combo_category('<?php echo $ambiance->category->parent_id?>');
    set_combo_sub_category('<?php echo $ambiance->category_id?>', '<?php echo $ambiance->category->parent_id?>');
    <?
  }else{
    ?>
    set_combo_category('<?php echo $ambiance->category_id?>');
    <?
  }
  ?>

  $('#category').change(function(){
    set_combo_sub_category(false, $(this).val());
  });

});
</script>
<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Editar ambiente</h2>
    </div>
    <div class="box-content">
      <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
        <fieldset>
          <legend><?php echo  $ambiance->name ?></legend>
          <div class="control-group">
            <label class="control-label" for="name"> Nome </label>
            <div class="controls">
              <input type="text" name="name" id="name" value="<?php echo  set_value('name', $ambiance->name); ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="description"> Descrição </label>
            <div class="controls">
              <textarea name="description" id="description"><?php echo  set_value('description', $ambiance->description); ?></textarea>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="user"> Criado por </label>
            <div class="controls">
              <select name="user" id="user"></select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="style">Categoria</label>
            <div class="controls">
              <select name="category" id="category"></select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="style">Sub-categoria</label>
            <div class="controls">
              <select name="sub_category" id="sub_category"></select>
            </div>
          </div>
        </fieldset>
        <div class="control-group">
          <?
          $toview = array(
            'maxUploads' => 1,
            'path' => 'images/ambiances',
            'image_insert' => array($ambiance->image)
            );
          $this->load->view('templates/upload_image', $toview);
          ?>
        </div>
        <div class="form-actions">
          <button class="btn btn-primary" type="submit">Salvar</button>
        </div>
      </form>
      <form action="" class="form-horizontal" method="post">
        <fieldset>
          <legend>Projetos relacionados</legend>
          <form class="form-inline" method="post">
            <select name="item" id="item"></select>
            <input type="hidden" name="ambiance_id" value="<?php echo $ambiance->id?>">
            <input type="submit" class="btn btn-primary" value="Adicionar">
          </form>
        </fieldset>
      </form>
      <fieldset>
        <table class="table table-striped table-bordered bootstrap-datatable datatable">
          <thead>
            <tr>
              <th>Id</th>
              <th>Imagem</th>
              <th>Projeto</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?
            foreach ($ambiance->item->get() as $key => $ambiance_item) {
              ?>
              <td><?php echo $ambiance_item->item->id?></td>
              <td>
                <?
                if (!empty($ambiance_item->item->item_image->get()->image)) {
                  $path = amazon_url('images/items/'.$ambiance_item->item->item_image->get()->image);
                  ?>
                  <img src="<?php echo $path?>" width="100" height="100" alt="<?php echo $ambiance_item->item->name?>">
                  <?
                }
                ?>
              </td>
              <td><?php echo $ambiance_item->item->name?></td>
              <td>
                <div class="btn-group">
                  <a class="btn btn-danger btn-mini delete" onclick="return confirm('Tem Certeza?')" href="<?php echo site_url('admin/ambiances/delete/'.$item_ambiance->id)?>">Excluir</a>
                </div>
              </td>
              <?
            }
            ?>
          </tbody>
        </table>
      </fieldset>


    </div>
  </div>
</div>
