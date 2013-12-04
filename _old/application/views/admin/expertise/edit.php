<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Editar expertise</h2>
    </div>
    <div class="box-content">
      <form action="" class="form-horizontal" method="post">
        <fieldset>
          <legend><?php echo  $expertise->name?></legend>
          <form class="form-inline" method="post">
            <div class="control-group">
              <label class="control-label" for="name"> Nome </label>
              <div class="controls">
                <input type="text" name="name" id="name" placeholder="Nome" value="<?php echo  set_value('name', $expertise->name) ?>" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="description"> Descrição </label>
              <div class="controls">
                <textarea name="description" id="description" ><?php echo  set_value('description', $expertise->description) ?></textarea>
              </div>
            </div>
            <div class="form-actions">
              <button class="btn btn-primary" type="submit">Salvar</button>
            </div>
          </form>
        </fieldset>
      </form>
    </div>
  </div>
</div>
