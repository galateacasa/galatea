<script type="text/javascript">
$(document).ready(function($) {
  $('#status').val('<?php echo $disponibility->status?>');
});
</script>
<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Editar disponibilidade</h2>
    </div>

    <div class="span12">
      <legend>Status</legend>
      <table class="table table-bordered table-striped ">
        <thead>
          <tr >
            <th>Data</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($disponibility_statuses as $disponibility_status) { ?>
          <tr>
            <td><?php echo  $disponibility_status->create_date ?></td>
            <td><?php echo  disponibility_status_to_literal($disponibility_status->status) ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <div class="box-content">

      <div class="span6">

        <fieldset>
          <form class="form-horizontal">
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
                <textarea id="description" disabled ><?php echo  $disponibility->item->description ?></textarea>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="production_price">Preço de Produção</label>
              <div class="controls">
                <input type="text" disabled id="production_price" value="<?php echo  number_format(set_value('production_price', $disponibility->production_price), 2, ',', '.'); ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="weekly_production">Produção Semanal</label>
              <div class="controls">
                <input type="text" disabled id="weekly_production"  value="<?php echo  set_value('weekly_production', $disponibility->weekly_production); ?>">
              </div>
            </div>

            <div id="variations">
              <legend>Variações</legend>
              <?
              foreach ($disponibility->disponibility_variation->get() as $key => $disponibility_variation) {
                ?>
                <fieldset>
                  <legend><?php echo $disponibility_variation->name?></legend>
                  <?
                  foreach ($disponibility_variation->disponibility_variation_value->get() as $disponibility_variation_value) {
                    ?>
                    <div class="control-group">
                      <label class="control-label" for="weekly_production"><?php echo $disponibility_variation_value->name?></label>
                      <div class="controls">
                        <?
                        if ($disponibility_variation_value->variation_price_percent > 0) {
                          ?>
                          <input type="text" disabled  value="<?php echo  $disponibility_variation_value->variation_price_percent ?>">%
                          <?
                        }else{
                          ?>
                          R$<input type="text" disabled  value="<?php echo  $disponibility_variation_value->variation_price_value ?>">
                          <?
                        }
                        ?>
                      </div>
                    </div>
                    <?
                  }
                  ?>
                </fieldset>
                <?
              }
              ?>
            </div>

          </form>

        </fieldset>
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
        <fieldset>
          <legend>Avaliação</legend>
          <form action="" class="form-horizontal" method="POST">
            <div class="control-group">
              <label class="control-label" for="status">Status</label>
              <div class="controls">
                <select name="status" id="status">
                  <option value="0" ?> Novo</option>
                  <option value="1" ?> Aprovado</option>
                  <option value="2" ?> Rejeitado</option>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="avaliation">Motivo</label>
              <div class="controls">
                <select name="avaliation_id" id="avaliation_id">
                  <option value=""></option>
                  <?
                  foreach ($avaliation_texts as $key => $avaliation) {
                    ?>
                    <option value="<?php echo $avaliation->id?>"><?php echo $avaliation->avaliation?></option>
                    <?
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="message">Mensagem</label>
              <div class="controls">
                <textarea name="message" id="message"></textarea>
              </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
          </form>
        </fieldset>

      </div>
    </div>

  </div>
</div>
