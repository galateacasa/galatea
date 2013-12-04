<script>
  $(function(){
    //STATE AND CITY
    set_combo_state('<?php echo  $delivery_address->state_id ?>');
<?php if (!empty($delivery_address->city_id)) { ?>
      set_combo_city('<?php echo  $delivery_address->city_id ?>', '<?php echo  $delivery_address->state_id ?>');
<?php } ?>

  });
</script>
<div class="container">
  <h3>Endereço de Entrega</h3>
  <form class="form-horizontal" action="" method="POST">
    <div class="control-group">
      <label class="control-label" for="street">Endereço</label>
      <div class="controls">
        <input type="text" id="street" name="street" value="<?php echo  set_value('street', $delivery_address->street); ?>">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="number">Número</label>
      <div class="controls">
        <input type="text" id="number" name="number" value="<?php echo  set_value('number', $delivery_address->number); ?>">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="complement">Complemento</label>
      <div class="controls">
        <input type="text" id="complement" name="complement" value="<?php echo  set_value('complement', $delivery_address->complement); ?>">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="district">Bairro</label>
      <div class="controls">
        <input type="text" id="district" name="district" value="<?php echo  set_value('district', $delivery_address->district); ?>">
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="zip">CEP</label>
      <div class="controls">
        <input type="text" id="zip" name="zip" value="<?php echo  set_value('zip', $delivery_address->zip); ?>">
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
