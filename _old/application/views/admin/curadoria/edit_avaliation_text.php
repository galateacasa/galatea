<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Editar texto de avaliação</h2>
    </div>
    <div class="box-content">
      <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
        <fieldset>
          <legend><?php echo $avaliation_text->avaliation?></legend>
          <div class="control-group">
            <label class="control-label" for="avaliation"> Avaliação </label>
            <div class="controls">
              <input type="text" name="avaliation" id="avaliation" value="<?php echo $avaliation_text->avaliation?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="text"> Texto </label>
            <div class="controls">
              <textarea name="text" id="text"><?php echo $avaliation_text->text?></textarea>
            </div>
          </div>
        </fieldset>
        <div class="form-actions">
          <button class="btn btn-primary" type="submit">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>
