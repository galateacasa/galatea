<script type="text/javascript">
$(document).ready(function($) {
  $('#status').val('<?php echo $ambiance->status?>');
});
</script>
<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well" data-original-tile >
      <h2><i class="icon-edit"></i> Editar Inspire-se</h2>
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
          <?php foreach ($ambiance_statuses as $ambiance_status) { ?>
          <tr>
            <td><?php echo  $ambiance_status->create_date ?></td>
            <td><?php echo  disponibility_status_to_literal($ambiance_status->status) ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <div class="box-content">

      <div class="span12">

        <fieldset>
          <form class="form-horizontal">
            <legend><?php echo  $ambiance->name ?> - <?php echo  $ambiance->user->name ?></legend>

            <div class="control-group">
              <label class="control-label" for="name">Nome</label>
              <div class="controls">
                <input type="text" id="name" disabled value="<?php echo  $ambiance->name ?>"/>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="description">Descrição</label>
              <div class="controls">
                <textarea id="description" disabled ><?php echo  $ambiance->description ?></textarea>
              </div>
            </div>

            <div id="variations">
              <legend>Produtos relacionados</legend>
              <table class="table table-striped table-bordered bootstrap-datatable datatable">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Imagem</th>
                    <th>Projeto</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?
                  foreach ($ambiance->item->get() as $key => $ambiance_item) {
                    ?>
                    <td><?php echo $ambiance_item->item->id?></td>
                    <td>
                      <?
                      if (!empty($ambiance_item->item->item_image->get()->image)) {
                        $path = amazon_url('images/items/'.$ambiance_item->item->item_image->get()->image);
                        ?>
                        <img src="<?php echo $path?>" width="100" height="100" alt="<?php echo $ambiance_item->item->name?>">
                        <?
                      }
                      ?>
                    </td>
                    <td><?php echo $ambiance_item->item->name?></td>
                    <td>
                      <div class="btn-group">
                        <a class="btn btn-danger btn-mini delete" onclick="return confirm('Tem Certeza?')" href="<?php echo site_url('admin/ambiances/delete/'.$item_ambiance->id)?>">Excluir</a>
                      </div>
                    </td>
                    <?
                  }
                  ?>
                </tbody>
              </table>
            </fieldset>
        </div>

      </form>

    </fieldset>

    <fieldset>
      <legend>Imagens</legend>
      <div data-target="#modal-gallery" data-toggle="modal-gallery" id="gallery">
        <?
        if (!empty($ambiance->image)) {
          ?>
          <div class="span3">
            <a class="thumbnail">
              <img src="<?php echo  amazon_url('images/ambiances/'.$ambiance->image) ?>" alt="">
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
