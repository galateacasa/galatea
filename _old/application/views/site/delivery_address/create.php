<div class="container">
  <h3>Endereço de Entrega</h3>
  <form class="form-horizontal" action="" method="POST">
    <div class="control-group">
      <label class="control-label" for="street">Endereço</label>
      <div class="controls">
        <input type="text" id="street" name="street" value="<?php echo  set_value('street'); ?>">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="number">Número</label>
      <div class="controls">
        <input type="text" id="number" name="number" value="<?php echo  set_value('number'); ?>">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="complement">Complemento</label>
      <div class="controls">
        <input type="text" id="complement" name="complement" value="<?php echo  set_value('complement'); ?>">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="district">Bairro</label>
      <div class="controls">
        <input type="text" id="district" name="district" value="<?php echo  set_value('district'); ?>">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="zip">CEP</label>
      <div class="controls">
        <input type="text" id="zip" name="zip" value="<?php echo  set_value('zip'); ?>">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="state">Estado</label>
      <div class="controls">
        <select name="state" id="state"></select>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="city">Cidade</label>
      <div class="controls">
        <select name="city" id="city"></select>
      </div>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
  </form>
