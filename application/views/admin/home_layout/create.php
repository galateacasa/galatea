<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Criar layout da Home</h2>
    </div>
    <div class="box-content">
      <form action="" class="form-horizontal" method="post" >
        <fieldset>
          <legend>Criar layout da Home</legend>
          <div class="control-group">
            <label class="control-label" for="name"> Nome </label>
            <div class="controls">
              <input type="text" name="name" id="name" value="">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="description"> Ambiente </label>
            <div class="controls">
              <select name="ambiance" id="ambiance">
                <option value="">Selecione uma opção</option>
              <?php foreach ($ambiances as $ambiance) { ?>
                <option value="<?php echo  $ambiance->id; ?>" ><?php echo  $ambiance->title; ?></option>
              <?php } ?>
              </select>
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="style">Produto 1</label>
            <div class="controls">
              <select name="products[]">
                <option value="">Selecione uma opção</option>
              <?php foreach ($products as $product) { ?>
                <option value="<?php echo  $product->id; ?>" ><?php echo  $product->name; ?></option>
              <?php } ?>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="style">Produto 2</label>
            <div class="controls">
              <select name="products[]">
                <option value="">Selecione uma opção</option>
              <?php foreach ($products as $product) { ?>
                <option value="<?php echo  $product->id; ?>" ><?php echo  $product->name; ?></option>
              <?php } ?>
              </select>
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
