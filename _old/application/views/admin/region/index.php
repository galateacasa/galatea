<div class="row-fluid">
  <div class="span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> Regiões</h2>
      <div class="pull-right">
        <a class="btn btn-primary" href="<?php echo site_url('admin/regions/create')?>">Criar região</a>
      </div>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Data de Cadastro</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?
          foreach ($regions as $region) {
            ?>
            <tr>
              <td><?php echo $region->id?></td>
              <td><?php echo $region->name?></td>
              <td><?php echo $region->create_date?></td>
              <td>
                <a class="btn btn-info" href="<?php echo site_url('admin/regions/edit/'.$region->id)?>">
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
