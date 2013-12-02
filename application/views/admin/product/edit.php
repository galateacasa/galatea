<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Editar produto</h2>
    </div>
    <div class="box-content">
      <form action="" id="frm-edit-product" class="form-horizontal" method="post">
        <fieldset>
          <legend><?php echo  $product->name ?> - <?php echo  $product->user->name ?></legend>
          <div class="span6">
            <div class="control-group">
              <label class="control-label" for="name"> Nome </label>
              <div class="controls">
                <input type="text" name="name" id="name" value="<?php echo  set_value('name', $product->name); ?>">
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
            <div class="control-group">
              <label><legend>Quem faz</legend> <span id="variation_label"></span></label>
              <label class="control-label" for="name">Designer: </label>
              <div class="controls">
                <select name="designer" id="designer">
                    <option value="0">Ninguém</option>
                    <?php foreach($designers as $designer) { ?>
                    <option value="<?php echo  $designer->id ?>" <?php if ($designer->id == $product->user_id) { echo 'selected'; } ?>><?php echo  $designer->name ?></option>
                    <?php } ?>
                </select>
              </div>
            </div>
            <div id="suppliers" >
              <div id="suppliers_template">
                <?php foreach($suppliers as $current_supplier) { ?>
                <div class="control-group">
                  <label class="control-label" for="name">Fornecedor: </label>
                  <div class="controls">
                      <select name="supplier[id][<?php echo  $current_supplier->id; ?>]" id="supplier[id][<?php echo  $current_supplier->id; ?>]">
                        <option value="0">Ninguém</option>
                        <?php foreach($all_suppliers as $supplier) { ?>
                        <option value="<?php echo  $supplier->id ?>" <?php if ($supplier->id == $current_supplier->user_id) { echo 'selected'; } ?>><?php echo  $supplier->name ?></option>
                        <?php } ?>
                      </select>
                  </div>
                  <label class="control-label" for="name">Capacidade Mensal: </label>
                  <div class="controls">
                    <input type="text" name="supplier[production_amount][<?php echo  $current_supplier->id; ?>]" id="supplier[production_amount][<?php echo  $current_supplier->id; ?>]" value="<?php echo  set_value('name', $current_supplier->production_amount) ?>">
                    <a class="btn btn-mini suppliers_remove_current"><ico class="icon-minus-sign"></ico></a>
                  </div>
                </div>
                <?php } ?>
                <div class="control-group suppliers_default">
                  <label class="control-label" for="name">Fornecedor: </label>
                  <div class="controls">
                      <select name="supplier[id][]" id="supplier[id][]">
                        <option value="0">Ninguém</option>
                        <?php foreach($all_suppliers as $supplier) { ?>
                        <option value="<?php echo  $supplier->id ?>" ><?php echo  $supplier->name ?></option>
                        <?php } ?>
                      </select>
                  </div>
                  <label class="control-label" for="name">Capacidade Mensal: </label>
                  <div class="controls">
                    <input type="text" name="supplier[production_amount][]" id="supplier[production_amount][]">
                    <a class="btn btn-mini suppliers_remove_current"><ico class="icon-minus-sign"></ico></a>
                  </div>
                </div>
              </div><!-- Suppliers Template End -->
              <div id="suppliers_controls" class="controls">
                <div class="control-group">
                  <div id="suppliers_add" ><a id="suppliers_add" class="btn btn-mini"><ico class="icon-plus-sign"></ico>&nbsp;Fornecedor</a></div>
                </div>
              </div><!-- Suppliers Controls End -->
            </div><!-- Suppliers End -->
            <div class="control-group">
              <label class="control-label" for="delivery_cost">Frete: </label>
              <div class="controls">
                <input type="text" name="delivery_cost" id="delivery_cost" class="decimal" value="<?php echo  set_value('name', $product->delivery_cost) ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="delivery_time">Prazo de entrega: </label>
              <div class="controls">
                <input type="text" name="delivery_time" id="delivery_time" value="<?php echo  set_value('name', $product->delivery_time) ?>">
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="name">Status: </label>
              <div class="controls">
                <select name="status" id="status">
                  <?php
                  foreach($statuses as $status => $value) {
                    ?>
                    <option value="<?php echo $value?>" <?php if ($value == $product->status) { echo 'selected'; } ?>><?php echo $status?></option>
                    <?php
                  }
                  ?>
                <select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="description">Descriçao</label>
              <div class="controls">
                <textarea type="description" id="description" cols="40" rows="10" name="description"><?php echo  set_value('description', $product->description); ?></textarea>
              </div>
            </div>

            <!-- Materials Start -->
            <div id="materials">
              <!-- Form template-->
              <div id="materials_template">
                <label><legend>Materiais:</legend> <span id="variation_label"></span></label>
                <?php
                  $count = 0;
                  foreach ($variation_materials as $variation) {
                    $count++;
                ?>
                <div class="control-group">
                  <label class="control-label" >Acabamento <?php echo  $count ?>:<span class="variation_label"></span></label>
                  <div class="controls">
                    <input name="materials[material][<?php echo  $variation->id; ?>]" type="text" size="50" maxlength="100" value="<?php echo  $variation->material; ?>" />
                  </div><br>
                  <label class="control-label" >Custo:<span class="variation_label"></span></label>
                  <div class="controls">
                      <input name="materials[variation_cost][<?php echo  $variation->id; ?>]" type="text" size="50" maxlength="100" class="input-medium money" value="<?php echo  $variation->variation_cost; ?>" />
                  </div><br>
                  <label class="control-label" >Valor:<span class="variation_label"></span></label>
                  <div class="controls">
                      <input name="materials[additional_amount][<?php echo  $variation->id; ?>]" type="text" size="50" maxlength="100" class="input-medium money" value="<?php echo  $variation->additional_amount; ?>" />
                  </div>
                  <div class="controls">
                    <a class="btn btn-mini variations_remove_current"><ico class="icon-minus-sign"></ico>&nbsp;Material</a>
                  </div>
                </div>
                <?php
                  }
                  $count++;
                ?>

                <div class="control-group materials_default">
                  <label class="control-label" >Novo Acabamento:<span class="variation_label"></span></label>
                  <div class="controls">
                    <input name="materials[material][]" type="text" size="50" maxlength="100" />
                  </div><br>
                  <label class="control-label" >Custo:<span class="variation_label"></span></label>
                  <div class="controls">
                    <input name="materials[variation_cost][]" type="text" size="50" maxlength="100" class="input-medium money" />
                  </div><br>
                  <label class="control-label" >Valor:<span class="variation_label"></span></label>
                  <div class="controls">
                    <input name="materials[additional_amount][]" type="text" size="50" maxlength="100" class="input-medium money" />
                  </div>
                  <div class="controls">
                    <a class="btn btn-mini variations_remove_current"><ico class="icon-minus-sign"></ico>&nbsp;Material</a>
                  </div>
                </div>
              </div>
              <!-- /Form template -->
              <!-- Variation Controls -->
              <div id="variations_controls" class="controls">
                <div class="control-group">
                  <div id="variations_add" ><a id="materials_add" class="btn btn-mini"><ico class="icon-plus-sign"></ico>&nbsp;Material</a></div>
                </div>
              </div>
              <!-- /Controls -->
            </div>
            <!-- Materials End -->

            <!-- Measurements Start -->
            <div id="measurements">
              <!-- Form template-->
              <div id="measurements_template">
                <label><legend>Medidas:</legend> <span id="variation_label"></span></label>
                <?php
                  $count = 0;
                  foreach ($variation_measurements as $variation) {
                    $count++;
                ?>
                <div class="control-group">
                  <label class="control-label" >Medida <?php echo  $count ?> - Alt.: <span class="variation_label"></span></label>
                  <div class="controls">
                    <input name="measurements[height][<?php echo  $variation->id; ?>]" type="text" size="50" maxlength="100" class="input-small" value="<?php echo  $variation->height; ?>" />
                  </div>
                  <label class="control-label" >Larg.:<span class="variation_label"></span></label>
                  <div class="controls">
                    <input name="measurements[width][<?php echo  $variation->id; ?>]" type="text" size="50" maxlength="100" class="input-small" value="<?php echo  $variation->width; ?>" />
                  </div>
                  <label class="control-label" >Prof.:<span class="variation_label"></span></label>
                  <div class="controls">
                    <input name="measurements[depth][<?php echo  $variation->id; ?>]" type="text" size="50" maxlength="100" class="input-small" value="<?php echo  $variation->depth; ?>" />
                  </div>
                  <label class="control-label" >Custo:<span class="variation_label"></span></label>
                  <div class="controls">
                    <input name="measurements[variation_cost][<?php echo  $variation->id; ?>]" type="text" size="50" maxlength="100" class="input-medium money" value="<?php echo  $variation->variation_cost; ?>" />
                  </div>
                  <label class="control-label" >Valor:<span class="variation_label"></span></label>
                  <div class="controls">
                    <input name="measurements[additional_amount][<?php echo  $variation->id; ?>]" type="text" size="50" maxlength="100" class="input-medium money" value="<?php echo  $variation->additional_amount; ?>" />
                  </div>
                  <div class="controls">
                    <a class="btn btn-mini variations_remove_current"><ico class="icon-minus-sign"></ico>&nbsp;Medida</a>
                  </div>
                </div>
                <?php
                  }
                ?>

                <div class="control-group measurements_default">
                  <label class="control-label" >Nova Medida - Alt.: <span class="variation_label"></span></label>
                  <div class="controls">
                    <input name="measurements[height][]" type="text" size="50" maxlength="100" class="input-small" />
                  </div><br>
                  <label class="control-label" >Larg.:<span class="variation_label"></span></label>
                  <div class="controls">
                    <input name="measurements[width][]" type="text" size="50" maxlength="100" class="input-small" />
                  </div><br>
                  <label class="control-label" >Prof.:<span class="variation_label"></span></label>
                  <div class="controls">
                    <input name="measurements[depth][]" type="text" size="50" maxlength="100" class="input-small" />
                  </div><br>
                  <label class="control-label" >Custo:<span class="variation_label"></span></label>
                  <div class="controls">
                    <input name="measurements[variation_cost][]" type="text" size="50" maxlength="100" class="input-medium money" />
                  </div><br>
                  <label class="control-label" >Valor:<span class="variation_label"></span></label>
                  <div class="controls">
                    <input name="measurements[additional_amount][]" type="text" size="50" maxlength="100" class="input-medium money" />
                  </div>
                  <div class="controls">
                    <a class="btn btn-mini variations_remove_current"><ico class="icon-minus-sign"></ico>&nbsp;Medida</a>
                  </div>
                </div>
              </div>
              <!-- /Form template -->
              <!-- Variation Controls -->
              <div id="variations_controls" class="controls">
                <div class="control-group">
                  <div id="variations_add" ><a id="measurements_add" class="btn btn-mini"><ico class="icon-plus-sign"></ico>&nbsp;Medida</a></div>
                </div>
              </div>
              <!-- /Controls -->
            </div>
            <!-- Measurements End -->
          </div>
          <div class="span4" style="text-align:center;">
            <div class="control-group">
              <h3 class="fileupload-title">Imagens</h3>
              <figure class="upload-frame" style="margin: 0; padding: 0;">
                <span id="dropbox" class="frame" style="display: block; width: 400px; height: 100px; margin-left: 0; border: solid 1px #ccc;" ></span>
              </figure>
              <div id="message"></div>
              <ul id="thumbnails" class="thumbnails">
              </ul>
            </div>
          </div>
        </fieldset>
      </div>

    </div>

    <div class="form-actions">
      <button class="btn btn-primary" type="submit">Salvar</button>
    </div>
  </form>
</div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  <?
  if(!empty($product->category->parent_id)){
    ?>
    set_combo_category('<?php echo $product->category->parent_id?>');
    set_combo_sub_category('<?php echo $product->category_id?>', '<?php echo $product->category->parent_id?>');
    <?
  }else{
    ?>
    set_combo_category('<?php echo $product->category_id?>');
    <?
  }
  ?>

  $('#category').change(function(){
    set_combo_sub_category(false, $(this).val());
  });

  $('.money').maskMoney('mask');
  $('.decimal').maskMoney('mask');

  $('#frm-edit-product').bind('submit', function(){
    $('.money').maskMoney('destroy');
    $('.money').maskMoney({thousands:'', decimal:'.'});
    $('.money').maskMoney('mask');
    $('.decimal').maskMoney('destroy');
    $('.decimal').maskMoney({thousands:'', decimal:'.'});
    $('.decimal').maskMoney('mask');
  });

});
</script>
