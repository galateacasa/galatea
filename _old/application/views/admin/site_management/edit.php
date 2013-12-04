<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Gerenciamento de Sites - HOME - Edicao</h2>
    </div>
    <div class="box-content">
      <form action="<?php echo  site_url('admin/site_management_home/edit/'.$home_layout->id); ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
        <fieldset>
          <legend><?php echo  $home_layout->name; ?></legend>
          <div class="control-group">
            <label class="control-label" for="name"> Nome </label>
            <div class="controls">
              <input type="text" name="name" id="name" value="<?php echo  set_value('title', $home_layout->name); ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="title"> Imagem </label>
            <div class="controls">
              <img width="100" height="100"  src="<?php echo amazon_url('images/ambiances/'.$home_layout->ambiance->get()->image)?>" alt="">
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
                <?php $ambiance_id = $home_layout->ambiance->get(); ?>
                <?php foreach($ambiances as $ambiance): ?>
                  <?php if($ambiance->id == $ambiance_id->id): ?>
                    <option value="<?php echo  $ambiance->id; ?>" selected="selected"><?php echo  $ambiance->title; ?></option>
                  <?php else: ?>
                    <option value="<?php echo  $ambiance->id; ?>" ><?php echo  $ambiance->title; ?></option>
                  <?php endif; ?>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <?php
            $i = 1;
            foreach($home_layout->item->get() as $item_id):
          ?>
            <div class="control-group">
              <label class="control-label" for="title"> Produto <?php echo  $i; ?> </label>
              <div class="controls">
                <select name="product[]">
                  <?php foreach($items as $item): ?>
                      <?php if($item_id->id == $item->id): ?>
                        <option value="<?php echo  $item->id; ?>" selected="selected"><?php echo  $item->name; ?></option>
                      <?php else: ?>
                        <option value="<?php echo  $item->id; ?>" ><?php echo  $item->name; ?></option>
                      <?php endif; ?>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          <?php
            $i++;
            endforeach;
          ?>

          <div class="form-actions">
            <button class="btn btn-primary" type="submit">Salvar</button>
          </div>
      </form>
    </div>
  </div>
</div>
