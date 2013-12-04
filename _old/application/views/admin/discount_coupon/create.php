<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Criar cupom de desconto</h2>
    </div>
    <div class="box-content">
      <form action="" class="form-horizontal" method="post">
        <fieldset>
          <legend>Criar Cupom de desconto</legend>

          <div class="control-group">
            <label class="control-label" for="hash"> Código </label>
            <div class="controls">
              <input type="text" name="hash" id="hash" value="<?php echo  set_value('hash'); ?>">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="type"> Tipo de desconto </label>
            <div class="controls">
              <select name="type" id="type">
                <option value="1">Valor</option>
                <option value="2">Porcentagem</option>
              </select>
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="value"> Valor </label>
            <div class="controls">
              <input type="text" name="value" id="value" value="<?php echo  set_value('value'); ?>">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="max_utilizations"> Utilizações máximas </label>
            <div class="controls">
              <input type="text" name="max_utilizations" id="max_utilizations" value="<?php echo  set_value('max_utilizations'); ?>">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="min_sell_value"> Valor mínimo da compra </label>
            <div class="controls">
              <input type="text" name="min_sell_value" id="min_sell_value" value="<?php echo  set_value('min_sell_value'); ?>">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="date"> Validade </label>
            <div class="controls">
              <input type="text" class="input-medium datepicker" placeholder="Data Início" id="start_date" name="start_date" value="" />
            <input type="text" class="input-medium datepicker" placeholder="Data Fim" id="end_date" name="end_date" value="" />
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="description">Descrição</label>
            <div class="controls">
              <textarea  id="description"  name="description"><?php echo  set_value('description'); ?></textarea>
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
