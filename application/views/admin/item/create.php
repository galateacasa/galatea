<script type="text/javascript">
$(document).ready(function(){

});
</script>
<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Criar projeto</h2>
    </div>
    <div class="box-content">
      <form action="" class="form-horizontal" method="post">
        <fieldset>
          <legend>Criar Projeto</legend>
          <div class="span6">
            <div class="control-group">
              <label class="control-label" for="name"> Nome </label>
              <div class="controls">
                <input type="text" name="name" id="name" value="<?php echo  set_value('name'); ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="description">Descriçao</label>
              <div class="controls">
                <textarea type="description" id="description"  name="description"><?php echo  set_value('description'); ?></textarea>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="height">Altura</label>
              <div class="controls">
                <input type="text" id="height" maxlength="3" name="height" value="<?php echo  set_value('height'); ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="width">Largura</label>
              <div class="controls">
                <input type="text" id="width" maxlength="3" name="width" value="<?php echo  set_value('width'); ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="depth">Profundidade</label>
              <div class="controls">
                <input type="text" id="depth" maxlength="3" name="depth" value="<?php echo  set_value('depth'); ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="url">URL</label>
              <div class="controls">
                <input type="text" id="url" maxlength="100" name="url" value="<?php echo  set_value('url'); ?>" >
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="style">Estilo</label>
              <div class="controls">
                <select name="style_id" id="style"></select>
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


            <div id="variations">

              <!-- Form template-->
              <div id="variations_template">
                <div class="control-group">
                  <label for="variations_#index#_variation"><legend>Variação</legend> <span id="variation_label"></span></label>
                  <div class="controls">
                    <input id="variations_#index#_variation" name="item[variations][#index#][variation]" type="text" size="50" maxlength="100" class="input-medium" />
                    <a id="variations_remove_current" class="btn btn-mini"><ico class="icon-minus-sign"></ico></a>
                  </div>
                </div>

                <!-- Embeded sheepIt Form -->
                <div style="overflow:hidden;">
                  <label>Valores</label>

                  <div id="variations_#index#_values">

                    <!-- Form template-->
                    <div id="variations_#index#_values_template">
                      <div class="control-group">
                        <label for="variations_#index#_values_#index_values#_value">Valor <span id="variations_#index#_values_label"></span></label>
                        <div class="controls">
                          <input id="variations_#index#_values_#index_values#_value" name="item[variations][#index#][values][#index_values#][value]" type="text" size="15" maxlength="10" class="input-small" />
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
          </div>
          <div class="span4" style="text-align:center;">
            <?
            $images = array();
            $toview = array(
              'maxUploads' => 5,
              'path' => 'images/items',
              'image_insert' => $images
              );
            $this->load->view('templates/upload_image', $toview);
            ?>
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
