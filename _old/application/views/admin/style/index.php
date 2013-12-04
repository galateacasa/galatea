<div class="row-fluid">
  <div class="span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-list-alt"></i> Estilos</h2>
      <div class="pull-right">
        <a class="btn btn-primary" href="<?php echo site_url('admin/styles/create')?>">Criar estilo</a>
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
          foreach ($styles as $style) {
            ?>
            <tr>
              <td><?php echo $style->id?></td>
              <td><?php echo $style->name?></td>
              <td><?php echo $style->create_date?></td>
              <td>
                <a class="btn btn-info" href="<?php echo site_url('admin/styles/edit/'.$style->id)?>">
                  <i class="icon-edit icon-white"></i>
                  Editar
                </a>
                <a onclick="return(confirm('Tem certeza'));" class="btn btn-danger" href="<?php echo site_url('admin/styles/remove/'.$style->id)?>">
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
