<div class="row-fluid">
  <div class="span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> Histórico de Projetos <?php echo  $history_title ?></h2>

    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th>Projeto</th>
            <th>Designer</th>
            <th>Email</th>
            <th>Data de Submissão</th>
            <?php if ($history_type == 1) { ?><th>Votos</th><?php } ?>
            <th>Motivo</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?
          foreach ($items as $item) {
            ?>
            <tr>
              <td><?php echo $item->name?></td>
              <td><?php echo $item->user->name?></td>
              <td><?php echo $item->user->email?></td>
              <td><?php echo $item->create_date?></td>
              <?php if ($history_type == 1) { ?> <td><?php echo $item->votes?></td><?php } ?>
              <td><?php echo $item->item_status->message?></td>
              <td>
                <a class="btn btn-info" href="<?php echo site_url('admin/curadoria/item/'.$item->id)?>">
                  <i class="icon-edit icon-white"></i>
                  Editar
                </a>
              </td>
            </tr>
            <?
          }

          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
