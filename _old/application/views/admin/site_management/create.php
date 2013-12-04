<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Gerenciamento de Sites - HOME</h2>
    </div>
    <div class="box-content">
      <form action="<?php echo  site_url('admin/site_management_home/create'); ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
        <fieldset>
          <legend></legend>
          <div class="control-group">
            <label class="control-label" for="name"> Nome </label>
            <div class="controls">
              <input type="text" name="name" id="name" value="">
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="title"> Layout </label>
            <div class="controls">
              <select name="layout">
                <option>2 produtos</option>
              </select>
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="title"> Ambiente </label>
            <div class="controls">
              <select name="ambiance" id="ambiance">
                <?php foreach($ambiances as $ambiance): ?>
                  <option value="<?php echo  $ambiance->id; ?>" ><?php echo  $ambiance->title; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>


          <div class="control-group">
            <label class="control-label" for="title"> Produto 1 </label>
            <div class="controls">
              <select name="items[]">
                <?php foreach($items as $item): ?>
                  <option value="<?php echo  $item->id; ?>" ><?php echo  $item->name; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="title"> Produto 2 </label>
            <div class="controls">
              <select name="items[]">
                <?php foreach($items as $item): ?>
                  <option value="<?php echo  $item->id; ?>" ><?php echo  $item->name; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>


          <div class="form-actions">
            <button class="btn btn-primary" type="submit">Salvar</button>
          </div>
      </form>
    </div>
  </div>
</div>
