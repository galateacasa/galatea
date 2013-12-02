<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Editar layout da Home</h2>
    </div>
    <div class="box-content">
      <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
        <fieldset>
          <legend>Editar layout da Home</legend>
          <div class="control-group">
            <label class="control-label" for="name"> Nome </label>
            <div class="controls">
              <input type="text" name="name" id="name" value="<?php echo  $home_layout->name; ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="description"> Ambiente </label>
            <div class="controls">
              <select name="ambiance" id="ambiance">
                <option value="">Selecione uma opção</option>
              <?php foreach ($ambiances as $ambiance) { ?>
                <option value="<?php echo  $ambiance->id; ?>" <?php echo  ($ambiance->id == $home_layout->ambiance->id) ? "selected" : "" ?> ><?php echo  $ambiance->title; ?></option>
              <?php } ?>
              </select>
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="style">Produto 1</label>
            <div class="controls">
              <select name="products[]">
                <option value="">Selecione uma opção</option>
              <?
              $checked_products = array();
              $current = FALSE;
              foreach ($products as $product) {
              ?>
                <option value="<?php echo  $product->id; ?>"
                  <?
                    if (in_array($product->id, $current_products) && !in_array($product->id, $checked_products) && $current == FALSE) {
                    echo "selected";
                    $checked_products[] = $product->id;
                    $current = TRUE;
                  } ?>
                  ><?php echo  $product->name; ?></option>
              <?php }
              $current = FALSE;
              ?>
              </select>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="style">Produto 2</label>
            <div class="controls">
              <select name="products[]">
                <option value="">Selecione uma opção</option>
              <?php foreach ($products as $product) { ?>
                <option value="<?php echo  $product->id; ?>"
                  <?
                    if (in_array($product->id, $current_products) && !in_array($product->id, $checked_products) && $current == FALSE) {
                    echo "selected";
                    $checked_products[] = $product->id;
                    $current = TRUE;
                  } ?>
                  ><?php echo  $product->name; ?></option>
              <?php }
              $current = FALSE; ?>
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
