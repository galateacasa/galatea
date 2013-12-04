<div class="row-fluid">
  <div class="span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> Textos de avaliação</h2>
      <div class="pull-right">
        <a class="btn btn-primary" href="<?php echo site_url('admin/curadoria/create_avaliation_text')?>">Criar avaliação</a>
      </div>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Avaliaçao</th>
            <th>Data</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?
          foreach ($avaliation_texts as $avaliation_text) {
            ?>
            <tr>
              <td><?php echo $avaliation_text->id?></td>
              <td><?php echo $avaliation_text->avaliation?></td>
              <td><?php echo $avaliation_text->create_date?></td>
              <td>
                <a class="btn btn-info" href="<?php echo site_url('admin/curadoria/edit_avaliation_text/'.$avaliation_text->id)?>">
                  <i class="icon-edit icon-white"></i>
                  Editar
                </a>
                <a onclick="return(confirm('Tem certeza'));" class="btn btn-danger" href="<?php echo site_url('admin/curadoria/remove_avaliation_text/'.$avaliation_text->id)?>">
                  <i class="icon-edit icon-white"></i>
                  Remover
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
