<div class="row-fluid">
  <div class="span12">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-user"></i> Usuários</h2>
      <div class="pull-right">
        <a class="btn btn-primary" href="<?php echo site_url('admin/users/create')?>">Criar usuário</a>
      </div>
    </div>
    <div class="box-content">
      <table class="table table-striped table-bordered bootstrap-datatable datatable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Tipo</th>
            <th>Data de Cadastro</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?
          foreach ($users as $user) {
            ?>
            <tr>
              <td><?php echo $user->id?></td>
              <td><?php echo $user->name?></td>
              <td><?php echo $user->email?></td>
              <td><?php echo role_to_literal($user->role)?></td>
              <td><?php echo $user->create_date?></td>
              <td>
                <?php if ($user->email_confirmed) {
                  ?>
                  <span class="label label-success">Ativo</span>
                  <?
                }else{
                  ?>
                  <span class="label label-warning">Não confirmado</span>
                  <?
                } ?>
              </td>
              <td>
                <a class="btn btn-info" href="<?php echo site_url('admin/users/edit/'.$user->id)?>">
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
