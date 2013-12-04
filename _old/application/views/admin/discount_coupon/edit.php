<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Editar cupom de desconto</h2>
    </div>
    <div class="box-content">
      <form action="" class="form-horizontal" method="post">
        <fieldset>
          <legend><?php echo  $discount_coupon->hash ?></legend>
          <div class="control-group">
            <label class="control-label" for="type"> Tipo de desconto </label>
            <div class="controls">
              <select name="type" id="type">
                <option value="1" <?php echo $discount_coupon->type == 1 ? "selected" : ""?>>Valor</option>
                <option value="2" <?php echo $discount_coupon->type == 2 ? "selected" : ""?>>Porcentagem</option>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="value"> Valor </label>
            <div class="controls">
              <input type="text" name="value" id="vaue" value="<?php echo  set_value('value', $discount_coupon->value); ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="max_utilizations"> Utilizações máximas </label>
            <div class="controls">
              <input type="text" name="max_utilizations" id="max_utilizations" value="<?php echo  set_value('max_utilizations', $discount_coupon->max_utilizations); ?>">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="min_sell_value"> Valor mínimo da compra </label>
            <div class="controls">
              <input type="text" name="min_sell_value" id="min_sell_value" value="<?php echo  set_value('min_sell_value', $discount_coupon->min_sell_value); ?>">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="date"> Validade </label>
            <div class="controls">
              <input type="text" class="input-medium datepicker" placeholder="Data Início" id="start_date" name="start_date" value="<?php echo  set_value('start_date', $discount_coupon->start_date) ?>" />
            <input type="text" class="input-medium datepicker" placeholder="Data Fim" id="end_date" name="end_date" value="<?php echo  set_value('end_date', $discount_coupon->end_date) ?>" />
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="description">Descrição</label>
            <div class="controls">
              <textarea  id="description"  name="description"><?php echo  set_value('description', $discount_coupon->description); ?></textarea>
            </div>
          </div>

          <div class="form-actions">
            <button class="btn btn-primary" type="submit">Salvar</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>
