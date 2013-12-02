<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Criar região</h2>
    </div>
    <div class="box-content">
      <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
        <fieldset>
          <legend>Criar região</legend>
          <div class="control-group">
            <label class="control-label" for="name"> Nome </label>
            <div class="controls">
              <input type="text" name="name" id="name" value="<?php echo  set_value('name') ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="role"> Estados </label>
            <div class="controls">
              <select name="states[]" id="state" multiple="multiple"></select>
            </div>
          </div>
          <div class="form-actions">
            <button class="btn btn-primary" type="submit">Salvar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
