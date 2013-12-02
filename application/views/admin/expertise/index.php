<div class="row-fluid">
  <div class="span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> Expertises</h2>
      <div class="pull-right">
        <a class="btn btn-primary" href="<?php echo site_url('admin/expertises/create')?>">Criar expertise</a>
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
          foreach ($expertises as $expertise) {
            ?>
            <tr>
              <td><?php echo $expertise->id?></td>
              <td><?php echo $expertise->name?></td>
              <td><?php echo $expertise->create_date?></td>
              <td>
                <a class="btn btn-info" href="<?php echo site_url('admin/expertises/edit/'.$expertise->id)?>">
                  <i class="icon-edit icon-white"></i>
                  Editar
                </a>
                <a onclick="return(confirm('Tem certeza'));" class="btn btn-danger" href="<?php echo site_url('admin/expertises/remove/'.$expertise->id)?>">
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
