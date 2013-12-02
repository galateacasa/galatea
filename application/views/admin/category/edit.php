<script type="text/javascript">
$(document).ready(function(){
 set_combo_category('<?php echo  $category->parent_id ?>', '<?php echo $category->id?>');
});
</script>
<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Editar categoria</h2>
    </div>
    <div class="box-content">
     <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
        <fieldset>
          <legend><?php echo  $category->name ?></legend>
          <div class="control-group">
            <label class="control-label" for="name"> Nome </label>
            <div class="controls">
              <input type="text" name="name" id="name" value="<?php echo  set_value('name', $category->name); ?>">
            </div>
          </div>
          <!-- <div class="control-group">
            <label class="control-label" for="category"> Categoria pai </label>
            <div class="controls">
              <select name="category" id="category"></select>
            </div>
          </div> -->

          <div class="control-group">
            <label class="control-label" for="image">
                Imagem
            </label>
            <div class="controls">
              <figure class="upload-frame" style="margin: 0; padding: 0;">
                <span id="dropbox" class="frame" style="display: block; width: 400px; height: 100px; margin-left: 0; border: solid 1px #ccc;" ></span>
              </figure>
            </div>
          </div>
          <?php if (is_array($free_categories)) { ?>
          <div class="control-group">
            <label class="control-label" for="category"> Sub-categorias:</label>
            <div class="controls">
              <ul id="subcategories">
                <?php
                  foreach($subcategories as $subcategory) {
                    ?>
                      <li id="subCat<?php echo  $subcategory->id ?>">
                        <?php echo  $subcategory->name ?>
                        <input type="hidden" name="subcategories[]" value="<?php echo  $subcategory->id ?>" />
                        <a href="#" class="removeCategory" >remover</a>
                      </li>
                    <?php
                  }
                ?>
              </ul>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="category"> Adicionar sub-categoria:</label>
            <div class="controls">
              <select name="subcategory" id="subcategory">
                <?php
                  foreach ($free_categories as $free_category) {
                    ?>
                      <option value="<?php echo  $free_category->id ?>">
                        <?php echo  $free_category->name ?>
                      </option>
                    <?php
                  }
                ?>
              </select>
              <button class="btn btn-primary" type="button" id="addCategory">Adicionar Categoria</button>
              <script>
                $("#addCategory").click(
                  function(){
                    var id = $('#subcategory').val();
                    var label = $('#subcategory option:selected').text();
                    $('#subcategories').append('<li id="subCat' + id + '">'+ label + '<input type="hidden" name="subcategories[]" value="' + id + '" ><a href="#" class="removeCategory" >remover</a></li>')
                  }
                );

                $('.removeCategory').live('click',
                  function() {
                    $(this).parent().remove();
                  }
                );
              </script>
            </div>
          </div>
          <?php } ?>
        </fieldset>
        <div class="form-actions">
          <button class="btn btn-primary" type="submit">Salvar</button>
        </div>
      </form>
   </div>
 </div>
</div>
