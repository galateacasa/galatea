<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Criar ambiente</h2>
    </div>
    <div class="box-content">
      <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
        <fieldset>
          <legend>Criar ambiente</legend>
          <div class="control-group">
            <label class="control-label" for="name"> Nome </label>
            <div class="controls">
              <input type="text" name="name" id="name" value="">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="description"> Descrição </label>
            <div class="controls">
              <textarea name="description" id="description"></textarea>
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
            'image_insert' => array()
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
