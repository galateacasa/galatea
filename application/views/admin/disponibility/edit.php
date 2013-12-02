<script type="text/javascript">
$(document).ready(function(){
  <?php if ($disponibility->disponibility_variation->get()->exists()) {
    ?>
    variationsForm.inject([
      <?php foreach ($disponibility->disponibility_variation as $key => $disponibility_variation) { ?>
        {
          'variations_#index#_id': "<?php echo $key?>",
          '#form#_#index#_variation': "<?php echo $disponibility_variation->name?>",
          '#form#_#index#_variation-id': "<?php echo $disponibility_variation->id?>",
          <?
          if (!$disponibility_variation->produce) {
            ?>
            '#form#_#index#_no-produce': true,
            <?
          };
          ?>

          'variations_#index#_values': [
          <?php foreach ($disponibility_variation->disponibility_variation_value->get() as $disponibility_variation_value) { ?>
            {
              "value" : "<?php echo $disponibility_variation_value->name?>",
              "value-id" : "<?php echo $disponibility_variation_value->id?>",

              <?
              if ($disponibility_variation_value->variation_price_percent > 0) {
                ?>
                "value_variation" : "<?php echo  number_format($disponibility_variation_value->variation_price_percent, 2, ',', '') ?>",
                "value_type" : "percent"
                <?
              }elseif ($disponibility_variation_value->variation_price_value > 0) {
                ?>
                "value_variation" : "<?php echo  number_format($disponibility_variation_value->variation_price_value, 2, ',', '.'); ?>",
                "value_type" : "money"
                <?
              }
              ?>

              <?
              if (!$disponibility_variation_value->produce) {
                ?>
                ,"no-produce" : true
                <?
              };
              ?>

            },
            <?php } ?>
            ]
          },
          <?php } ?>
          ]);
<?
} ?>

});
</script>
<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Editar disponibilidade</h2>
    </div>
    <div class="box-content">
      <div class="span6">
        <form action="" class="form-horizontal" method="post">
          <fieldset>
            <legend><?php echo  $disponibility->item->name ?> - <?php echo  $disponibility->user->name ?></legend>

            <div class="control-group">
              <label class="control-label" for="name">Nome</label>
              <div class="controls">
                <input type="text" id="name" disabled value="<?php echo  $disponibility->item->name ?>"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="description">Descrição</label>
              <div class="controls">
                <textarea id="description"disabled><?php echo  $disponibility->item->description ?></textarea>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="production_price">Preço de Produção</label>
              <div class="controls">
                <input type="text" id="production_price" name="production_price" value="<?php echo  number_format(set_value('production_price', $disponibility->production_price), 2, ',', '.'); ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="weekly_production">Produção Semanal</label>
              <div class="controls">
                <input type="text" id="weekly_production" name="weekly_production" value="<?php echo  set_value('weekly_production', $disponibility->weekly_production); ?>">
              </div>
            </div>

            <div id="variations">
              <!-- Form template-->
              <div id="variations_template">
                <fieldset>
                  <div class="control-group">
                    <label for="variations_#index#_variation"><legend>Variação</legend> <span id="variation_label"></span></label>
                    <input type="hidden" id="variations_#index#_variation-id" name="disponibility[variations][#index#][variation-id]">
                    <label class="checkbox">
                      <input type="checkbox" id="variations_#index#_no-produce" name="disponibility[variations][#index#][no-produce]" />Não irei produzir esta variação
                    </label>
                    <div class="controls">
                      <input id="variations_#index#_variation" name="disponibility[variations][#index#][variation]" type="text" size="50" maxlength="100" class="input-medium" />

                      <a id="variations_remove_current" class="btn btn-mini"><ico class="icon-minus-sign"></ico></a>
                    </div>
                  </div>

                  <!-- Embeded sheepIt Form -->
                  <div style="overflow:hidden;">
                    <h3>Valores</h3>

                    <div id="variations_#index#_values">

                      <!-- Form template-->
                      <div id="variations_#index#_values_template">
                        <div class="control-group">
                          <label for="variations_#index#_values_#index_values#_value">Valor <span id="variations_#index#_values_label"></span></label>
                          <input type="hidden" id="variations_#index#_values_#index_values#_value-id" name="disponibility[variations][#index#][values][#index_values#][value-id]">
                          <label class="checkbox">
                            <input type="checkbox" id="variations_#index#_values_#index_values#_no-produce" name="disponibility[variations][#index#][values][#index_values#][no-produce]" />Não irei produzir este valor
                          </label>
                          <div class="controls">
                            <input id="variations_#index#_values_#index_values#_value" name="disponibility[variations][#index#][values][#index_values#][value]" type="text" size="15" maxlength="10" class="input-small" />
                            <input id="variations_#index#_values_#index_values#_value_variation" name="disponibility[variations][#index#][values][#index_values#][value_variation]" type="text" size="15" maxlength="10" class="input-mini" />
                            <select id="variations_#index#_values_#index_values#_value_type" name="disponibility[variations][#index#][values][#index_values#][value_type]" class="input-mini" >
                              <option value="percent">%</option>
                              <option value="money">R$</option>
                            </select>
                            <a id="variations_#index#_values_remove_current" class="btn btn-mini"><ico class="icon-minus-sign"></ico></a>
                          </div>
                        </div>
                      </div>
                      <!-- /Form template-->

                      <!-- No forms template -->
                      <div id="variations_#index#_values_noforms_template">Sem valores</div>
                      <!-- /No forms template-->

                      <!-- Values Controls -->
                      <div id="variations_#index#_values_controls" class="pull-right">
                        <div id="variations_#index#_values_add"><a class="btn btn-mini"><ico class="icon-plus-sign"></ico>Valor</a></div>
                      </div>
                      <!-- /Controls -->

                    </div>

                  </div>
                  <!-- /Embeded sheepIt Form -->
                </fieldset>


              </div>
              <!-- /Form template -->

              <!-- No forms template -->
              <div id="variations_noforms_template">Sem Variações</div>
              <!-- /No forms template -->

              <!-- Variation Controls -->
              <div id="variations_controls" class="controls">
                <div class="control-group">
                  <div id="variations_add" ><a class="btn btn-mini"><ico class="icon-plus-sign"></ico>&nbsp;Variação</a></div>
                </div>
              </div>
              <!-- /Controls -->
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
          </fieldset>
        </form>
      </div>
      <div class="span6">
        <fieldset>
          <legend>Imagens</legend>
          <div data-target="#modal-gallery" data-toggle="modal-gallery" id="gallery">
            <?
            foreach ($disponibility->item->item_image->get() as $item_image) {
              ?>
              <div class="span3">
                <a class="thumbnail">
                  <img src="<?php echo  amazon_url('images/items/'.$item_image->image) ?>" alt="">
                </a>
              </div>
              <?
            }
            ?>
          </div>
        </fieldset>

      </div>
    </div>

  </div>
</div>
